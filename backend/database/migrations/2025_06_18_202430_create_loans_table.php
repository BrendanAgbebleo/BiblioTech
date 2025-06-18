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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('book_copy_id')->constrained('book_copies')->onDelete('cascade');

            $table->date('borrowed_at')->useCurrent();
            $table->date('due_at');
            $table->date('returned_at')->nullable();

            $table->boolean('is_overdue')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
