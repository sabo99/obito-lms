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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('booking_trx_id'); // Booking transaction ID

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // User who made the transaction
            $table->foreignId('pricing_id')->constrained('pricings')->cascadeOnDelete(); // Pricing plan

            $table->unsignedInteger('sub_total_amount'); // Sub total amount
            $table->unsignedInteger('grand_total_amount'); // Grand total amount
            $table->unsignedInteger('total_tax_amount'); // Total tax amount

            $table->boolean('is_paid'); // Payment status

            $table->string('payment_type'); // Payment type (e.g. credit card, bank transfer, etc.)
            $table->string('payment_proof')->nullable(); // Payment proof file

            $table->timestamp('started_at')->nullable(); // Start date of the pricing plan
            $table->timestamp('ended_at')->nullable(); // End date of the pricing plan

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
