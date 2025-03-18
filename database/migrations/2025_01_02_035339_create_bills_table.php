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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number');
            $table->unsignedBigInteger('party_id');
            $table->unsignedBigInteger('guarantor_id')->nullable();
            $table->string('party_name');
            $table->text('party_address')->nullable();
            $table->string('party_gst')->nullable();
            $table->string('party_aadhar')->nullable();
            $table->string('party_mobile')->nullable();
            $table->string('party_pan')->nullable();
            $table->date('bill_date');
            $table->longText('particulars');
            $table->decimal('weight_999',11,2)->nullable();
            $table->decimal('weight_916',11,2)->nullable();
            $table->decimal('weight_kdm',11,2)->nullable();
            $table->decimal('weight_18k',18,2)->nullable();
            $table->decimal('weight_silver',11,2)->nullable();
            $table->decimal('gross_amount',11,2)->nullable();
            $table->decimal('discount',11,2)->nullable();
            $table->decimal('extra',11,2)->nullable();
            $table->decimal('final_gross_amount',11,2)->nullable();
            $table->decimal('gst_total',11,2)->nullable();
            $table->decimal('igst',11,2)->nullable();
            $table->decimal('cgst',11,2)->nullable();
            $table->decimal('sgst',11,2)->nullable();
            $table->string('old_gold')->nullable();
            $table->string('old_silver')->nullable();
            $table->string('order')->nullable();
            $table->decimal('final_amount',11,2);
            $table->decimal('cash_amount',11,2)->nullable();
            $table->decimal('online_amount',11,2)->nullable();
            $table->decimal('given_amount',11,2)->nullable();
            $table->decimal('pending_amount',11,2)->nullable();
            $table->decimal('total_given_amount',11,2)->nullable();
            $table->decimal('total_due_amount',11,2)->nullable();
            $table->text('amt_in_words')->nullable();
            $table->longText('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
