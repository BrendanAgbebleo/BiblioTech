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
        Schema::create('staff_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('staff_user_id')->constrained('staff_users')->onDelete('cascade');

            $table->string('action'); // e.g. 'created_loan', 'added_book', 'updated_customer'
            $table->text('description')->nullable(); // Optional details about the action

            $table->timestamp('created_at')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_logs');
    }
};
