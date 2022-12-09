<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the client is authorized to make this request.
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
        $rules = [
            'name'      => "required|min:3|max:255",
            'email'     => "required|string|email|max:255|unique:clients,email",
            'password'  => ['required', 'confirmed', 'max:16', Rules\password::defaults()],
        ];

        return $rules;
    }
}
