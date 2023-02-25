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
        Schema::create('khachhangs', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->string('sdt');
            $table->string('email')->unique();
            $table->string('diachi');
            $table->string('matkhau');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khachhangs');
    }
};
