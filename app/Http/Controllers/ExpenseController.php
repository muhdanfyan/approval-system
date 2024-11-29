<?php

namespace App\Http\Controllers;

use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }


    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     summary="Create a new expense",
     *     description="This endpoint is used to create a new expense",
     *     operationId="createExpense",
     *     tags={"Expenses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="integer", example=500000)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Expense created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     )
     * )
     */

    // Menambahkan Pengeluaran
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $expense = $this->expenseService->createExpense($validated);

        return response()->json([
            'message' => 'Expense created successfully',
        ]);
    }
    /**
     * @OA\Patch(
     *     path="/api/expenses/{id}/approve",
     *     summary="Approve an expense",
     *     description="This endpoint is used by approvers to approve an expense",
     *     operationId="approveExpense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Expense ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense approved",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Expense approved")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Approval failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Approver not allowed at this stage")
     *         )
     *     )
     * )
     */
    // Menyetuju pengeluaran
    public function approve(Request $request, $id)
    {
        // Proses data yang diterima
        $expense = Expense::find($id);
        $expense->status = 'approved';
        $expense->save();

        // Mengembalikan respons dengan status kode 200
        return response()->json(['message' => 'Expense approved'], 200);
    }
    /**
     * @OA\Get(
     *     path="/api/expenses/{id}",
     *     summary="Get an expense details",
     *     description="This endpoint returns the details of an expense including its status and approval stages",
     *     operationId="getExpenseDetails",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Expense ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="amount", type="integer", example=500000),
     *             @OA\Property(property="status", type="object", 
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Menunggu Persetujuan")
     *             ),
     *             @OA\Property(property="approval", type="array", 
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="approver", type="object", 
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Ana")
     *                     ),
     *                     @OA\Property(property="status", type="object", 
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Disetujui")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    // Menampilkan Detail Pengeluaran
    public function show($id)
    {
        return $this->expenseService->getExpenseDetails($id);
    }
}
