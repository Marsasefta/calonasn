<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare input before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => strip_tags(trim((string) $this->input('name'))),
            ]);
        }

        if ($this->has('phone') && $this->input('phone') !== null) {
            $this->merge([
                'phone' => trim((string) $this->input('phone')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.,\'\-]+$/u'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'min:8', 'max:20', 'regex:/^[0-9+\s\-]+$/'],
        ];
    }

    /**
     * Pesan error validasi dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 100 karakter.',
            'name.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, koma, tanda petik, atau tanda hubung.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan akun lain.',
            'phone.min' => 'Nomor WhatsApp / HP minimal 8 digit.',
            'phone.max' => 'Nomor WhatsApp / HP maksimal 20 karakter.',
            'phone.regex' => 'Nomor WhatsApp / HP hanya boleh berisi angka, spasi, +, atau -.',
        ];
    }
}
