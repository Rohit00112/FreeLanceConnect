<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
             $table->id();
             $table->string('transaction_id');
             $table->unsignedBigInteger('paid_by');
             $table->unsignedBigInteger('paid_to');
             $table->unsignedBigInteger('post_project_id');
             $table->float('amount');

             $table->timestamps();

             $table->foreign('paid_by')->references('id')->on('users')->onDelete('cascade');
             $table->foreign('post_project_id')->references('id')->on('post_projects')->onDelete('cascade');
             $table->foreign('paid_to')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
