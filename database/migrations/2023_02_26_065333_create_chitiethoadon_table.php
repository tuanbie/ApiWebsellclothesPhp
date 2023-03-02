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
        Schema::create('chitiethoadons', function (Blueprint $table) {
            $table->increments("idInvoiceDetail");
            $table->string('idProduct');
            $table->string('idInvoice');
            $table->integer('Quantity');
            $table->float('UnitPrice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoadons');
    }
};
