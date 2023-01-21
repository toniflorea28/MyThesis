<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('img');
            $table->string('title');
            $table->string('user_id');
            $table->string('category_id');
            $table->string('tags')->nullable();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('phone');
            $table->integer('rating');
            $table->string('location');
            $table->integer('comment')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('jobs');
    }
};
