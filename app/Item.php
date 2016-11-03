<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'Item_id';
    public $timestamps = false;

    protected $fillable = ['item_code',
                            'Item_name',
                            'id_itemcategory',
                            'id_itemunity',
                            'item_price',
                            'id_vat',
                            'id_itemtype',
                            'deleted',
                            'is_product'];
}
