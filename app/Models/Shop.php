<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Shop extends Model
{
    use HasFactory;
    
    public function users() {
        return $this->hasMany(User::class);
    }
    public function cash()
    {
        return $this->hasMany(Cash::class);
    }

}
