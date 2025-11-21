<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // バリデーションルールを記載する
            'title' => ['required', 'max:20'],
            'content' => ['required', 'max:200'],
            'person_in_charge' => ['required', 'max:100'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'    => '[タイトル]は必須です。',
            'content.required'    => '[内容]は必須です。',
            'person_in_charge.required'    => '[担当者]は必須です。',
            'title.max'    => '[タイトル]は20文字以内で入力してください。',
            'content.max'    => '[コンテンツ]は200文字以内で入力してください。',
            'person_in_charge.max'    => '[担当者]は100文字以内で入力してください。',
        ];
    }
}
