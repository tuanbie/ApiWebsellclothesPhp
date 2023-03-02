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
        Schema::create('hoadons', function (Blueprint $table) {
            $table->increments("idInvoice");
            $table->string('InvoiceNameReceiver');
            $table->string('InvoiceAddressReceiver');
            $table->string('InvoicePhoneReceiver');
            $table->dateTime('InvoiceDate');
            $table->float('TotalInvoice');
            $table->string('PaymentsInvoice');
            $table->boolean('StatusInvoice');
            $table->boolean('Paid');
            $table->string('NoteInvoice');
            $table->string('idAccount');
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
