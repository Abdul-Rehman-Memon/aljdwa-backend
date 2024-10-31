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

        Schema::create('mentors_assignment', function (Blueprint $table) {
            $table->increments('id');
            // $table->foreignUuid('startup_id')->constrained();
            $table->foreignUuid('entrepreneur_details_id')->constrained('entrepreneur_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            // $table->string('mentors_id');
            // $table->foreign('mentors_id')->references('id')->on('users');
            $table->foreignUuid('mentor_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
           

            $table->unsignedInteger('status')->default(5);
             $table->foreign('status')->references('id')->on('lookup_details')
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
        Schema::dropIfExists('mentors_assignment');
    }
};
