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

        Schema::create('appointments_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date')->nullable();
            $table->string('time');
            $table->string('duration');
            $table->integer('weekday')->nullable();

            $table->unsignedInteger('status')->default(5);
            $table->foreign('status')->references('id')->on('lookup_details')
           ->cascadeOnUpdate()
           ->cascadeOnDelete();

            $table->foreignUuid('added_by')->nullable()->constrained('users')
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
        Schema::dropIfExists('appointments_schedule');
    }
};