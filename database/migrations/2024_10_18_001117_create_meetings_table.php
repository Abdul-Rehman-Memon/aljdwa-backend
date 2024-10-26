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

        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            // $table->integer('startup_id');
            // $table->foreign('startup_id')->references('id')->on('startups');

            $table->foreignUuid('initiator_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            // $table->integer('mentor_id');
            // $table->foreign('mentor_id')->references('id')->on('users');

            $table->foreignUuid('participant_id')->constrained('users')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            
            
            $table->string('link');
            $table->string('meeting_password');
            $table->text('agenda');
            $table->timestamp('meeting_date_time');
            
            // $table->integer('resheduled_id');
            // $table->foreign('resheduled_id')->references('id')->on('meetings');
            $table->unsignedInteger('resheduled_id')->nullable();
             $table->foreign('resheduled_id')->references('id')->on('meetings')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            

            $table->unsignedInteger('status');
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
        Schema::dropIfExists('meetings');
    }
};
