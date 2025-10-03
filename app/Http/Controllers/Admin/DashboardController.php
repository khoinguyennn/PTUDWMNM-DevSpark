<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_users' => User::where('role', 'student')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recent_courses = Course::with('instructor')->latest()->take(5)->get();
        $recent_users = User::latest()->take(5)->get();
        $recent_orders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_courses', 'recent_users', 'recent_orders'));
    }
}
