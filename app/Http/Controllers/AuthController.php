<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * ログイン認証後、ユーザのアクセストークンを生成する
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            // 認証失敗
            return response()->json([
                'message' => 'メールアドレスまたはパスワードが違います。'
            ], 401);
        }

        return response()->json([
            'message' => 'ログインに成功しました。',
        ]);
    }

}
