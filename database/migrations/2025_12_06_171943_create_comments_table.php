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
        // Create table
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // id auto increment
            $table->text('content');    //post content
            // relationshio between table comment and post, if post are deleted are also commets
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); 
            //  relationship between user and comment, user_id can be null
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
