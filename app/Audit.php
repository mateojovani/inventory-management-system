<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected  $table = 'updatehistory';
    protected $primaryKey = 'updatehistory_id';
    public $timestamps = false;

    protected $fillable = ['updated_table',
        'updated_field',
        'id_record',
        'id_user',
        'updated_date',
        'old_value',
        'new_value',
        'updated_description'];
}
