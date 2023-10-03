<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    use HasFactory;
    protected $fillable = (
        [
            'title',
            'type',
            'cat',
            'contact',
            'isActive',
            'desc'
        ]
    );
}
