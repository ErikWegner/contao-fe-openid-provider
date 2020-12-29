<?php

$GLOBALS['TL_DCA']['tl_feopenid_redirecturi'] = [
    'config' => [
        'dataContainer' => 'Table',
        'ptable' => 'tl_feopenid_client',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ]
    ],
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['uri'],
            'headerFields' => ['uri'],
            'panelLayout' => 'search,limit',
            'child_record_callback' => function (array $row) {
                return '<div class="tl_content_left">' . $row['uri'] . ' [' . $row['number'] . ']</div>';
            },
        ],
        'label' => [
            'fields' => ['uri'],
            'format' => '%s',
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.svg',
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
        'pid' => [
            'foreignKey' => 'tl_feopenid_client.name',
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
            'relation' => ['type' => 'belongsTo', 'load' => 'lazy']
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'uri' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_redirecturi']['uri'],
            'search' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
    ],
    'palettes' => [
        'default' => 'uri'
    ],
];
