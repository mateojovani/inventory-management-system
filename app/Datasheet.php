<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datasheet extends Model
{
    protected $primaryKey = 'datasheet_id';
    protected $table = 'datasheet';
    public $timestamps = false;

    protected $fillable = ['source_sheet_id',
        'source_sheet_name',
        'id_item',
        'item_price',
        'quantity',
        'subtotal_no_vat',
        'subtotal_vat',
        'subtotal_with_vat',
        'subtotal_for_interes',
        'subdiscount',
        'deleted'
        ];
}
