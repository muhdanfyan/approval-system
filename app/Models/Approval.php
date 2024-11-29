<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HasFactory;

class Approval extends Model
{

    protected $fillable = ['expense_id', 'approver_id', 'status_id'];

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class, 'approver_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
