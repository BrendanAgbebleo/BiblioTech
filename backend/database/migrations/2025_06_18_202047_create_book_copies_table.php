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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->foreignId('book_id')
                  ->constrained('books')
                  ->onDelete('cascade'); // Delete copies if the book is deleted

            $table->integer('copy_number'); // e.g., Copy 1, Copy 2, etc.
            $table->boolean('available')->default(true); // true = available

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
