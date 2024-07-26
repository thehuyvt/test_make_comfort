<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'password','name', 'phone_number', 'role', 'status'];

    public function orders():HasMany
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
