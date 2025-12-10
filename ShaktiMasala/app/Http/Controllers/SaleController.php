<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Products;
use App\Models\Sale;
use App\Models\Sales;
use App\Models\SalesHistory;
use Exception;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;
use function PHPUnit\Framework\returnArgument;

class SaleController extends Controller
{
    public function AddSalesData(Request $request)
    {
        try {
            $validation = $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_type' => 'nullable|string|max:255|in:wholesale,retailer',
                'date' => 'required|date',
                'payment_mode' => 'nullable|string|max:255|in:cash,card,upi,cheque',
                'payment_status' => 'required|string|max:255|in:paid,pending,partially paid',
                'partial_amount' => 'nullable|numeric',
                'extra_charges' => 'nullable|numeric',
                'product' => 'required|array|min:1',
                'product.*.name' => 'required|string|max:255',
                'product.*.brand' => 'required|string|max:255',
                'product.*.mrp' => 'required|numeric',
                'product.*.total_packet' => 'required|integer',
                'product.*.price_per_carot' => 'required|numeric',
                'product.*.packaging_type' => 'required|string|max:255|exists:product_types,name',
                'product.*.net_weight' => 'required|numeric',
                'product.*.net_per_unit' => 'required|numeric',
                'product.*.units_per_carton' => 'required|numeric',
                'product.*.batch' => 'required|string|max:255',
                'product.*.mfg_date' => 'nullable|date',
                'product.*.exp_date' => 'nullable|date',
            ]);
            $invoice = DB::table('invoice_generater')->insertGetId([]);

            if (!$invoice) {
                return response()->json(['error' => 'oops!failed to generate the invoice number.']);
            }

            $total_price = collect($validation['product'])->sum(function ($product) {
                return $product['total_packet'] * $product['price_per_carot'];
            });

            // https://claude.ai/chat/5b9bbe0e-b82f-4335-9a91-511e47e432fb
            $save_customer = Customers::create(array_merge(
                [
                    'customer_name' =>  $validation['customer_name'],
                    'customer_type' => $validation['customer_type'] ?? null,
                    'date' =>  $validation['date'],
                    'payment_mode' =>  $validation['payment_mode'] ?? null,
                    'payment_status' =>  $validation['payment_status'],
                    'partial_amount' =>  $validation['partial_amount'] ?? null,
                    'extra_charges' =>  $validation['extra_charges'] ?? null,
                    'total_price' =>  $total_price ?? null,
                ],
                ['invoice' => $invoice]
            ));

            SalesHistory::create([
                'customers_id' => $save_customer->id,
                'invoice' => $save_customer->invoice,
                'customer_name' => $save_customer->customer_name,
                'customer_type' => $save_customer->customer_type,
                'date' => $save_customer->date,
                'payment_mode' => $save_customer->payment_mode,
                'payment_status' => $save_customer->payment_status,
                'partial_amount' => $save_customer->partial_amount,
                'extra_charges' => $save_customer->extra_charges,
                'total_price' => $save_customer->total_price,
            ]);

            if (!$save_customer) {
                return response()->json(['error' => 'oops!something went wrong, customer data are not stored properly'], 500);
            }

            foreach ($validation['product'] as $i) {
                Sale::create([
                    'customer_id' => $save_customer->id,
                    'name' => $i['name'],
                    'brand' => $i['brand'],
                    'mrp' => $i['mrp'],
                    'total_packet' => $i['total_packet'],
                    'price_per_carot' => $i['price_per_carot'],
                    'packaging_type' => $i['packaging_type'],
                    'net_weight' => $i['net_weight'],
                    'net_per_unit' => $i['net_per_unit'],
                    'units_per_carton' => $i['units_per_carton'],
                    'batch' => $i['batch'],
                    'mfg_date' => $i['mfg_date'],
                    'exp_date' => $i['exp_date'],
                ]);
            }
            return response()->json(['success' => 'Order is placed successfully.'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    public function PartiallyPaidPaymentCustomers()
    {
        try {
            $partially = Customers::with('Sale')->where('payment_status', 'partially paid')->get();
            $pending = Customers::with('Sale')->where('payment_status', 'pending')->get();
            return response()->json(['partially' => $partially, 'pending' => $pending], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function TodaySalesData()
    {
        try {
            $sales = Sale::with('Customers')->whereDate('created_at', Carbon::today())->get();
            $HighestToday = Sale::whereDate('created_at', Carbon::today())->orderBy('payable_amount', 'desc')->first();
            $TotalCarton = Sale::whereDate('created_at', Carbon::today())->sum('total_packet');
            $TodaysOrder = Customers::whereDate('created_at', Carbon::today())->count();
            if (!$sales) {
                return response()->json(['error' => 'oops!something went wrong, please tray again later.'], 500);
            }
            return response()->json(['success' => $sales, 'HighestToday' => $HighestToday, 'TotalCarton' => $TotalCarton, 'TodaysOrder' => $TodaysOrder], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function UpdateCustomers(Request $request)
    {

        try {
            $validation = $request->validate([
                'id' => 'required|numeric',
                'customer_name' => 'required|string|max:255',
                'customer_type' => 'nullable|string|max:255|in:wholesale,retailer',
                'date' => 'required|date',
                'payment_mode' => 'nullable|string|max:255|in:cash,card,upi,cheque',
                'payment_status' => 'required|string|max:255|in:paid,pending,partially paid',
                'partial_amount' => 'nullable|numeric',
                'extra_charges' => 'nullable|numeric',
                'name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'mrp' => 'required|numeric',
                'total_packet' => 'required|integer',
                'price_per_carot' => 'required|numeric',
                'packaging_type' => 'required|string|max:255|exists:product_types,name',
                'net_weight' => 'required|numeric',
                'net_per_unit' => 'required|numeric',
                'units_per_carton' => 'required|numeric',
                'batch' => 'required|string|max:255',
                'mfg_date' => 'nullable|date',
                'exp_date' => 'nullable|date',
                'payable_amount' => 'required|numeric'
            ]);

            $update = Sale::find($validation['id'])->update($validation);
            if (!$update) {
                return response()->json(['error' => 'oops,Something went wrong, please try again later.'], 500);
            }
            return response()->json(['success' => 'Sales Data are Updated Successfully.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function PopulatingPartialPaidData($id)
    {
        try {
            $customer = Customers::with('Sale')->where('invoice', $id)->first();
            return view('UnPaidSalesEntry', ['customer' => $customer]);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function UpdateUnpaidCustomers(Request $request)
    {
        try {
            $validation = $request->validate([
                'id' => 'required|numeric',
                'invoice' => 'required|numeric',
                'partial_amount' => 'required|numeric'
            ]);


            $previousData = Customers::find($validation['id']);
            $previousData->partial_amount = $validation['partial_amount'];
            if ($previousData->partial_amount + $validation['partial_amount'] >= $previousData->total_price) {
                Customers::find($validation['id'])->update(['partial_amount' => $validation['partial_amount'] + $previousData->partial_amount, 'payment_status' => 'paid']);
                SalesHistory::create(array_merge(['customers_id' => $previousData->id], $previousData->toArray()));
                return response()->json(['success' => 'Payment Details are updated successfully.'], 200);
            } else {
                if ($previousData->payment_status == 'pending' && $previousData->partial_amount + $validation['partial_amount'] < $previousData->total_price) {
                    Customers::find($validation['id'])->update(['partial_amount' => $validation['partial_amount'] + $previousData->partial_amount, 'payment_status' => 'partially paid']);
                    SalesHistory::create(array_merge(['customers_id' => $previousData->id], $previousData->toArray()));
                    return response()->json(['success' => 'payment Amount is stored and status is changes'], 200);
                } else {
                    Customers::find($validation['id'])->update(['partial_amount' => $validation['partial_amount'] + $previousData->partial_amount]);
                    SalesHistory::create(array_merge(['customers_id' => $previousData->id], $previousData->toArray()));
                }
                return response()->json(['success' => 'Payment Details is updated successfully.'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Dashboard APIS
    public function TotalSales(Request $request)
    {
        try {
            $validation = $request->validate([
                'from' => 'nullable|date',
                'to'   => 'required_with:from|date|nullable',
            ]);

            if (empty($validation['from']) && empty($validation['to'])) {
                $TotalSales = Sale::whereMonth('created_at', Carbon::now()->month)->sum('payable_amount');
            } else if (!empty($validation['from']) && !empty($validation['to'])) {
                $from = Carbon::parse($validation['from'])->startOfDay();
                $to = Carbon::parse($validation['to'])->endOfDay();
                $TotalSales = Sale::whereBetween('created_at', [$from, $to])->sum('payable_amount');
            }

            return response()->json(['success' => $TotalSales], 200);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function HighestSellingProducts(Request $request)
    {
        try {
            $validation = $request->validate([
                'from' => 'nullable|date',
                'to'   => 'required_with:from|date|nullable',
            ]);

            if (empty($validation['from']) && empty($validation['to'])) {
                $HighestSellingProducts = Sale::select('name', DB::raw('SUM(payable_amount) as total_sales'))->groupBy('name')->orderByDesc('total_sales')->limit(20)->get();
                return response()->json(['success' => $HighestSellingProducts], 200);
            } else if (!empty($validation['from']) && !empty($validation['to'])) {
                $from = $request->filled('from') ? Carbon::parse($request->from)->startOfDay() : null;
                $to   = $request->filled('to')   ? Carbon::parse($request->to)->endOfDay()     : null;
                $HighestSellingProducts = Sale::query()->when($from, fn($q) => $q->where('created_at', '>=', $from))->when($to,   fn($q) => $q->where('created_at', '<=', $to))->select('name', DB::raw('SUM(payable_amount) as total_sales'))->groupBy('name')->orderByDesc('total_sales')->limit(20)->get();
            }

            return response()->json(['success' => $HighestSellingProducts], 200);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function SalesChartData(Request $request)
    {
        try {
            $validation = $request->validate([
                'from' => 'nullable|date',
                'to'   => 'nullable|date',
            ]);

            $hasFrom = $request->filled('from');
            $hasTo   = $request->filled('to');

            // Require both dates or neither to avoid partial ranges
            if ($hasFrom xor $hasTo) {
                return response()->json(['error' => 'Please provide both from and to dates or leave both empty.'], 422);
            }

            $from = $hasFrom ? Carbon::parse($request->from)->startOfDay() : Carbon::now()->subDays(29)->startOfDay();
            $to   = $hasTo   ? Carbon::parse($request->to)->endOfDay()     : Carbon::now()->endOfDay();

            $salesData = Sale::whereBetween('created_at', [$from, $to])
                ->select(DB::raw('DATE(created_at) as sale_date'), DB::raw('SUM(payable_amount) as total_sales'))
                ->groupBy('sale_date')
                ->orderBy('sale_date')
                ->get();

            $salesPayload = [
                'labels' => $salesData->pluck('sale_date')->map(fn($date) => Carbon::parse($date)->format('d M'))->values(),
                'data'   => $salesData->pluck('total_sales')->map(fn($value) => round((float) $value, 2))->values(),
            ];

            $productData = Sale::whereBetween('created_at', [$from, $to])
                ->select('name', DB::raw('SUM(payable_amount) as total_sales'))
                ->groupBy('name')
                ->orderByDesc('total_sales')
                ->limit(10)
                ->get();

            $productPayload = [
                'labels' => $productData->pluck('name')->values(),
                'data'   => $productData->pluck('total_sales')->map(fn($value) => round((float) $value, 2))->values(),
            ];

            return response()->json([
                'success'  => true,
                'sales'    => $salesPayload,
                'products' => $productPayload,
                'meta'     => [
                    'from' => $from->toDateString(),
                    'to'   => $to->toDateString(),
                ],
            ], 200);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
