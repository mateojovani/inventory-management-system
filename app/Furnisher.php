<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Furnisher extends Model
{
    protected $primaryKey = 'Furnisher_id';
    public $timestamps = false;

    protected $fillable = ['furnisher_name',
        'furnisher_address',
        'furnisher_email',
        'furnisher_phone',
        'furnisher_mobile',
        'deleted'];
}
