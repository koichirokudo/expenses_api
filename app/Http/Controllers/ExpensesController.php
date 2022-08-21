<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenses;
use App\Models\Budget;

class ExpensesController
{
    public function register(StoreExpenses $request)
    {
        Budget::create([
            'types' => $request->types,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'category' => $request->category,
            'money' => $request->money,
            'note' => $request->note,
        ]);

        return response()->json([
            'message' => '収支の登録に成功しました。',
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }
}
