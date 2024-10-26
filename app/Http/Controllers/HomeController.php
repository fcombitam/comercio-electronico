<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function list()
    {
        $categories = Category::with(['products' => function ($query) {
            $query->whereStatus(Product::STATUS_ACTIVE);
        }])->get();

        foreach ($categories as $category) {
            $category->products = $category->products->shuffle()->take(10);
        }

        return view('home', compact('categories'));
    }

    public function detail(Product $product)
    {
        $validate = false;

        if ($product->status == Product::STATUS_INACTIVE) {
            return redirect()->back();
        }

        $cart = Auth::user()->orders()->whereStatus(Order::STATUS_PENDING)->first();

        if (Auth::check() && $cart->items->contains('product_id', $product->id)) {
            $validate = true;
        }

        return view('products.detail', compact('product', 'validate'));
    }

    public function viewCart()
    {
        $cart = Auth::user()->orders()->whereStatus(Order::STATUS_PENDING)->first();
        return view('products.cart', compact('cart'));
    }

    public function addCart(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($product->status == Product::STATUS_INACTIVE) {
            return redirect()->back();
        }

        $user = Auth::user();

        $order = $user->orders()->whereStatus(Order::STATUS_PENDING)->first();

        if (!$order) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0,
                'status' => Order::STATUS_PENDING
            ]);
        }

        if ($order) {
            if ($order->items->contains('product_id', $product->id)) {
                return redirect()->back()->with('error', 'Este producto ya está en el carrito.');
            }
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al crear el pedido.');
        }

        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Cantidad no permitida.');
        }

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price
        ]);

        $order->total_amount += $request->quantity * $product->price;
        $order->save();

        return redirect()->back();
    }

    public function cartPurchase(Request $request)
    {
        $user = Auth::user();

        $cart = $user->orders()->whereStatus(Order::STATUS_PENDING)->first();

        foreach ($cart->items as $item) {
            $product = $item->product;

            $product->stock -= $item->quantity;
            if ($product->stock <= 0) {
                $product->status = Product::STATUS_INACTIVE;
            }
            $product->save();
        }

        $cart->status = Order::STATUS_COMPLETED;
        $cart->save();

        return redirect()->route('orders.index');
    }

    public function cartDelete(Request $request)
    {
        $user = Auth::user();

        $cart = $user->orders()->whereStatus(Order::STATUS_PENDING)->first();

        $cart->status = Order::STATUS_CANCELLED;
        $cart->save();

        $cart->items()->delete();

        return redirect()->route('orders.index');
    }

    public function removeCart(Product $product)
    {
        $user = Auth::user();

        $cart = $user->orders()->whereStatus(Order::STATUS_PENDING)->first();

        $item = OrderItem::where('order_id', $cart->id)->where('product_id', $product->id)->first();
        $item->delete();

        $cart->total_amount -= $item->price * $item->quantity;
        $cart->save();

        if (!$cart->items) {
            $cart->delete();
        }

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|max:255',
        ]);

        $searchTerm = $request->input('q');

        $products = Product::with('category')
            ->whereStatus(Product::STATUS_ACTIVE)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', "%{$searchTerm}%");
                    });
            })
            ->get();

        return view('search', compact('products'));
    }
}
