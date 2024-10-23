<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->role == Role::ADMIN->status() || $this->id == auth()->user()->id;
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => __('model.user.name'),
            'class' => __('model.user.class'),
            'nisn' => __('model.user.nisn'),
            'school_year' => __('model.user.school_year'),
            'place_of_birth' => __('model.user.place_of_birth'),
            'date_of_birth' => __('model.user.date_of_birth'),
            'gender' => __('model.user.gender'),
            'religion' => __('model.user.religion'),
            'email' => __('model.user.email'),
            'nilai_ipa' => __('model.user.nilai_ipa'),
            'nilai_ips' => __('model.user.nilai_ips'),
            'phone' => __('model.user.phone'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'class' => ['nullable'],
            'nisn' => ['required', Rule::unique('users')->ignore($this->id)],
            'school_year' => ['nullable'],
            'place_of_birth' => ['nullable'],
            'date_of_birth' => ['nullable'],
            'gender' => ['nullable'],
            'religion' => ['nullable'],
            'email' => ['required', Rule::unique('users')->ignore($this->id)],
            'phone' => ['nullable'],
            'nilai_ipa' => ['nullable'],
            'nilai_ips' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }
}