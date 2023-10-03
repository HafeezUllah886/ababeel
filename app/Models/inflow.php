<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inflow extends Model
{
    use HasFactory;

    protected $fillable = (
        [
            'from',
            'paidFrom',
            'isPaid',
            'date',
            'status',
            'ref'
        ]
    );

    public function supplier(){
        return $this->belongsTo(accounts::class, 'from', 'id');
    }
    public function account(){
       return $this->belongsTo(accounts::class, 'paidFrom', 'id');
    }

    public function details(){
        return $this->hasMany(inflowDetails::class, 'bill_id', 'id');
    }
}
