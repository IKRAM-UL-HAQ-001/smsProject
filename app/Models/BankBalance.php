<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBalance extends Model
{
    use HasFactory;
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }
}
