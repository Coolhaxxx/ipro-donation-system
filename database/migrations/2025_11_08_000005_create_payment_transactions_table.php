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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')->constrained()->onDelete('cascade');
            
            // Stripe-specific fields
            $table->string('stripe_payment_intent_id')->nullable()->unique();
            $table->string('stripe_charge_id')->nullable();
            
            $table->decimal('amount', 10, 2);
            $table->string('status'); // succeeded, pending, failed, etc.
            
            // Payment method details (JSON for flexibility)
            $table->json('payment_method_details')->nullable();
            
            // Receipt URL from Stripe
            $table->string('receipt_url')->nullable();
            
            // Error information (if payment failed)
            $table->text('error_message')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('stripe_payment_intent_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
