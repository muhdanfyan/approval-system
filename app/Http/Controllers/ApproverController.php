<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApproverRequest;
use App\Services\ApproverService;

class ApproverController extends Controller
{
    protected $service;

    public function __construct(ApproverService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/approvers",
     *     operationId="storeApprover",
     *     tags={"Approvers"},
     *     summary="Tambah approver baru",
     *     description="Menambahkan approver baru ke sistem",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Ana")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Approver added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approver added successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */

    public function store(StoreApproverRequest $request)
    {
        $this->service->storeApprover($request->validated());
        return response()->json(['message' => 'Approver added successfully'], 201);
    }
}
