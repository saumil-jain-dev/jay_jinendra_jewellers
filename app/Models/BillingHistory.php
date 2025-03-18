<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingHistory extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'payment_type',
        'amount',
        'remaining',
        'status',
        'receipt_date',
        'remark',
        'is_bill',
    ];

    public function invoice()
    {
        return $this->hasOne(Bill::class, 'bill_number', 'invoice_id');
    }
}
