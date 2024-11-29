<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->onDelete('cascade'); // Relasi ke expenses
            $table->foreignId('approver_id')->constrained('approvers')->onDelete('cascade'); // Relasi ke approvers
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade'); // Relasi ke statuses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approvals');
    }
}
