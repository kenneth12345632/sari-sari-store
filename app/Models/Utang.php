<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utang extends Model
{
    protected $table = 'utangs';

    protected $fillable = [
        'customer_id',
        'item_name',
        'amount',
        'due_date',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function isOverdue()
    {
        return $this->status === 'unpaid'
            && $this->due_date
            && $this->due_date < now()->toDateString();
    }
}
