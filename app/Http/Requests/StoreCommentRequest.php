<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment_id' => ['nullable', 'exists:comments,id'],
            'text' => ['required_without:images', 'string', 'max:255'],
            'images' => ['nullable', 'array', 'min:1', 'max:8'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,gif', 'max:24576'],
        ];
    }
}
