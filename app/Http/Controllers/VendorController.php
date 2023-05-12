<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'country_code'  => 'required|string|exists:countries,code',
            'admin_id'      => 'nullable|exists:users,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error'     => true,
                'message'   => $validation->errors()
            ]);
        }

        $vendor = Vendor::create($request->only(['name', 'country_code', 'admin_id']));

        return response()->json([
            'success'   => true,
            'message'   => 'Vendor Created Successfully',
            'data'      => $vendor
        ]);
    }


}
