<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Approver;
use App\Models\Status;
use App\Models\Approval;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_expense()
    {
        $approver = Approver::create(['name' => 'Ana']);
        $status = Status::create(['name' => 'Menunggu Persetujuan']);

        $response = $this->postJson('/api/expenses', [
            'amount' => 500000
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Expense created successfully']);

        $this->assertDatabaseHas('expenses', [
            'amount' => 500000
        ]);
    }

    public function test_approve_expense()
    {
        $approver = Approver::create(['name' => 'Ana']);
        $status = Status::create(['name' => 'Menunggu Persetujuan']);
        $expense = Expense::create(['amount' => 500000, 'status_id' => $status->id]);

        $response = $this->patchJson('/api/expenses/' . $expense->id . '/approve', [
            'approver_id' => $approver->id
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Expense approved']);
    }

    public function test_get_expense_details()
    {
        $approver = Approver::create(['name' => 'Ana']);
        $status = Status::create(['name' => 'Menunggu Persetujuan']);
        $expense = Expense::create(['amount' => 500000, 'status_id' => $status->id]);

        $response = $this->getJson('/api/expenses/' . $expense->id);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id', 'amount', 'status', 'approval'
                 ]);
    }
}
