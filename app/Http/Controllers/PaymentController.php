<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayOSService;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $payOSService;

    public function __construct(PayOSService $payOSService)
    {
        $this->payOSService = $payOSService;
    }

    /**
     * Create payment for course enrollment
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        try {
            DB::beginTransaction();

            $course = Course::findOrFail($request->course_id);
            $user = Auth::user();

            // Check if user already enrolled
            $existingEnrollment = DB::table('course_enrollments')
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->exists();

            if ($existingEnrollment) {
                return redirect()->back()->with('error', 'Bạn đã đăng ký khóa học này rồi!');
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $course->price,
                'status' => 'pending'
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->price
            ]);

            // Generate unique order code
            $orderCode = intval(substr(strval(microtime(true) * 10000), -6));

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => 'payos',
                'amount' => $course->price,
                'status' => 'pending'
            ]);

            // Prepare payment data
            $paymentData = [
                'order_code' => $orderCode,
                'amount' => (int)($course->price), // PayOS requires integer amount
                'description' => "Thanh toan khoa hoc", // Tối đa 25 ký tự
                'items' => [
                    [
                        'name' => mb_substr($course->title, 0, 20), // Giới hạn tên item
                        'quantity' => 1,
                        'price' => (int)($course->price)
                    ]
                ],
                'buyer_name' => $user->name,
                'buyer_email' => $user->email,
                'expired_at' => now()->addMinutes(15)->timestamp // 15 minutes expiry
            ];

            // Create payment link
            $result = $this->payOSService->createPaymentLink($paymentData);

            if ($result['success']) {
                // Update payment with transaction details
                $payment->update([
                    'transaction_id' => $orderCode,
                    'status' => 'pending'
                ]);

                // Update order with order code
                $order->update(['order_code' => $orderCode]);

                DB::commit();

                // Redirect to PayOS checkout
                return redirect($result['data']['checkoutUrl']);
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Không thể tạo liên kết thanh toán: ' . $result['message']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo thanh toán');
        }
    }

    /**
     * Handle successful payment return
     */
    public function paymentSuccess(Request $request)
    {
        $orderCode = $request->get('orderCode');
        
        if (!$orderCode) {
            return redirect()->route('home')->with('error', 'Không tìm thấy thông tin đơn hàng');
        }

        try {
            // Find the order
            $order = Order::where('order_code', $orderCode)->first();
            
            if (!$order) {
                return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng');
            }

            // Check if already processed
            if ($order->status === 'paid') {
                return view('payment.success')->with('success', 'Đơn hàng đã được xử lý thành công trước đó!');
            }

            DB::beginTransaction();

            // Update order status
            $order->update(['status' => 'paid']);

            // Update payment status
            $payment = Payment::where('order_id', $order->id)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now()
                ]);
            }

            // Create course enrollment
            $orderItem = OrderItem::where('order_id', $order->id)->first();
            $course = null;
            if ($orderItem) {
                DB::table('course_enrollments')->updateOrInsert([
                    'user_id' => $order->user_id,
                    'course_id' => $orderItem->course_id
                ], [
                    'enrolled_at' => now(),
                    'created_at' => now()
                ]);
                
                // Get course info for redirect
                $course = Course::find($orderItem->course_id);
            }

            DB::commit();

            return view('payment.success', compact('course'))->with('success', 'Thanh toán thành công! Bạn đã được đăng ký vào khóa học.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment success handling error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Có lỗi xảy ra khi xử lý thanh toán');
        }
    }

    /**
     * Handle payment cancellation
     */
    public function paymentCancel(Request $request)
    {
        $orderCode = $request->get('orderCode');
        
        if ($orderCode) {
            // Find and cancel the order
            $order = Order::where('order_code', $orderCode)->first();
            if ($order) {
                $order->update(['status' => 'cancelled']);
                
                $payment = Payment::where('order_id', $order->id)->first();
                if ($payment) {
                    $payment->update(['status' => 'failed']);
                }
            }
        }

        return view('payment.cancel');
    }

    /**
     * Handle payment webhook
     */
    public function paymentWebhook(Request $request)
    {
        try {
            $webhookData = $request->all();
            
            // Verify webhook data
            $result = $this->payOSService->verifyWebhookData($webhookData);
            
            if ($result['success']) {
                $data = $result['data'];
                $orderCode = $data['orderCode'];
                
                // Find the order
                $order = Order::where('order_code', $orderCode)->first();
                
                if ($order && $data['code'] === '00') { // Success code
                    DB::beginTransaction();

                    // Update order status
                    $order->update(['status' => 'paid']);

                    // Update payment status
                    $payment = Payment::where('order_id', $order->id)->first();
                    if ($payment) {
                        $payment->update([
                            'status' => 'success',
                            'paid_at' => now()
                        ]);
                    }

                    // Create course enrollment
                    $orderItem = OrderItem::where('order_id', $order->id)->first();
                    if ($orderItem) {
                        DB::table('course_enrollments')->updateOrInsert([
                            'user_id' => $order->user_id,
                            'course_id' => $orderItem->course_id
                        ], [
                            'enrolled_at' => now(),
                            'created_at' => now()
                        ]);
                    }

                    DB::commit();
                }
                
                return response()->json(['success' => true]);
            } else {
                Log::error('Webhook verification failed: ' . $result['message']);
                return response()->json(['success' => false], 400);
            }
            
        } catch (\Exception $e) {
            Log::error('Webhook handling error: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
