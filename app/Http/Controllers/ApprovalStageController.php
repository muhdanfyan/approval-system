<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApprovalStageRequest;
use App\Models\ApprovalStage;

/**
 * @OA\Post(
 *     path="/api/approval-stages",
 *     tags={"Approval Stages"},
 *     summary="Add a new approval stage",
 *     description="Create a new approval stage with approver_id and stage_order",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="approver_id", type="integer", example=1),
 *             @OA\Property(property="stage_order", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Approval stage added successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Approval stage added successfully")
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
 *                 @OA\Property(property="approver_id", type="array", @OA\Items(type="string")),
 *                 @OA\Property(property="stage_order", type="array", @OA\Items(type="string"))
 *             )
 *         )
 *     )
 * )
 * 
 * @OA\Put(
 *     path="/api/approval-stages/{id}",
 *     tags={"Approval Stages"},
 *     summary="Update an approval stage",
 *     description="Update an existing approval stage by id",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Approval stage ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="approver_id", type="integer", example=2),
 *             @OA\Property(property="stage_order", type="integer", example=2)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Approval stage updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Approval stage updated successfully")
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
 *                 @OA\Property(property="approver_id", type="array", @OA\Items(type="string")),
 *                 @OA\Property(property="stage_order", type="array", @OA\Items(type="string"))
 *             )
 *         )
 *     )
 * )
 */

class ApprovalStageController extends Controller
{
    /**
     * Menambahkan Approval Stage baru.
     */
    public function store(ApprovalStageRequest $request)
    {
        // Validasi input akan otomatis dilakukan oleh ApprovalStageRequest
        ApprovalStage::create([
            'approver_id' => $request->approver_id,
            'stage_order' => $request->stage_order,
        ]);

        return response()->json(['message' => 'Approval stage added successfully'], 200);
    }

    /**
     * Mengubah Approval Stage yang ada.
     */
    public function update(ApprovalStageRequest $request, $id)
    {
        $approvalStage = ApprovalStage::findOrFail($id);

        // Validasi input akan otomatis dilakukan oleh ApprovalStageRequest
        $approvalStage->update([
            'approver_id' => $request->approver_id,
            'stage_order' => $request->stage_order,
        ]);

        return response()->json(['message' => 'Approval stage updated successfully'], 200);
    }
}
