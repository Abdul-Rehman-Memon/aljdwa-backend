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
        Schema::disableForeignKeyConstraints();

        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('payments_details')->nullable();
            $table->text('payment_reference')->nullable();
            $table->foreignUuid('entrepreneur_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignUuid('entrepreneur_details_id')->constrained('entrepreneur_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->bigInteger('invoice_Id')->nullable();
            $table->bigInteger('amount');
            $table->text('voucher')->nullable();
            // $table->integer('status');
            // $table->foreign('status')->references('id')->on('lookups');
            $table->unsignedInteger('status')->default(23);
             $table->foreign('status')->references('id')->on('lookup_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->timestamp('payment_date');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
