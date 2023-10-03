<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;
    protected $fillable = (
        [
            'product_id',
            'warehouse',
            'date',
            'db',
            'cr',
            'desc',
            'trn',
        ]
    );

    public function product(){
        return $this->belongsTo(products::class, 'product_id', 'id');
    }

    public function warehouse1(){
        return $this->belongsTo(warehouses::class, 'warehouse', 'id');
    }
}
