<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outflowDetails extends Model
{
    use HasFactory;
    protected $fillable = (
        [
            'bill_id',
            'product_id',
            'stock_id',
            'unit',
            'warehouse',
            'width',
            'length',
            'sqf',
            'qty',
            'price',
        ]
    );

    public function outflow(){
        return $this->belongsTo(outflow::class, 'bill_id', 'id');
    }

    public function product(){
        return $this->belongsTo(products::class, 'product_id', 'id');
    }
}
