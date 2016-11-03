<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;
    protected $primaryKey = 'User_id';

    protected $fillable = ['User_name', 'User_address', 'User_email', 'User_phone', 'User_mobile', 'username', 'password', 'id_role'];

}
