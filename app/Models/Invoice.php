<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'GST',
        'pancard',
        'item',
        'invoice_date',
        'weight',
        '999',
        '916',
        'kdm',
        'silver',
        'total',
        'discount',
        'extra',
        'icgst',
        'cgst',
        'sgst',
        'old_gold',
        'old_silver',
        'order',
        'final',
        'cash',
        'online',
        'guarantor_id',
        'remark',
        'pending',
    ];

    public function guarantor()
    {
        return $this->belongsTo(Guarantor::class);
    }

    public function billingHistories()
    {
        return $this->hasMany(BillingHistory::class);
    }
}
