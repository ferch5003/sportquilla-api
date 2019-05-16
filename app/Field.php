<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasApiTokens, Notifiable;
    protected $primaryKey = 'cid';

    protected $fillable = [
        'name', 'location', 'description', 'rating', 'begin_time', 'final_time'
    ];
}
