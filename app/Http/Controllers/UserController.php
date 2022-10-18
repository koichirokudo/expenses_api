<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * ユーザ一覧を取得する
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = DB::table('users')->get();
        return response()->json(['user' => $users]);
    }
}
