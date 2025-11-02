<?php

namespace App\Http\Controllers;

use App\Models\ProductCosting;
use App\Models\Products;
use App\Models\ProductType;
use Exception;
use Illuminate\Http\Request;

class ProductCostingcontroller extends Controller
{
    public function AddProductCosting(Request $request)
    {
        try {
            $validation = $request->validate([
                'product_id' => 'required|numeric|exists:products,id',
                'raw_material' => 'required|numeric',
                'labour' => 'required|numeric',
                'other_expense' => 'nullable|numeric',
                'product_type' => 'required|string|exists:product_types,name',
                'total_unit_produced' => 'required|numeric',
            ]);

            $save = ProductCosting::create($validation);
            return response()->json(['sucess' => 'Product Costing data are saved success fully.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function GetCostingPage($id)
    {
        try {
            if (!Products::where('id', $id)->exists()) {
                return redirect()->back()->with(['error' => 'Product does not exists.']);
            }
            $ProductType = ProductType::all();
            return view('ProductCostingCreation', ['id' => $id, 'ProductType' => $ProductType]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
