<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index(); 
            $table->string('event_type');    
            $table->text('description')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('path')->nullable();
            $table->string('method')->nullable();
            $table->integer('status_code')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('students')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_logs');
    }
};