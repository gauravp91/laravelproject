<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'status'        => 'required|string|max:255',
            'total_amount'  => 'required|numeric|min:0',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validation->errors()
            ]);
        }

        $order = Order::create($request->only(['user_id', 'status', 'total_amount']));

        return response()->json([
            'success' => true,
            'message' => 'Order Created Successfully',
            'data' => $order
        ]);
    }

    public function getVendorOrdersByContinent($name)
    {
        $vendorOrders = [];

        $countries = Country::where('continent', $name)->get();

        if ($countries->isEmpty()) {
            return response()->json([
                'message' => 'No countries found for given continent'
            ], 404);
        }

        foreach ($countries as $country) {
            $vendors = $country->vendors;

            foreach ($vendors as $vendor) {
                $products = $vendor->products;

                foreach ($products as $product) {
                    $orderItems = $product->orderItems;

                    $totalOrders = 0;

                    foreach ($orderItems as $orderItem) {
                        $totalOrders += $orderItem->quantity;
                    }

                    $vendorOrders[] = [
                        'continent' => $country->continent,
                        'country' => $country->name,
                        'vendor' => $vendor->name,
                        'product' => $product->name,
                        'total_orders' => $totalOrders
                    ];
                }
            }
        }

        return response()->json([
            'vendor_orders' => $vendorOrders
        ], 200);
    }
}
