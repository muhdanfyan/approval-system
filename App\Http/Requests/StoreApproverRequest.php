<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApproverRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Sesuaikan jika ada mekanisme otorisasi.
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:approvers,name|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama approver harus diisi.',
            'name.unique' => 'Nama approver harus unik.',
        ];
    }
}
