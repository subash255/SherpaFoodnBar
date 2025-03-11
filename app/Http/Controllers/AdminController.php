<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Order;
use App\Models\Visit;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalvisits = Visit::sum('number_of_visits');
        $date = \Carbon\Carbon::today()->subDays(30);
        $visitdate = Visit::where('visit_date', '>=', $date)->pluck('visit_date');
        $visits = Visit::where('visit_date', '>=', $date)->pluck('number_of_visits');
        $totalorder=Order::count();
        $totalorderPending=Order::where('status','pending')->count();
        $totalorderCompleted=Order::where('status','completed')->count();
        $totalreservation=Booking::count();
        $revenue=Order::where('status','completed')->sum('total');
        $categories = Category::withCount('fooditems')->get();
        $categoryLabels = [];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryLabels[] = $category->name;
            $categoryData[] = $category->fooditems_count;
        }

           // Fetch orders grouped by day for the line chart
    $orders = Order::selectRaw('DATE(created_at) as order_date, COUNT(*) as total_orders')
    ->groupBy('order_date')
    ->orderBy('order_date', 'asc') // Ensure chronological order
    ->get();

$orderLabels = [];
$orderData = [];

foreach ($orders as $order) {
    $orderLabels[] = $order->order_date;
    $orderData[] = $order->total_orders;
}


        return view('admin.dashboard', [
            'title' => 'Dashboard' 
        ], compact('totalvisits', 'visitdate', 'visits','totalorder','totalorderPending','totalorderCompleted','totalreservation','revenue', 'categoryLabels', 'categoryData','orderLabels', 'orderData'));

    }

  
}
