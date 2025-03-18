<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billing_histories', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('invoice_id'); // Foreign key to invoices table
            $table->string('payment_type'); // Payment type (e.g., cash, card, etc.)
            $table->decimal('amount', 10, 2); // Payment amount
            $table->decimal('remaining', 10, 2)->default(0); // Remaining amount
            $table->date('receipt_date')->nullable();
            $table->text('remark')->nullable();
            $table->integer('is_bill')->nullable();
            $table->string('status'); // Status (e.g., paid, pending, etc.)
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes();

            // Add a foreign key constraint if applicable
            // $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_histories');
    }
}
