<?php

namespace App\Http\Requests\Admin;

use App\Dto\CreateUserDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string name
 * @property string email
 * @property string phone_number
 * @property string password
 */
class CreateUserRequest extends FormRequest
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
            'email'         => ['required','email','unique:users,email'],
            'phone_number'  => ['required','string','max:20','unique:users,phone_number'],
            'country_code'  => ['required','string','max:10'],
            'password'      => ['required','string','min:6','confirmed'],
            'role'          => ['required', 'exists:roles,name'],
            'is_active'     => ['nullable', 'boolean'],
        ];
    }

    public function getDto(): CreateUserDto
    {
        return new CreateUserDto(
            $this->input('name'),
            $this->input('email'),
            $this->input('phone_number'),
            $this->input('country_code'),
            $this->input('password'),
            $this->input('role'),
            $this->input('is_active') ?? 0
        );
    }
}
