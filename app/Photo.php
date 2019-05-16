<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $primaryKey = 'cid';

    protected $fillable = [
        'path'
    ];
}
