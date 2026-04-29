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
            $table->string('loan_number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('loan_amount', 12, 2);
            $table->decimal('interest_rate', 5, 2)->default(5.00); // percentage
            $table->integer('loan_duration_days')->default(30);
            $table->dateTime('loan_date');
            $table->dateTime('due_date');
            $table->dateTime('redemption_date')->nullable();
            $table->enum('status', ['active', 'paid', 'forfeited', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
