<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    //
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'bill_number',
        'party_id',
        'guarantor_id',
        'party_name',
        'party_address',
        'party_gst',
        'party_aadhar',
        'party_mobile',
        'party_pan',
        'bill_date',
        'particulars',
        'weight_999',
        'weight_916',
        'weight_kdm',
        'weight_18k',
        'weight_silver',
        'gross_amount',
        'discount',
        'extra',
        'final_gross_amount',
        'gst_total',
        'igst',
        'cgst',
        'sgst',
        'old_gold',
        'old_silver',
        'order',
        'final_amount',
        'cash_amount',
        'online_amount',
        'given_amount',
        'pending_amount',
        'total_given_amount',
        'total_due_amount',
        'amt_in_words',
        'remark',
    ];

    public function guarantor()
    {
        return $this->belongsTo(Guarantor::class, 'guarantor_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
}
