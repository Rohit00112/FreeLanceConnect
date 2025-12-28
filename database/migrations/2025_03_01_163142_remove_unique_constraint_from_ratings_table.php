<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['user_id']);
            $table->dropForeign(['freelancer_id']);

            // Drop the unique constraint after removing the foreign key
            $table->dropUnique(['user_id', 'freelancer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Recreate the unique constraint
            $table->unique(['user_id', 'freelancer_id']);

            // Recreate the foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('freelancer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
