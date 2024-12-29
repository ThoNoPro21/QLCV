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
        Schema::create('statustask', function (Blueprint $table) {
            $table->increments('StatustTaskID');
            $table->string('StatusName');
            $table->unsignedInteger('ProjectID');
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statustask');
    }
};
