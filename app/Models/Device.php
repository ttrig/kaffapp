<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Device extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $guarded = [];

    protected $hidden = [
        'api_token',
    ];

    protected $casts = [
        'capacity_in_cl' => 'int',
        'fresh_for_minutes' => 'int',
    ];

    public function data()
    {
        return $this->hasMany(Data::class);
    }
}
