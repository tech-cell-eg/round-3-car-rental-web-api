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
        Schema::create('rentals', function (Blueprint $table) {
        $table->id();

        // Car relationship
        $table->unsignedBigInteger('car_id');
        $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');

        // Client information
        $table->string('name');
        $table->string('phone');
        $table->string('address');
        $table->string('city');

        // Rental period pick upp
        $table->string('pickUpLocation');
        $table->date('pickUpDate');
        $table->time('pickUpTime');

        // Rental period drop off
        $table->string('dropOffLocation');
        $table->date('dropOffDate');
        $table->time('dropOffTime');

        $table->integer('rental_days');

        // Payment information
        $table->enum('paymentMethod', ['CashCard', 'PayPal', 'Bitcoin']);
        $table->bigInteger('cardNumber');
        $table->string('expiryDate', 7);
        $table->string('cardHolder');
        $table->integer('cvc');
        $table->string('payment_reference')->nullable();

        // Price Information
        $table->decimal('subtotal', 10, 2);
        $table->decimal('tax', 10, 2)->default(0.00);
        $table->decimal('total_price', 10, 2);

        // Terms & Marketing emails
        $table->boolean('termsAccepted');
        $table->boolean('marketing_emails_accepted')->default(false);

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
