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
        Schema::create('comchayds', function (Blueprint $table) {
            $table->id();
            $table->string('manhanvien');        
            $table->foreign('manhanvien')->references('manhanvien')->on('nhansu');
            $table->string('ngaydk', 12);   
            $table->string('ip', 12);   
            $table->string('tt');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comchayds');
    }
};
