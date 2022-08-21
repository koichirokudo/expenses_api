<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10', 'max:24'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ニックネームが未入力です。',
            'name.min' => 'ニックネームは3文字から20字まで入力できます。',
            'name.max' => 'ニックネームは3文字から20字まで入力できます。',
            'email.required' => 'メールアドレスが未入力です。',
            'email.email' => 'メールアドレスとして正しい形式ではありません。',
            'email.max' => '最大入力文字数は255文字です。',
            'email.unique' => '既に登録されているメールアドレスです。',
            'password.required' => 'パスワードが未入力です。',
            'password.min' => '最低10文字以上のパスワードを入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $data = [
            'data' => [],
            'status' => 'error',
            'summary' => 'validation error.',
            'errors' => $validator->errors()->toArray(),
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }
}
