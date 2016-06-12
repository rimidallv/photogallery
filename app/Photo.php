<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable=[
        'file'

    ];
protected $uploads='/images/'; // for accessor

    public function  getFileAttribute($value) { //склеиваем /images/ with name of picture in DB
            return $this->uploads . $value;
    }
    public function post() {
        return $this->hasOne('App\Post');
    }
    public function category() {
        return $this->hasOne('App\Category');
    }
}
