<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('name')->nullable();
            $table->string('short_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('contest_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contest_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('chat_id')->nullable();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('username')->nullable();
            $table->text('phone_number')->nullable();
            $table->integer('number_member');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_members');
        Schema::dropIfExists('contests');
    }
};
