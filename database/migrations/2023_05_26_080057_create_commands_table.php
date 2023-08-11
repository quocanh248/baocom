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
        Schema::create('soluongcom', function (Blueprint $table) {
            $table->id();
            $table->string('mansang1');
            $table->string('manchieu1');
            $table->string('mansang2');
            $table->string('manchieu2');
            $table->string('chaysang1');
            $table->string('chaychieu1');
            $table->string('chaysang2');
            $table->string('chaychieu2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soluongcom');
    }
};
