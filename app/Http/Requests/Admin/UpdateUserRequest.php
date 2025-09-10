<?php

namespace App\Http\Requests\Admin;

use App\Dto\UpdateUserDto;
use App\Enums\RoleEnum;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property string name
 * @property string email
 * @property string phone_number
 * @property string country_code
 * @property string role
 */
class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required','string','max:20','min:3'],
            'email'         => ['required','email','unique:users,email,' . $this->route('user')],
            'phone_number'  => ['required','string','max:20','min:11','unique:users,phone_number,' . $this->route('user')],
            'country_code'  => ['required','string','max:10'],
            'role'          => ['required', 'exists:roles,name'],
            'is_active'     => ['nullable', 'boolean'],
        ];
    }

    public function getDto(): UpdateUserDto
    {
        return new UpdateUserDto(
            $this->input('name'),
            $this->input('email'),
            $this->input('phone_number'),
            $this->input('country_code'),
            $this->input('role'),
            $this->input('is_active') ?? 0
        );
    }
}
