<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTenantRequest extends FormRequest
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
            'name'      => "required|min:3|max:40|unique:tenants,name,{$id},id",
            'plan_id'   => "required|integer",
            'cnpj'      => "required|unique:tenants|digits_between:11,14",
            'email'     => "required|string|email|max:255|unique:tenants",
        ];
    }
}
