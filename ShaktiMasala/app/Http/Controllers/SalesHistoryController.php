<?php

namespace App\Http\Controllers;

use App\Models\SalesHistory;
use Exception;
use Illuminate\Http\Request;

class SalesHistoryController extends Controller
{
    public function GetSalesHistory()
    {
        try {
            $history = SalesHistory::where('created_at', '>=', now()->subMonths(3))->paginate(20);
            return response()->json(['history' => $history], 200);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], 500);
        }
    }
}
