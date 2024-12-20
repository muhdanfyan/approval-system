<?php
namespace App\Services;

use App\Models\Expense;
use App\Models\Approval;
use App\Models\Status;
use App\Models\Approver;
use App\Services\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Log;


class ExpenseService
{
    // Menambahkan pengeluaran
    public function createExpense(Request $request)
    {
        Log::info('Membuat pengeluaran baru');
        // Validasi input
        $validated = $request->validate([
            'amount' => 'required|integer|min:1',
        ]);
        $data = $validated->only(['amount']); // Ambil hanya data yang dibutuhkan

        // Validasi dan buat expense
        $expense = Expense::create($data);

        return $expense;
    }

    // Menyetuju pengeluaran
    public function approveExpense(Request $request, $id)
    {
        // Validasi
        $request->validate([
            'approver_id' => 'required|exists:approvers,id',
        ]);
    
        // Ambil pengeluaran
        $expense = Expense::findOrFail($id);
    
        // Ambil approval stage yang sesuai
        $approvalStage = $expense->approvals()->orderBy('id')->where('status_id', 1)->first();
    
        if (!$approvalStage) {
            return response()->json(['message' => 'No pending approval stages'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        // Pastikan approver yang benar melakukan approval
        if ($approvalStage->approver_id !== $request->approver_id) {
            return response()->json(['message' => 'Approver not allowed at this stage'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        // Update status approval
        $approvalStage->update([
            'status_id' => Status::where('name', 'Disetujui')->first()->id,
        ]);
    
        // Jika semua approval sudah disetujui, update status expense
        if ($expense->approvals()->where('status_id', 1)->count() === 0) {
            $expense->update([
                'status_id' => Status::where('name', 'Disetujui')->first()->id,
            ]);
        }
    
        return response()->json(['message' => 'Expense approved'], Response::HTTP_OK);
    }
    
    // Menampilkan detail pengeluaran
    public function getExpenseDetails($id)
    {
        // Ambil pengeluaran
        $expense = Expense::with(['status', 'approvals.approver', 'approvals.status'])->findOrFail($id);

        // Response
        return response()->json($expense, Response::HTTP_OK);
    }
}
