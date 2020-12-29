<?php

$GLOBALS['TL_DCA']['tl_feopenid_authcode'] = [
    'config' => [
        'dataContainer' => 'Table',
        'sql' => [
            'keys' => [
                'code' => 'primary',
            ],
        ],
    ],
    'fields' => [
        'code' => [
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
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
];
