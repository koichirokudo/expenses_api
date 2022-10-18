<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreExpenses extends FormRequest
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
            'types' => ['required', 'integer'],
            'date' => ['required'],
            'user_id' => ['required', 'integer'],
            'category' => ['required', 'string'],
            'money' => ['required', 'integer'],
            'note' => ['max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'types.required' => '通常と異なる操作が行われました。もう一度登録してください。',
            'date.required' => '日時が未入力です。',
            'user_id.required' => '支払い人が未入力です。',
            'category.required' => 'カテゴリが未入力です。',
            'money.required' => '金額が未入力です。',
            'money.integer' => '金額は数値を入力してください。',
            'note.max' => '最大入力文字数は30文字です。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $data = [
            'status' => 'error',
            'summary' => 'validation error.',
            'errors' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }



}
