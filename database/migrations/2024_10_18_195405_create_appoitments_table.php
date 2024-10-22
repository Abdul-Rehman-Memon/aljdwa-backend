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

        Schema::create('appoitments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->bigInteger('phone');
            $table->bigInteger('email');
            $table->timestamp('request_date_time');
            $table->string('link')->nullable();
            // $table->integer('status');
            // $table->foreign('status')->references('id')->on('lookups');
            $table->unsignedInteger('status')->nullable();
             $table->foreign('status')->references('id')->on('lookup_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignUuid('approved_by')->nullable()->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appoitments');
    }
};
