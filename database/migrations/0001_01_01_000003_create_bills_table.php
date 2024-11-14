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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->timestamp('emission_at')->nullable();
            $table->timestamp('expiration_at')->nullable();
            $table->double('interest_rate');
            $table->integer('interest_type');
            $table->integer('interest_frequency');
            $table->integer('interest_capitalization')->nullable();
            $table->integer('billfold_id');
            $table->double('other_costs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
