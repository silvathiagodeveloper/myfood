<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rules;

class UpdateUserRequest extends StoreUserRequest
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
        $rules = parent::rules();
        $rules['password'] = ['nullable', 'confirmed', 'max:16', Rules\password::defaults()];
        return $rules;
    }
}
