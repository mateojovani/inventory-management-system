<?php

return [

    /*
    |--------------------------------------------------------------------------
    | config.show.blade.php
    |--------------------------------------------------------------------------
    |
    */

    'context' => 'Configure Items',

    'tabs' => [

        'categories' => 'Categories',
        'unity' => 'Unity',
        'types' => 'Types',
        'vat' => 'VAT',

    ],

    'categories' => [

        'form' => [

            'add_category' => 'Add Category',
            'name' => 'Category Name',
            'type' => 'Item Type',
            'add' => 'Add',

        ],

        'name' => 'Category',
        'item' => 'Item'

    ],

    'unities' => [

        'form' => [

            'add_unity' => 'Add Unity',
            'name' => 'Unity Name',
            'type' => 'Item Type',
            'add' => 'Add',

        ],

        'name' => 'Unity',
        'item' => 'Item'

    ],

    'types' => [

        'form' => [

            'add_type' => 'Add Type',
            'name' => 'Type Name',
            'type' => 'Item Type',
            'add' => 'Add',

        ],

        'name' => 'Type',
        'item' => 'Item'

    ],

    'vat' => [

        'form' => [

            'add_vat' => 'Add VAT',
            'name' => 'VAT Name',
            'value' => 'VAT Value',
            'value_placeholder' => 'VAT Value (ex. 0.2)',
            'add' => 'Add',

        ],

        'name' => 'VAT',
        'item' => 'Value'

    ],


];