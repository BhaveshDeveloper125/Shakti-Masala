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
            $history = SalesHistory::paginate(20);
            return response()->json(['history' => $history], 200);
        } catch (Exception $e) {
            return response()->json(['erro' => $e->getMessage()], 500);
        }
    }
}
