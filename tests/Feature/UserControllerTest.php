<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testRegisterSuccess(): void
    {
        $params = [
            'email' => 'test1@example.com',
            'password' => 'Test12345!'
        ];

        $this->postJson('/api/register', $params)
            ->assertStatus(201)
            ->assertJson([
                'message' => 'ユーザーの登録に成功しました。'
            ]);

        $count = User::where('email', $params['email'])->get()->count();

        $this->assertEquals(1, $count);
    }

    /**
     * @return void
     */
    public function testRegisterUnprocessableEntity(): void
    {
        $this->postJson('/api/register', [])
            ->assertStatus(422)
            ->assertJson([
                'data' => [],
                'status' => 'error',
                'errors' => [
                    'email' => ['メールアドレスが未入力です。'],
                    'password' => ['パスワードが未入力です。'],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testMeSuccess(): void
    {
        $user = User::factory()->create([
            'email' => 'test2@example.com',
            'password' => Hash::make('Test12345!'),
        ]);

        // actingAs: ユーザデータで認証済みの状態にする
        $this->actingAs($user)
            ->getJson('/api/me')
            ->assertStatus(200)
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'password' => $user->password,
                ],
            ]);
    }

    public function testMeUnauthenticated(): void
    {
        $this->getJson('/api/me')
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }
}
