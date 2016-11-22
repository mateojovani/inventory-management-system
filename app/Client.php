<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'Client_id';
    public $timestamps = false;

    protected $fillable = ['client_name',
        'client_address',
        'client_email',
        'client_phone',
        'client_mobile',
        'deleted'];
}
