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

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            // $table->foreignUuid('user_id')->constrained();
            $table->foreignUuid('sender_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete()->nullable();

            $table->foreignUuid('receiver_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete()->nullable();
            $table->text('message');
            $table->string('notification_type');
            $table->boolean('is_read')->default(0);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
