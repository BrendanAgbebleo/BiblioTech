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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); // Primary key (BIGINT)

            $table->string('title');
            $table->string('author');
            $table->string('isbn')->unique(); // Unique book identifier
            $table->decimal('price', 8, 2); // e.g. 999,999.99
            $table->text('description')->nullable();
            $table->string('cover_img')->nullable(); // Path or URL

            $table->date('release_date')->nullable(); // Optional book release date
            $table->date('added_date'); // When the book was added to the library

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
