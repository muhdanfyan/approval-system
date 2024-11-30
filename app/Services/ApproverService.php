<?php

namespace App\Services;

use App\Repositories\ApproverRepository;

class ApproverService
{
    protected $repository;

    public function __construct(ApproverRepository $repository)
    {
        $this->repository = $repository;
    }

    public function storeApprover(array $data)
    {
        return $this->repository->create($data);
    }
}

