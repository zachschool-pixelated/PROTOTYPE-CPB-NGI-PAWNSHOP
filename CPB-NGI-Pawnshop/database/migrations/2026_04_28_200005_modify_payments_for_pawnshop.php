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
        // Drop the existing payments table if it exists and recreate it
        if (Schema::hasTable('payments')) {
            Schema::dropIfExists('payments');
        }

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash', 'check', 'card', 'bank_transfer'])->default('cash');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->text('notes')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
