<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreExpenses;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class ExpensesController
{
    /**
     * 指定した月の収支履歴を取得する
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $budgets = DB::table('budgets')
            ->select('budgets.*','users.name')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->leftJoin('users', 'user_id', '=', 'users.id')
            ->orderByDesc('date')
            ->get();

        return response()->json([
            'list' => $budgets
        ]);
    }

    /**
     * 収支情報を登録する
     * @param StoreExpenses $request
     * @return JsonResponse
     */
    public function register(StoreExpenses $request):JsonResponse
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
            'message' => '登録に成功しました。',
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 今月の支払合計額を Json で返す
     * @return JsonResponse
     */
    public function spend(Request $request): JsonResponse
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $budgets = DB::table('budgets')
            ->where('types', 0)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
        $total = $budgets->map(function ($item) {
            return $item->money;
        })->sum();

        return response()->json([
            'spend' => $total,
        ]);
    }

    /**
     * 今月の収入合計額を Json で返す
     * @return JsonResponse
     */
    public function income(Request $request): JsonResponse
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $budgets = DB::table('budgets')
            ->where('types', 1)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();
        $total = $budgets->map(function ($item) {
            return $item->money;
        })->sum();

        return response()->json([
            'income' => $total,
        ]);
    }
}
