<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expenses extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ([
        'account_id',
        'date',
        'amount',
        'desc',
        'ref'
    ]);

    public function account(){
        return $this->belongsTo(accounts::class, 'account_id', 'id');
    }
}
