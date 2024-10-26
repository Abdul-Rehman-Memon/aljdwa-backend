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

        Schema::create('application_status', function (Blueprint $table) {
            $table->increments('id');

            $table->foreignUuid('user_id')
                  ->constrained('users') 
                  ->cascadeOnUpdate() 
                  ->cascadeOnDelete(); 

            $table->unsignedInteger('status')->default(4);
            $table->foreign('status')->references('id')->on('lookup_details')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->text('reason')->nullable();

            $table->foreignUuid('status_by')->nullable()
            ->constrained('users') 
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
        Schema::dropIfExists('application_status');
    }
};
