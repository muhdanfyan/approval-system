<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproverRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:approvers,name|max:255',
        ];
    }

    public function authorize()
    {
        return true; // Set true untuk mengizinkan semua pengguna
    }
}
