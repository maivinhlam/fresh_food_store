<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'session_id', 'product_id', 'amount',
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}