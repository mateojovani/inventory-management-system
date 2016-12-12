<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datasheet extends Model
{
    protected $primaryKey = 'datasheet_id';
    public $timestamps = false;

    protected $fillable = ['source_sheet_id',
        'source_sheet_name',
        'id_item',
        'item_price',
        'quantity',
        'total_no_vat',
        'total_vat',
        'total_with_vat',
        'total_for_interes',
        'sconto',
        'deleted'
        ];
}
