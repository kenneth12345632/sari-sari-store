<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Utang;

class Customer extends Model
{
    protected $fillable = ['name','phone','address'];

    public function utangs()
    {
        return $this->hasMany(Utang::class);
    }

    // Correct calculation for total unpaid utang
    public function totalUtang()
    {
        return $this->utangs()->where('status', 'unpaid')->sum('amount');
    }
}
