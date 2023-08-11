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
        Schema::create('congviec', function (Blueprint $table) {
            $table->id('macongviec');
            $table->unsignedBigInteger('maloai');        
            $table->foreign('maloai')->references('maloai')->on('loaicongviec');
            $table->string('manhanvien');        
            $table->foreign('manhanvien')->references('manhanvien')->on('nhansu');
            $table->string('noidung'); 
            $table->string('trangthai');       
            $table->date('ngayhethan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congviec');
    }
};
