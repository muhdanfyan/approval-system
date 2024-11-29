<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Approver;
use App\Models\Status;
use App\Models\ApprovalStage;
use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Jalankan seeder StatusSeeder
        $this->artisan('db:seed', ['--class' => 'StatusSeeder']);
    }
    
    // Test untuk menambahkan pengeluaran
    public function test_create_expense()
    {
        // Data pengeluaran
        $data = [
            'amount' => 500000,
        ];

        // Kirim request POST untuk membuat pengeluaran
        $response = $this->postJson('/api/expenses', $data);

        // Periksa apakah statusnya berhasil dan pesan yang benar
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Expense created successfully',
        ]);

        // Verifikasi bahwa pengeluaran benar-benar ada di database
        $this->assertDatabaseHas('expenses', [
            'amount' => 500000,
        ]);
    }

    // Test untuk menyetujui pengeluaran
    public function test_approve_expense()
    {
        // Persiapkan data untuk pengeluaran dan approver
        $approver = Approver::factory()->create();
        $expense = Expense::factory()->create(['status_id' => Status::where('name', 'Menunggu Persetujuan')->first()->id]);

        // Tambahkan stage approval
        $approvalStage = ApprovalStage::create([
            'approver_id' => $approver->id,
            'stage_order' => 1,
        ]);

        // Kirim request untuk menyetujui pengeluaran
        $response = $this->patchJson("/api/expenses/{$expense->id}/approve", [
            'approver_id' => $approver->id,
        ]);

        // Periksa apakah statusnya berhasil
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Expense approved',
        ]);

        // Verifikasi status pengeluaran telah diubah
        $expense->refresh();
        $this->assertEquals('Disetujui', $expense->status->name);
    }

    // Test untuk melihat detail pengeluaran
    public function test_show_expense()
    {
        $expense = \App\Models\Expense::factory()->create();
    
        $response = $this->get("/api/expenses/{$expense->id}");
    
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $expense->id,
            'amount' => $expense->amount,
            // Tambahkan properti lain yang ingin diuji...
        ]);
    }
    

    // Test untuk menolak pengeluaran yang tidak sesuai tahap approval
    public function test_approve_expense_out_of_order()
    {
        // Persiapkan data untuk pengeluaran dan approver
        $approver1 = Approver::factory()->create();
        $approver2 = Approver::factory()->create();
        $expense = Expense::factory()->create([
            'status_id' => Status::where('name', 'Menunggu Persetujuan')->firstOrFail()->id,
        ]);

        // Tambahkan stage approval
        $approvalStage1 = ApprovalStage::create([
            'approver_id' => $approver1->id,
            'stage_order' => 1,
        ]);
        $approvalStage2 = ApprovalStage::create([
            'approver_id' => $approver2->id,
            'stage_order' => 2,
        ]);

        // Approver2 mencoba menyetujui pengeluaran terlebih dahulu
        $response = $this->patchJson("/api/expenses/{$expense->id}/approve", [
            'approver_id' => $approver2->id,
        ]);

        // Periksa apakah response status error 422 dan pesan yang sesuai
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Approver not allowed at this stage',
        ]);
    }
}
