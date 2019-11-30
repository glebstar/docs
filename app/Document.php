<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'description'];

    public function file()
    {
        return $this->hasOne('App\File');
    }
}
