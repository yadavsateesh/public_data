<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function products()
    {
        $products = Product::where('stock', '>', 0)
            ->latest()
            ->get();

        return view('orders.products', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $order = DB::transaction(function () use ($validated) {

            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($product->stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Required quantity is not available in stock.',
                ]);
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $validated['quantity'],
                'total_amount' => $product->price * $validated['quantity'],
                'status' => 'pending',
            ]);

            $product->decrement('stock', $validated['quantity']);

            return $order;
        });

        $order->load(['user', 'product']);

        $admins = User::where('type', 1)->get();

        Notification::send(
            $admins,
            new NewOrderNotification($order)
        );

        return redirect()
            ->route('orders.my')
            ->with('success', 'Order placed successfully!');
    }

    public function myOrders()
    {
        $orders = Order::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.my-orders', compact('orders'));
    }
}