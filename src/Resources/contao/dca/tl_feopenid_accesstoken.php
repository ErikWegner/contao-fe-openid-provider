<?php

$GLOBALS['TL_DCA']['tl_feopenid_accesstoken'] = [
    'config' => [
        'dataContainer' => 'Table',
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
        'identifier' => [
            'label' => &$GLOBALS['TL_LANG']['tl_feopenid_client']['identifier'],
            'inputType' => 'text',
            'eval' => ['unique' => true, 'tl_class' => 'w50', 'maxlength' => 255, 'mandatory' => true],
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'expiryDateTime' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'userIdentifier' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'client' => [
            'foreignKey' => 'tl_feopenid_client.name',
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
            'relation' => ['type' => 'belongsTo', 'load' => 'lazy']
        ],
        'arrscopes' => [
            'inputType' => 'text',
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'revoked' => [
            'sql' => ['type' => 'string', 'length' => 1, 'default' => '']
        ],
    ],
    'palettes' => [
        'default' => '{client_legend},name,identifier,confidential'
    ],
];
