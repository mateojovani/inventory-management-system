<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrysheet extends Model
{
    protected $primaryKey = 'entrysheet_id';
    public $timestamps = false;

    protected $fillable = ['id_furnisher',
        'serial_number',
        'document_date',
        'id_user',
        'total_no_vat',
        'total_vat',
        'total_with_vat',
        'total_for_interes',
        'interes',
        'amount_payed',
        'deleted',
        'system_date',
        'comment'];
}
