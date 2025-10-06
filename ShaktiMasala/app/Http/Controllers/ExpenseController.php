<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Exception;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function AddExpenses(Request $request)
    {
        try {
            $validation = $request->validate([
                'expense_name' => 'required|string|max:255',
                'expense' => 'required|numeric|min:0',
                'date' => 'required|date',
                'description' => 'nullable|string',
            ]);

            $save = Expense::create($validation);

            if (!$save) {
                return response()->json(['error' => 'oops! something went wrong while storing the expenses, please try again later'], 500);
            }

            return response()->json(['success' => 'Expense Data are stored Successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function GetAllExpenses()
    {
        try {
            $expenses = Expense::orderBy('created_at', 'desc')->paginate(20);

            if (!$expenses) {
                return response()->json(['error' => 'error while fetching Expenses Data.'], 500);
            }

            return response()->json(['expenses' => $expenses]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
