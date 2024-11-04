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

        Schema::create('messages', function (Blueprint $table) {
            $table->increments('message_id');

            $table->text('message_text')->nullable();
            $table->string('attachment_url', 255)->nullable();
            $table->boolean('is_read')->default(false);


            $table->foreignUuid('sender_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignUuid('receiver_id')->constrained('users')
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
        Schema::dropIfExists('messages');
    }
};

