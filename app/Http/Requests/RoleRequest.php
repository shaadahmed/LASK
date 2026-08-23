<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        if ($this->isMethod('POST')) {
            $rules['name'] = 'required|string|max:255|unique:roles,name';
        } elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $role = $this->route('role');
            $roleId = is_object($role) ? $role->getKey() : $role;
            $rules['name'] = 'sometimes|required|string|max:255|unique:roles,name,'.$roleId;
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
