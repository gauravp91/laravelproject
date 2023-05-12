<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Product;

class OrderItemController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'order_id'      => 'required|exists:orders,id',
            'product_id'    => 'required|exists:products,id',
            'quantity'      => 'required|integer|min:1',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }

        $orderId = $request->input('order_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $order = Order::find($orderId);
        $product = Product::find($productId);
        $price = $product->price;
        $gst = 0.00;

        $order->products()->attach($product->id, [
            'quantity' => $quantity,
            'price' => $price,
            'gst' => $gst
        ]);

        return redirect()->back()->with('success', 'Order item added successfully.');
    }
}
