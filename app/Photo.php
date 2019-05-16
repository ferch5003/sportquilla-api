<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasApiTokens;

    // cid is the primary key of fields table
    protected $primaryKey = 'cid';

    // Disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'ruta'
    ];
}
