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
        $table->string('client_name');
        $table->string('client_phone');
        $table->string('client_address');
        $table->string('client_city');

        // Rental period pick upp
        $table->foreignId('pick_up_city_id')->constrained('cities');
        $table->date('pick_up_date');
        $table->time('pick_up_time');

        // Rental period drop off
        $table->foreignId('drop_off_city_id')->constrained('cities');
        $table->date('drop_off_date');
        $table->time('drop_off_time');

        $table->integer('rental_days');

        // Payment information
        $table->enum('payment_method', ['CashCard', 'PayPal', 'Bitcoin']);
        $table->string('payment_reference')->nullable();
        $table->decimal('subtotal', 10, 2);
        $table->decimal('tax', 10, 2)->default(0.00);
        $table->decimal('total_price', 10, 2);

        // Terms & Marketing emails
        $table->boolean('terms_accepted');
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
