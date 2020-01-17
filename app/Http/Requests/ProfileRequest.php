<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    //ユーザーがデータの更新をする権限を持っているかの確認
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    //バリデーションルールの記述
    public function rules()
    {
        return [
            //
            'name' => 'required|string|max:255',
            //メールアドレスは対象外
            'email' => [Rule::unique('users', 'email')->whereNot('email', $myEmail)],
            'email' => 'required|string|email|max:255',
        ];
    }
}
