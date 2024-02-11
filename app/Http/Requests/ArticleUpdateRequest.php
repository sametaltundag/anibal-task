<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'min:3|max:255',
            'content' => 'min:1',
            'status' => 'boolean',
            'category_id' => 'exists:categories,id',
            'category_slug' => 'exists:categories,slug'
        ];
    }

    public function messages(){
        return [
            'title.min' => 'Başlık en az 3 karakterden oluşturulmalıdır',
            'title.max' => 'Başlık en fazla 255 karakterden oluşturulmalıdır',
            'content.min' => 'İçerik en az 1 karakterden oluşturulmalıdır',
            'status.boolean' => 'Durum alanı gecerli bir deger olmalıdır.',
            'category_id.exists' => 'Kategori bulunamadı.',
            'category_slug.exists' => 'Kategori bulunamadı.'
        ];
    }
}
