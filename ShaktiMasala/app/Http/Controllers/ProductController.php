<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function GetProductDetails()
    {
        try {
            $product = Products::paginate(20);
            if (!$product) {
                return response()->json(['error' => 'oops, something went wrong, please try again later.'], 500);
            }
            return response()->json(['product' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function AddProduct(Request $request)
    {


        try {
            $validation = $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png',
                'name' => 'required|string|max:255',
                'brand_name' => 'required|string|max:255',
                'total_packet' => 'required|numeric',
                'price_per_carot' => 'required|numeric',
                'mrp' => 'required|numeric',
                'packaging_type' => 'required|exists:product_types,name',
                'net_weight' => 'required|numeric',
                'net_per_unit' => 'required|numeric',
                'units_per_carton' => 'required|integer',
                'batch' => 'required|nullable',
                'mfg_date' => 'required|date',
                'exp_date' => 'required|date'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('Product Image', 'public');
                $validation['image'] = "/storage/$path";
            }
            $save = Products::create($validation);

            if (!$save) {
                return response()->json(['error' => 'oops! something went wrong, please try again later.'], 500);
            }
            return response()->json(['success' => 'Product data are stored successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function PopulateProduct($id)
    {
        try {
            $product = Products::find($id);
            $productType = ProductType::all();
            return view('PopulateProductData')->with(['product' => $product, 'productType' => $productType], 200);
        } catch (Exception $e) {
            return redirect()->back()->with('error', "Populating Product Data : " . $e->getMessage());
        }
    }

    public function UpdateProduct(Request $request)
    {
        try {
            $validation = $request->validate([
                'image' => 'image|mimes:jpg,jpeg,png',
                'name' => 'required|string|max:255',
                'brand_name' => 'required|string|max:255',
                'total_packet' => 'required|numeric',
                'price_per_carot' => 'required|numeric',
                'mrp' => 'required|numeric',
                'packaging_type' => 'required|exists:product_types,name',
                'net_weight' => 'required|numeric',
                'net_per_unit' => 'required|numeric',
                'units_per_carton' => 'required|integer',
                'batch' => 'required|nullable',
                'mfg_date' => 'required|date',
                'exp_date' => 'required|date',
                'product_id' => 'required',
            ]);

            if (Products::where('product_id', $validation['product_id'])->exists()) {
                if ($request->hasFile('image')) {
                    $oldImage = Products::where('product_id', $validation['product_id'])->first();
                    if (File::exists($oldImage->image)) {
                        File::delete($oldImage->image);
                    }
                    $path = $request->file('image')->store('Product Image', 'public');
                    $validation['image'] = "/storage/$path";
                }

                $update = Products::where('product_id', $validation['product_id'])->update($validation);
                if (!$update) {
                    return redirect()->back()->with('error', 'oops! Something went wrong, please try again later.');
                }
                return redirect()->back()->with('success', 'Product Data are update Successfully');
            } else {
                return redirect()->back()->with('error', "Entry Does not exists with the ID " . $validation['product_id']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }

    public function DeleteProduct(Request $request)
    {
        try {
            $validation = $request->validate([
                'id' => 'required|numeric',
            ]);

            $delete = Products::find($validation['id'])->delete();

            if (!$delete) {
                return response()->json(['error' => 'oops! something went wrong, please try again later.'], 500);
            }

            return response()->json(['success' => 'Data are delete successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ProductOverview()
    {
        try {
            $totalProducts = Products::count();
            $highestStock = Products::orderBy('units_per_carton', 'desc')->select('units_per_carton', 'name')->first();
            $lowestStock = Products::orderBy('units_per_carton', 'asc')->select('units_per_carton', 'name')->first();
            $expiry = Products::where('exp_date', '<=', now())->select('name', 'exp_date')->get();
            $expires = Products::where('exp_date', '>=', now())->where('exp_date', '<=', now()->addDays(30))->select('exp_date', 'name')->get();
            return response()->json(['totalProducts' => $totalProducts, 'highestStock' => $highestStock, 'lowestStock' => $lowestStock, 'expiry' => $expiry, 'expires' => $expires], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
