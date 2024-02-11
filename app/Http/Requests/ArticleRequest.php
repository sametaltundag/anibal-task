<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|min:3|max:255',
            'content' => 'required|min:1',
            'status' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Başlık alanı boş geçilemez.',
            'title.min' => 'Başlık en az 3 karakterden oluşturulmalıdır',
            'title.max' => 'Başlık en fazla 255 karakterden oluşturulmalıdır',
            'content.required' => 'İçerik alanı boş geçilemez',
            'content.min' => 'İçerik en az 1 karakterden oluşturulmalıdır',
            'status.required' => 'Durum alanı boş gecilemez',
            'status.boolean' => 'Durum alanı gecerli bir deger olmalıdır.',
            'user_id.exists' => 'Kullanıcı bulunamadı.',
            'category_id.required' => 'Kategori alanı boş gecilemez',
            'category_id.exists' => 'Kategori bulunamadı.',
        ];
    }
}
