<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductType;
use Exception;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function AddProductType(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required|string|max:255'
            ]);
            if (ProductType::where('name', $request->name)->exists()) {
                return response()->json(['error' => "$request->name already exists please select the Enter the other Packaging Type."], 409);
            } else {
                $save = ProductType::create($validation);
                if (!$save) {
                    return response()->json(['error' => 'oops!something went wrong, please try again later'], 500);
                }
                return response()->json(['success' => 'Product Type is stored sucessfully']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetProductType()
    {
        try {
            $type = ProductType::all();
            if (!$type) {
                return response()->json(['error' => 'oops!something went wrong, please try again later.'], 500);
            }
            return response()->json(['success' => $type], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function DeleteProductType(Request $request)
    {
        try {
            $validation = $request->validate([
                'id' => 'required|integer'
            ]);
            $delete = ProductType::find($validation['id'])->delete();
            if (!$delete) {
                return response()->json(['error' => 'oops! something went wrong, Please try again Later.'], 500);
            }
            return response()->json(['success' => 'Packaging Type is deleted Successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
