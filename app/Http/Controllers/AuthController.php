<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    /**
     * ユーザー情報を登録する
     * @param StoreUser $request
     * @return JsonResponse
     */
    public function register(StoreUser $request): JsonResponse
    {
        User::create([
            'name' => $request->name,
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
