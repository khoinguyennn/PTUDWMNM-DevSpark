<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.course', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search by order code or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        // Get users for filter dropdown
        $users = User::where('role', 'student')->orderBy('name')->get();

        // Get status counts for statistics
        $stats = [
            'total' => Order::count(),
            'paid' => Order::whereIn('status', ['paid', 'completed'])->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereIn('status', ['paid', 'completed'])->sum('total_amount'),
        ];

        return view('admin.orders.index', compact('orders', 'users', 'stats'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.course', 'payment']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        flash()->success("Trạng thái đơn hàng đã được cập nhật từ '{$oldStatus}' thành '{$request->status}'.");

        return redirect()->back();
    }

    /**
     * Delete order (soft delete or hard delete based on business logic)
     */
    public function destroy(Order $order)
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            flash()->error('Chỉ có thể xóa đơn hàng đã bị hủy.');
            return redirect()->back();
        }

        $orderCode = $order->order_code ?? $order->id;
        
        // Delete related records first
        $order->orderItems()->delete();
        if ($order->payment) {
            $order->payment->delete();
        }
        
        $order->delete();

        flash()->success("Đơn hàng #{$orderCode} đã được xóa thành công.");

        return redirect()->route('admin.orders.index');
    }
}
