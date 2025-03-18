<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Party extends Model
{
    use HasFactory,SoftDeletes;

    // Define the fillable attributes
    protected $fillable = ['name','email', 'phone', 'address','guarantor_id','aadhar_card_no'];
}
