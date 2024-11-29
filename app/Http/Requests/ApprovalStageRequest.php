<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalStageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'approver_id' => 'required|exists:approvers,id', // Pastikan approver_id ada di tabel approvers
            'stage_order' => 'required|integer|unique:approval_stages,stage_order', // stage_order harus unik
        ];
    }

    public function authorize()
    {
        return true; // Izinkan permintaan ini
    }

    public function messages()
    {
        return [
            'approver_id.required' => 'Approver ID is required.',
            'approver_id.exists' => 'The selected approver does not exist.',
            'stage_order.required' => 'Stage order is required.',
            'stage_order.unique' => 'The stage order must be unique.',
            'stage_order.integer' => 'Stage order must be an integer.',
        ];
    }
}
