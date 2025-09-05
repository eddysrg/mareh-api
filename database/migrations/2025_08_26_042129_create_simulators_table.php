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
        Schema::create('simulators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->decimal('housing_value', 20);
            $table->decimal('credit_amount', 20);
            $table->decimal('credit_term', 20);
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulators');
    }
};
