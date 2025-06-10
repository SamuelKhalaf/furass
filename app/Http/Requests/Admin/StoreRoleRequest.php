<?php

namespace App\Http\Requests\Admin;

use App\Dto\StoreRoleDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string role_name
 * @property array permissions
 */
class StoreRoleRequest extends FormRequest
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
            'role_name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function getDto(): StoreRoleDto
    {
        return new StoreRoleDto(
            $this->input('role_name'),
            $this->input('permissions'),
        );
    }
}
