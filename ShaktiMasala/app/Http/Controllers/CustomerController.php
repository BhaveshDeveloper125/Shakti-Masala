<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function PaymentDetails()
    {
        try {
            $PendingPayments = Customers::with('Sale')->where('payment_status', 'pending')->get();
            $PartiallyPaid = Customers::with('sale')->where('payment_status', 'pending')->get();
            if (!$PendingPayments) {
                return response()->json(['error' => 'oops,Something went wrong, please try again later.']);
            }
            return response()->json(['success' => $PendingPayments], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetSalesHistoryFromInvoice($id)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json(['error' => 'ID must be a number Type'], 500);
            }

            if (Customers::where('invoice', $id)->exists()) {
                $bill = Customers::where('invoice', $id)->first();
                return response()->json(['bill' => $bill], 200);
            } else {
                return response()->json(['error' => "$id does not exists."], 404);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
