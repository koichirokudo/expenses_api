<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー情報を登録する
     * @param StoreUser $request
     * @return JsonResponse
     */
    public function register(StoreUser $request): JsonResponse
    {
        User::create([
            'email'=> $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'ユーザーの登録に成功しました。',
        ], 201, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * 認証済みのユーザー情報を取得する
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
