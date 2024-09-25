<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    use HasFactory;
    protected $table = 'cashes';
    public $timestamps = true;
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
