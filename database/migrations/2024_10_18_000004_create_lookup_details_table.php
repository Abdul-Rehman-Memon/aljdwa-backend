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

        Schema::create('lookup_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lookup_id');
            $table->foreign('lookup_id')->references('id')->on('lookups')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('display_name');
            $table->string('value');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lookup_details');
    }
};
