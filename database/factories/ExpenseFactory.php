<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(1000, 1000000),
            'status_id' => Status::firstOrCreate(['name' => 'Menunggu Persetujuan'], ['id' => 1])->id,
        ];
    }
}