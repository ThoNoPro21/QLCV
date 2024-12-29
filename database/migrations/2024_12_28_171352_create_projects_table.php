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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('ProjectID');
            $table->string('ProjectName');
            column:
            $table->string('Background');
            $table->integer('Status')->default(0);
            $table->string('Role');
            $table->unsignedInteger('EmployeeID');
            $table->foreign('EmployeeID')->references('EmployeeID')->on('Employees')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
