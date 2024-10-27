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

        Schema::create('entrepreneur_agreement', function (Blueprint $table) {
            $table->increments('id');
            // $table->foreignUuid('startup_id')->constrained();
            $table->foreignUuid('entrepreneur_details_id')->constrained('entrepreneur_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            // $table->uuid('admin_id');
            $table->foreignUuid('admin_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->timestamp('signed_At')->nullable();
            $table->text('agreement_details');
            $table->string('agreement_document')->nullable();;
            $table->string('reject_reason')->nullable();;
            // $table->integer('status');
            // $table->foreign('status')->references('status')->on('lookups');
            $table->unsignedInteger('status')->default(20);
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
        Schema::dropIfExists('entrepreneur_agreement');
    }
};
