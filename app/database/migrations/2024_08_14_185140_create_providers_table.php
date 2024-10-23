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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('fullName', 100);
            $table->string('socialName', 100)->nullable();
            $table->foreignId('type_document_id')->constrained('type_documents')->onDelete('cascade');
            $table->string('documentNumber', 50)->unique();
            $table->dateTime('birthDate')->nullable();
            $table->foreignId('type_gender_id')->constrained('type_genders')->onDelete('cascade');
            $table->foreignId('type_provider_id')->constrained('type_providers')->onDelete('cascade');
            $table->string('postalCode', 8);
            $table->string('address', 100);
            $table->string('addressNumber', 10)->nullable();
            $table->string('complement', 50)->nullable();
            $table->string('neighborhood', 50);
            $table->string('city', 50);
            $table->tinyText('state');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->string('origin', 10);
            $table->longText('observation')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
