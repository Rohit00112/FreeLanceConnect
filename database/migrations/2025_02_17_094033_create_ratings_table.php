<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  // Client who is giving the rating
            $table->unsignedBigInteger('freelancer_id');  // Freelancer who is being rated
            $table->integer('rating');  // Rating value (1-5)
            $table->text('review')->nullable();  // Optional review
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  // Client who gives rating
            $table->foreign('freelancer_id')->references('id')->on('users')->onDelete('cascade');  // Freelancer being rated

            // Ensuring a client can rate only one freelancer per rating
            $table->unique(['user_id', 'freelancer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
