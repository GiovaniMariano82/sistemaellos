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
        Schema::create('register_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('provider_id')->constrained('providers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->integer('duration')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->float('amount_service');
            $table->float('discount_percent');
            $table->float('discount_value');
            $table->float('amount_to_pay');
            $table->integer('split_pay')->default(1);
            $table->float('amount_split_pay');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade');
            $table->boolean('active')->default(1);
            $table->longText('observation')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_customers');
    }
};
