<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing ID
            $table->string('title'); // Job title
            $table->text('description'); // Job description
            $table->integer('salary'); // Salary or payment for the job
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_offers');
    }
}
