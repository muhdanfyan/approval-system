<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status_id',
    ];

    /**
     * Relasi ke model Approval.
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'expense_id');
    }

    // Relasi ke Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
