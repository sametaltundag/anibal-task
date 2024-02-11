<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|confirmed|min:6'
        ];
    }

    public function messages():array
    {
        return [
            'name.required' => 'Ad soyad alanı boş bırakılamaz.',
            'name.min' => 'Ad soyad alanı en az 2 karakterden oluşturulmalıdır.',
            'name.max' => 'Ad soyad alanı en fazla 255 karakterden oluşturulmalıdır.',

            'email.required' => 'E-posta alanı boş bırakılamaz.',
            'email.email' => 'Geçerli bir e-posta adresi yazın.',
            'email.unique' => 'Bu e-posta adresi zaten kayıtlı.',
            'email.max' => 'E-posta alanı en fazla 255 karakterden oluşturulmalıdır.',

            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifrenizi onaylayın. (Şifreler uyuşmuyor)'
        ];
    }
}
