<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStageOrderToApprovalStagesTable extends Migration
{
    public function up()
    {
        Schema::table('approval_stages', function (Blueprint $table) {
            $table->integer('stage_order')->nullable();
        });
    }

    public function down()
    {
        Schema::table('approval_stages', function (Blueprint $table) {
            $table->dropColumn('stage_order');
        });
    }
}