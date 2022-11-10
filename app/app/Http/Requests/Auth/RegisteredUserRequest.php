<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisteredUserRequest extends FormRequest
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

        return [
            'name'      => ['required', 'string', 'max:255'],
            'tenantname'=> ['required', 'string', 'max:40', 'unique:tenants,name'],
            'plan_id'   => ['required', 'integer'],
            'cnpj'      => ['required', 'unique:tenants', 'digits_between:11,14'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', Rules\password::defaults()],
        ];
    }
}
