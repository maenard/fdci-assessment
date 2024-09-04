<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ability extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'route_id'
    ];

    public function route(): HasOne
    {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }
}
