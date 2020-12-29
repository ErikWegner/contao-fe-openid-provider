<?php

$GLOBALS['TL_DCA']['tl_feopenid_client'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ctable' => ['tl_feopenid_redirecturi'],
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['name'],
            'flag' => 1,
            'panelLayout' => 'search,limit'
        ],
        'label' => [
            'fields' => ['name'],
            'format' => '%s',
        ],
        'operations' => [
            'edit' => [
                'href' => 'table=tl_feopenid_redirecturi',
                'icon' => 'edit.svg',
            ],
            'editheader' => [
                'href' => 'act=edit',
                'icon' => 'header.svg',
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg'
            ],
        ],
    ],
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'autoincrement' => true],
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'name' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_client']['name'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['unique' => true, 'tl_class' => 'w100', 'maxlength' => 255, 'mandatory' => true],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'identifier' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_client']['identifier'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['unique' => true, 'tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'confidential' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_client']['confidential'],
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w100'],
            'sql' => ['type' => 'string', 'length' => 1, 'default' => '']
        ],
        'secret' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_client']['secret'],
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
    ],
    'palettes' => [
        'default' => '{client_legend},name,identifier,confidential,secret'
    ],
];
