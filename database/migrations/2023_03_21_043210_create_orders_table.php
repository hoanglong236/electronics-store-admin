<?php

use App\ModelConstants\OrderStatusConstants;
use App\ModelConstants\PaymentMethodConstants;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers');
            $table->string('delivery_address');
            $table->enum('status', OrderStatusConstants::toArray())
                ->default(OrderStatusConstants::RECEIVED);
            $table->enum('payment_method', PaymentMethodConstants::toArray())
                ->default(PaymentMethodConstants::COD);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
