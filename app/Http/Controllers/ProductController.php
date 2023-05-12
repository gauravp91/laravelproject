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

        Product::create($request->only(['name','price','vendor_id','status'])+[
            'image' => 'ancd'
        ]);

        return redirect()->back()->with('success','product created');
    }
}
