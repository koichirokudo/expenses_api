<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @return void
     */
    public function testLoginSuccess(): void
    {
        User::factory()->create([
            'email' => 'test2@example.com',
            'password' => Hash::make('Test12345!'),
        ]);

        $params = [
            'email' => 'test2@example.com',
            'password' => 'Test12345!',
        ];

        $this->postJson('/api/login', $params)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'ログインに成功しました。',
            ]);
    }

    /**
     * @return void
     */
    public function testLoginUnauthenticated(): void
    {
        User::factory()->create([
            'email' => 'test3@example.com',
            'password' => Hash::make('Test12345!'),
        ]);

        $params = [
            'email' => 'test3@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/login', $params)
            ->assertStatus(422)
            ->assertJson([
                'data' => [],
                'status' => 'error',
                'summary' => 'バリデーションに失敗しました。',
                'errors' => [
                    'password' => ['最低10文字以上のパスワードを入力してください。'],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testLoginUnprocessableEntity(): void
    {
        $this->postJson('/api/login', [])
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['メールアドレスが未入力です。'],
                    'password' => ['パスワードが未入力です。'],
                ],
            ]);
    }

}
