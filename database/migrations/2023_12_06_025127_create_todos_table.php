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
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            // user_id
            $table->unsignedBigInteger('user_id');
            // boolean isDone
            $table->boolean('is_done')->default(false);
            // boolean isfav
            $table->boolean('is_fav')->default(false);
            // boolean isTrash
            $table->boolean('is_trash')->default(false);
            // array tags
            $table->json('category')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
