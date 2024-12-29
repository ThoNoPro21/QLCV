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
        Schema::create('taskcard', function (Blueprint $table) {
            $table->increments('TaskCardID');
            $table->string('TaskCardName');
            $table->unsignedInteger('StatustTaskID');
            $table->foreign('StatustTaskID')->references('StatustTaskID')->on('statustask')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('EmployeeID');
            $table->foreign('EmployeeID')->references('EmployeeID')->on('employees')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taskcard');
    }
};
