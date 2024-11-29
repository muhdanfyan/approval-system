<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi ke ApprovalStage
     */
    public function approvalStages()
    {
        return $this->hasMany(ApprovalStage::class);
    }

    /**
     * Relasi ke Approval
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}
