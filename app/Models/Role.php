<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $fillable = [
        'name',
        'description'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
}