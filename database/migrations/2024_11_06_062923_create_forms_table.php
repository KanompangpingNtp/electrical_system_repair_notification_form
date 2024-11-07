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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('request_date');
            $table->enum('status', [1, 2]); // 1 = Pending, 2 = Completed
            $table->string('guest_salutation')->nullable();
            $table->string('guest_name')->nullable();
            $table->string('guest_house_number')->nullable();
            $table->string('guest_village')->nullable();
            $table->integer('location_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
