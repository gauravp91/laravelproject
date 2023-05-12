<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function productForm()
    {
        $vendors = Vendor::all();
        return view('product', compact('vendors'));
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:255',
            'price'         => 'required|numeric',
            'vendor_id'     => 'required|exists:vendors,id',
            'status'        => 'required|in:active,inactive',
            'image' => 'required',
        ]);

        if ($validation->fails())
            return redirect()->back()->withErrors($validation)->withInput();

        $image = $request->file('image');
        $fileName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images', $fileName);

        Product::create($request->only(['name', 'price', 'vendor_id', 'status']) + [
            'image' => 'ancd'
        ]);

        return redirect()->back()->with('success', 'product created');
    }

    public function show()
    {
        $products = Product::all();
        return view('show', compact('products'));
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    }

    public function updateForm($id)
    {
        $product = Product::find($id);
        $vendors = Vendor::all();
        return view('update', compact('vendors'))->with('product', $product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $validation = Validator::make($request->all(), [
            'name'          => 'required|max:255',
            'price'         => 'required|numeric',
            'vendor_id'     => 'required|exists:vendors,id',
            'status'        => 'required|in:active,inactive',
            'image_path'    => 'required',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('image_path');
        $fileName = time() . '_' . $image->getClientOriginalName();
        $image->storeAs('public/images', $fileName);

        $product->update($request->only(['name', 'price', 'vendor_id', 'status']) + [
            'image' => $fileName
        ]);

        return redirect()->back()->with('success', 'Product updated successfully');
    }
}
