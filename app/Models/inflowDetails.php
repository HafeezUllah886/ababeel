<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inflowDetails extends Model
{
    use HasFactory;
    protected $fillable = (
        [
            'bill_id',
            'product_id',
            'qty',
            'price',
            'warehouse',
            'stock_id'
        ]
    );

    public function inflow(){
        return $this->belongsTo(inflow::class, 'bill_id', 'id');
    }

    public function product(){
        return $this->belongsTo(products::class, 'product_id', 'id');
    }

    public function warehouse1(){
        return $this->belongsTo(warehouses::class, 'warehouse', 'id');
    }
}
