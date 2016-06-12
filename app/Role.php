<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable=['name'
    ];

    public function user() {
        return $this->hasOne('App\User');
    }
}
