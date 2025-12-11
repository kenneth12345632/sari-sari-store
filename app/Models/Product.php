<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','category','stock','price'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
