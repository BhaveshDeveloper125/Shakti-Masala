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
                'product_id' => 'required|numeric|exists:products,id|unique:product_costings,product_id',
                'raw_material' => 'required|numeric',
                'labour' => 'required|numeric',
                'other_expense' => 'nullable|numeric',
                'product_type' => 'required|string|exists:product_types,name',
                'total_unit_produced' => 'required|numeric',
            ], [
                'product_id' => 'Product Costing for this Product Already Exists.',
            ]);

            ProductCosting::create($validation);
            return response()->json(['success' => 'Product Costing data are saved success fully.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetCostingPage($id)
    {
        try {
            if (!Products::where('id', $id)->exists()) {
                return redirect()->back()->with(['error' => 'Product does not exists.']);
            }
            $ProductType = ProductType::all();
            $CostingData = ProductCosting::where('product_id', $id)->with('product')->get();
            $TotalLabour = ProductCosting::sum('labour');
            $TotalRawMaterials = ProductCosting::sum('raw_material');
            $TotalOtherExpenses = ProductCosting::sum('other_expense');
            return view('ProductCostingCreation', ['id' => $id, 'ProductType' => $ProductType, 'CostingData' => $CostingData, 'TotalLabour' => $TotalLabour, 'TotalRawMaterials' => $TotalRawMaterials, 'TotalOtherExpenses' => $TotalOtherExpenses]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function EdiProductCosting($id)
    {
        try {
            $ProductType = ProductType::all();
            $ProductCosting = ProductCosting::where('product_id', $id)->first();
            return view('EditProductCosting', ['ProductCosting' => $ProductCosting, 'ProductType' => $ProductType]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function Update(Request $request)
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
            unset($validation['product_id']);
            ProductCosting::where('product_id', $request->product_id)->update($validation);
            return response()->json(['success' => 'Product Costing Data are updated successfully.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
