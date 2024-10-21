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

        Schema::create('entreprenuer_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->foreignUuid('userId')->constrained('users');
            $table->foreignUuid('user_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->string('website');
            $table->text('project_description');
            $table->text('problem_solved');
            $table->text('solution_offering');
            $table->text('previous_investment');
            $table->text('industry_sector');
            $table->text('business_model');
            $table->string('patent');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprenuer_details');
    }
};
