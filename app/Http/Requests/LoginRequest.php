<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:10', 'max:24'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスが未入力です。',
            'email.email' => 'メールアドレスとして正しい形式ではありません。',
            'email.max' => '最大入力文字数は255文字です。',
            'password.required' => 'パスワードが未入力です。',
            'password.min' => '最低10文字以上のパスワードを入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $data = [
            'data' => [],
            'status' => 'error',
            'summary' => 'バリデーションに失敗しました。',
            'errors' => $validator->errors()->toArray(),
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }
}
