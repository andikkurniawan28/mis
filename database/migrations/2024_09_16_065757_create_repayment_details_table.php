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
        Schema::create('repayment_details', function (Blueprint $table) {
            $table->id();
            $table->string('repayment_id');
            $table->foreign('repayment_id')->references('id')->on('repayments')->onDelete('cascade');
            $table->string('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->double('left');
            $table->double('discount');
            $table->double('total');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayment_details');
    }
};
