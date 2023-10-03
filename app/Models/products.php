<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class products extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'color',
        'unit',
        'length',
        'width',
        'sqf',
        'price',
        'img',
        'purchase_price',
        'sqf_price',
    ];

    public function stock(){
        return $this->hasMany(inventory::class, 'product_id', 'id');
    }
}
