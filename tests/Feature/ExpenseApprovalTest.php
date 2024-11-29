<?php

namespace Tests\Feature;

use App\Models\Approver;
use App\Models\ApprovalStage;
use App\Models\Expense;
use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ExpenseApprovalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Set up 3 approvers, 3 stages, and 4 expenses for testing.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Membuat 3 Approver
        $ana = Approver::create(['name' => 'Ana']);
        $ani = Approver::create(['name' => 'Ani']);
        $ina = Approver::create(['name' => 'Ina']);

        // Membuat 3 tahap approval
        ApprovalStage::create(['approver_id' => $ana->id, 'stage_order' => 1]);
        ApprovalStage::create(['approver_id' => $ani->id, 'stage_order' => 2]);
        ApprovalStage::create(['approver_id' => $ina->id, 'stage_order' => 3]);

        // Membuat 4 pengeluaran
        Expense::create(['amount' => 1000, 'status_id' => 1]); // Belum disetujui
        Expense::create(['amount' => 2000, 'status_id' => 1]); // Belum disetujui
        Expense::create(['amount' => 3000, 'status_id' => 1]); // Belum disetujui
        Expense::create(['amount' => 4000, 'status_id' => 1]); // Belum disetujui
    }

    /**
     * Test: Disetujui semua approver
     */
    public function test_approval_all_approvers()
    {
        // Disetujui oleh semua approver
        $expense = Expense::first();

        // Setujui expense melalui approver satu per satu
        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 1]) // Ana
            ->assertStatus(Response::HTTP_OK);

        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 2]) // Ani
            ->assertStatus(Response::HTTP_OK);

        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 3]) // Ina
            ->assertStatus(Response::HTTP_OK);

        // Pastikan status pengeluaran adalah "disetujui"
        $expense->refresh();
        $this->assertEquals($expense->status->name, 'disetujui');
    }

    /**
     * Test: Disetujui dua approver
     */
    public function test_approval_two_approvers()
    {
        // Disetujui oleh dua approver
        $expense = Expense::skip(1)->first();

        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 1]) // Ana
            ->assertStatus(Response::HTTP_OK);

        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 2]) // Ani
            ->assertStatus(Response::HTTP_OK);

        // Pastikan status pengeluaran adalah "menunggu persetujuan"
        $expense->refresh();
        $this->assertEquals($expense->status->name, 'menunggu persetujuan');
    }

    /**
     * Test: Disetujui oleh satu approver
     */
    public function test_approval_one_approver()
    {
        // Disetujui oleh satu approver
        $expense = Expense::skip(2)->first();

        $this->patchJson('/api/expense/' . $expense->id . '/approve', ['approver_id' => 1]) // Ana
            ->assertStatus(Response::HTTP_OK);

        // Pastikan status pengeluaran adalah "menunggu persetujuan"
        $expense->refresh();
        $this->assertEquals($expense->status->name, 'menunggu persetujuan');
    }

    /**
     * Test: Belum disetujui
     */
    public function test_expense_not_approved()
    {
        // Pengeluaran yang belum disetujui
        $expense = Expense::skip(3)->first();

        // Pastikan status pengeluaran adalah "menunggu persetujuan"
        $expense->refresh();
        $this->assertEquals($expense->status->name, 'menunggu persetujuan');
    }

    /**
     * Test: Test semua scenario sekaligus
     */
    public function test_all_scenarios()
    {
        // Pengeluaran pertama, disetujui semua
        $this->test_approval_all_approvers();

        // Pengeluaran kedua, disetujui dua approver
        $this->test_approval_two_approvers();

        // Pengeluaran ketiga, disetujui satu approver
        $this->test_approval_one_approver();

        // Pengeluaran keempat, belum disetujui
        $this->test_expense_not_approved();
    }
}
