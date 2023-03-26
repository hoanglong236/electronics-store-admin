<?php

use App\ModelConstants\CustomerAddressType;
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
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('customer_id')->reference('id')->on('customers');
            $table->string('city', 64);
            $table->string('district', 64);
            $table->string('ward', 64);
            $table->string('specific_address', 64);
            $table->enum('address_type', CustomerAddressType::toArray());
            $table->boolean('default_flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_addresses');
    }
};
