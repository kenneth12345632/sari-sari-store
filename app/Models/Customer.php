<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','phone','address'];

   public function utangs()
{
    return $this->hasMany(\App\Models\Utang::class);
}

// For total utang
public function totalUtang()
{
    return $this->utangs()->where('status', 'unpaid')->sum('amount');
}




}

