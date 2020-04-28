<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('no_of_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('leave_types_id');
            $table->unsignedBigInteger('applied_by');
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();

            $table->foreign('leave_types_id')->references('id')->on('leave_types');
            $table->foreign('applied_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');

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
        Schema::dropIfExists('leaves');
    }
}
