<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display user's order history
     */
    public function history()
    {
        $orders = auth()->user()->orders()
            ->with(['orderItems.course'])
            ->latest()
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }
}
