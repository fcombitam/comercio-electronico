<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $productCount = Product::whereStatus(Product::STATUS_ACTIVE)->count();
        $clientCount = User::whereType(User::TYPE_CLIENT)->count();
        $orderCount = Order::whereStatus(Order::STATUS_COMPLETED)->count();
        $orderItemCount = OrderItem::count();
        $categoryCount = Category::count();

        return view('dashboard', compact('productCount', 'clientCount', 'orderCount', 'orderItemCount', 'categoryCount'));
    }
}
