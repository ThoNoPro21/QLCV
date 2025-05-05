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
        Schema::create('project_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ProjectID');
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('EmployeeID');
            $table->foreign('EmployeeID')->references('EmployeeID')->on('Employees')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('Role')->default('member'); // Leader, Member, Viewer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};