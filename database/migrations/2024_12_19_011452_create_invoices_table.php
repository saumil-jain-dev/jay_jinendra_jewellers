<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->integer('invoice_number'); // Invoice number
            $table->unsignedBigInteger('customer_id'); // Customer ID
            $table->string('GST')->nullable(); // GST number
            $table->string('pancard')->nullable(); // PAN card
            $table->json('item')->nullable(); // Items in JSON format
            $table->date('invoice_date'); // Invoice date
            $table->decimal('weight', 10, 2)->default(0); // Weight
            $table->decimal('999', 10, 2)->default(0); // 999 purity weight
            $table->decimal('916', 10, 2)->default(0); // 916 purity weight
            $table->decimal('kdm', 10, 2)->default(0); // KDM purity weight
            $table->decimal('silver', 10, 2)->default(0); // Silver weight
            $table->decimal('total', 15, 2)->default(0); // Total amount
            $table->decimal('discount', 15, 2)->default(0); // Discount
            $table->decimal('extra', 15, 2)->default(0); // Extra charges
            $table->decimal('icgst', 15, 2)->default(0); // Integrated CGST
            $table->decimal('cgst', 15, 2)->default(0); // Central GST
            $table->decimal('sgst', 15, 2)->default(0); // State GST
            $table->decimal('old_gold', 10, 2)->default(0); // Old gold weight
            $table->decimal('old_silver', 10, 2)->default(0); // Old silver weight
            $table->string('order')->nullable(); // Order details
            $table->decimal('final', 15, 2)->default(0); // Final amount after calculations
            $table->decimal('cash', 15, 2)->default(0); // Cash payment
            $table->decimal('online', 15, 2)->default(0); // Online payment
            $table->unsignedBigInteger('guarantor_id')->nullable(); // Guarantor ID
            $table->text('remark')->nullable(); // Remarks
            $table->decimal('pending', 15, 2)->default(0); // Pending amount
            $table->timestamps(); // created_at and updated_at

            // Foreign keys (optional)
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('guarantor_id')->references('id')->on('guarantors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
}
