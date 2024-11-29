<?php

use App\Models\Expense;
use App\Models\Approver;
use App\Models\Status;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Buat beberapa status
        Status::create([
            'name' => 'Pending',
        ]);

        Status::create([
            'name' => 'Approved',
        ]);

        // Buat beberapa expense
        Expense::create([
            'amount' => 1000,
            'status_id' => 1, // Pending
        ]);

        Expense::create([
            'amount' => 2000,
            'status_id' => 2, // Approved
        ]);

        // Buat beberapa approver
        Approver::create([
            'name' => 'Approver 1',
            'email' => 'approver1@example.com',
        ]);

        Approver::create([
            'name' => 'Approver 2',
            'email' => 'approver2@example.com',
        ]);
    }
}