<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outputsheet extends Model
{
    protected $primaryKey = 'outsheet_id';
    protected $table = 'outputsheet';
    public $timestamps = false;

    protected $fillable = ['id_client',
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
