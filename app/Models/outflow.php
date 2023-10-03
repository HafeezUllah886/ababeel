<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outflow extends Model
{
    use HasFactory;

    protected $fillable = (
        [
            'to',
            'paidIn',
            'isPaid',
            'date',
            'discount',
            'amountPaid',
            'desc',
            'ref'
        ]
    );

    public function customer(){
        return $this->belongsTo(accounts::class, 'to', 'id');
    }
    public function account(){
       return $this->belongsTo(accounts::class, 'paidIn', 'id');
    }
    public function details(){
        return $this->hasMany(outflowDetails::class, 'bill_id', 'id');
    }
}
