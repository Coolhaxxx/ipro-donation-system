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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('donation_type', ['zakat', 'sadaqah', 'general']);
            $table->enum('payment_method', ['cash', 'check', 'online']);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            
            // Check payment fields (nullable for other payment methods)
            $table->string('check_number')->nullable();
            $table->string('check_photo')->nullable(); // File path for check photo
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('routing_number')->nullable();
            
            // Stripe transaction ID (nullable for cash/check)
            $table->string('transaction_id')->nullable()->index();
            
            // Campaign information
            $table->string('campaign')->default('Jamaica Hurricane Relief');
            
            // Additional notes
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('payment_status');
            $table->index('payment_method');
            $table->index('donation_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
