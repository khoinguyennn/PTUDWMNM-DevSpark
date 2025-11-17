<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display user's order history
     */
    public function history(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Cho phép tùy chỉnh số items per page
        
        $orders = auth()->user()->orders()
            ->with(['orderItems.course'])
            ->latest()
            ->paginate($perPage);

        // Giữ lại query parameters khi phân trang
        $orders->appends($request->query());

        return view('orders.history', compact('orders'));
    }
}
