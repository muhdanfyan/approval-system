<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'approver_id', 
        'stage_order'
    ];

    /**
     * Relasi dengan model Approver
     */
    public function approver()
    {
        return $this->belongsTo(Approver::class);
    }

    /**
     * Relasi dengan model Approval
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}