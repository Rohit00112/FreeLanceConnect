<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
            Schema::create('post_projects', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('freelancer_id');
                 $table->unsignedBigInteger('client_id');
                 $table->string('project_name');
                $table->text('project_description');
                $table->float('budget');
                $table->date('deadline');
                $table->string('status');
                $table->timestamps();
                $table->foreign('freelancer_id')->references('id')->on('users')->onDelete('cascade');
                 $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('post_projects');
    }
};


