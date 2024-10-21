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

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('project');
            $table->text('founder_name');
            $table->string('email');
            $table->integer('country_code');
            $table->string('phone_number');
            $table->string('password');
            $table->string('linkedin_profile')->nullable();  
            $table->text('reject_reason')->nullable();
            $table->timestamp('approved_At')->nullable();

            $table->unsignedInteger('role');
            $table->foreign('role')->references('id')->on('lookup_details')
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
        Schema::dropIfExists('users');
    }
};
