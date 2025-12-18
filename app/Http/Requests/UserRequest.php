<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')?->id;
        return [
            'name' => 'required|min:3',
            'email' => 'required|min:3|email|unique:users,email'.$userId,
            'phone' => 'nullable|min:10',
            'password' => $userId ? 'nullable|min:6' : 'required|min:6',
            'qualifications' => 'nullable|array',
            'qualifications.*.title' => 'required|string',
            'qualifications.*.institute' => 'required|string',
            'qualifications.*.year' => 'required|integer',
            'qualifications.*.grade' => 'required|string',
        ];
    }
}
