<?php

return [

    /*
    |--------------------------------------------------------------------------
    | outputsheet.show.blade.php
    |--------------------------------------------------------------------------
    |
    */

    'context' => 'OutPut Sheet',

    'grid_context' => 'OutPut Sheet Grid',

    'report' =>[

        'title' => 'OutPut Sheet Report',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
        'generate' => 'Generate'

    ],


    'head' => [

        'serial' => 'Serial No',
        'client' => 'Client',
        'date' => 'Date',
        'comment' => 'Comment'

    ],

    'datasheet' => [

        'item' => 'Item',
        'total_no_vat' => 'Total no VAT',
        'discount' => 'Discount (%)',
        'total' => 'Total',
        'vat' => 'Vat'
    ],

    'total' => [

        'total' => 'Total',
        'discount' => 'Discount',
        'grand' => 'Grand Total'
    ],

    'tooltip' => [

        'add' => 'Add Item'
    ],

    'submit' => 'Submit'



];