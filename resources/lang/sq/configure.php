<?php

return [

    /*
    |--------------------------------------------------------------------------
    | config.show.blade.php
    |--------------------------------------------------------------------------
    |
    */

    'context' => 'Konfiguro Element&euml;t',

    'tabs' => [

        'categories' => 'Kategorit&euml;',
        'unity' => 'Nj&euml;sit&euml;',
        'types' => 'Tipet',
        'vat' => 'Taksa',

    ],

    'categories' => [

        'form' => [

            'add_category' => 'Shto Kategori',
            'name' => 'Emri i Kategoris&euml;',
            'type' => 'Tipi',
            'add' => 'Shto',

        ],

        'name' => 'Kategoria',
        'item' => 'Tipi'

    ],

    'unities' => [

        'form' => [

            'add_unity' => 'Shto Nj&euml;si',
            'name' => 'Emri i Nj&euml;sis&euml;',
            'type' => 'Tipi',
            'add' => 'Shto',

        ],

        'name' => 'Nj&euml;sia',
        'item' => 'Tipi'

    ],

    'types' => [

        'form' => [

            'add_type' => 'Shto Tip',
            'name' => 'Emri i Tipit',
            'type' => 'Tipi i elementit',
            'add' => 'Shto',

        ],

        'name' => 'Tipi',
        'item' => 'Elementi'

    ],

    'vat' => [

        'form' => [

            'add_vat' => 'Shto Taks&euml;',
            'name' => 'Emri i Taks&euml;s',
            'value' => 'Vlera e Taks&euml;s',
            'value_placeholder' => 'Vlera (psh. 0.2)',
            'add' => 'Shto',

        ],

        'name' => 'Taksa',
        'item' => 'Vlera'

    ],


];