<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tracking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(registration::class, 'appID', 'id');
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }
    public function to()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}
