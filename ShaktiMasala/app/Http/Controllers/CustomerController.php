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
}
