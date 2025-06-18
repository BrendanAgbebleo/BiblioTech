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
         Schema::create('staff_users', function (Blueprint $table) {
            $table->id();

            $table->string('uid')->unique(); // Unique staff ID for login
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('password');

            $table->enum('role', ['admin', 'staff'])->default('staff'); 

            $table->rememberToken(); 
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_users');
    }
};
