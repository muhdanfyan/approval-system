<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproverRequest;
use App\Services\ApproverService;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/approvers",
 *     tags={"Approvers"},
 *     summary="Add an approver",
 *     description="Create a new approver",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Ana")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Approver added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Approver added successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="array",
 *                     @OA\Items(type="string", example="The name has already been taken.")
 *                 )
 *             )
 *         )
 *     )
 * )
 */



class ApproverController extends Controller
{
    protected $approverService;

    public function __construct(ApproverService $approverService)
    {
        $this->approverService = $approverService;
    }

    public function store(ApproverRequest $request)
    {
        $this->approverService->createApprover($request->validated());
        return response()->json(['message' => 'Approver added successfully'], 200);
    }
}
