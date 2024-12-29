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
        Schema::create('taskcarddetail', function (Blueprint $table) {
            $table->increments('TaskCardDetailID');
            $table->string('Description');
            $table->string('File');
            $table->unsignedInteger('TaskCardID');
            $table->foreign('TaskCardID')->references('TaskCardID')->on('taskcard')
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
        Schema::dropIfExists('taskcarddetail');
    }
};