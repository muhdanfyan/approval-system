<?php

namespace App\Services;

use App\Models\Approver;

class ApproverService
{
    /**
     * Buat approver baru
     * 
     * @param array $data
     * @return Approver
     */
    public function createApprover(array $data): Approver
    {
        return Approver::create($data);
    }
}
