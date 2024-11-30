<?php

namespace App\Repositories;

use App\Models\Approver;

class ApproverRepository
{
    public function create(array $data)
    {
        return Approver::create($data);
    }
}
