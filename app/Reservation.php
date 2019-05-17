<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasApiTokens;

    // Disable timestamps
    public $timestamps = false;

    protected $fillable = [
        'cid', 'fecha_inicio', 'fecha_final'
    ];
}
