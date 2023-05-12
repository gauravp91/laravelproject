<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\Count;

class CountryController extends Controller
{
    public function create(Request $request)
{
    $validation = Validator::make($request->all(), [
        'name'           => 'required|string|max:255',
        'code'           => 'required|string|max:2|unique:countries,code',
        'continent'      => 'required|string|max:255',
    ]);

    if ($validation->fails()) {
        return response()->json([
            'error'   => true,
            'message' => $validation->errors()
        ]);
    }

    $country = Country::create($request->only(['name', 'code', 'continent']));

    return response()->json([
        'success' => true,
        'message' => 'Country Created Successfully',
        'data'    => $country
    ]);
}

}
