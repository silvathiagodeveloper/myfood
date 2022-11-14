<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->segment(3);

        $rules = [
            'name'      => "required|min:3|max:255",
            'email'     => "required|string|email|max:255|unique:users,email,{$id},id",
            'password'  => ['required', 'confirmed', 'max:16', Rules\password::defaults()],
        ];

        if($this->method() == 'PUT') {
            $rules['password'] = ['nullable', 'confirmed', 'max:16', Rules\password::defaults()];
        }

        return $rules;
    }
}
