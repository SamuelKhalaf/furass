<?php

namespace App\Http\Requests\admin;

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
            'role'          => ['required', 'exists:roles,name'],
        ];
    }

    public function getDto(): UpdateUserDto
    {
        return new UpdateUserDto(
            $this->input('name'),
            $this->input('email'),
            $this->input('phone_number'),
            $this->input('role')
        );
    }
}
