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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('EmployeeID');
            $table->string('Address');
            column:
            $table->date('Dateofbirth');
            $table->string('Role');
            $table->unsignedInteger('SubsciptionID');
            $table->foreign('SubsciptionID')->references('SubsciptionID')->on('subscription')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('AccountID');
            $table->foreign('AccountID')->references('AccountID')->on('account')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
