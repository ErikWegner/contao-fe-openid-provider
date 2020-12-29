<?php

$GLOBALS['TL_DCA']['tl_feopenid_refreshtoken'] = [
    'config' => [
        'dataContainer' => 'Table',
        'sql' => [
            'keys' => [
                'token' => 'primary',
            ],
        ],
    ],
    'fields' => [
        'token' => [
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'expiryDateTime' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0]
        ],
        'accessToken' => [
            'inputType' => 'text',
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'revoked' => [
            'sql' => ['type' => 'string', 'length' => 1, 'default' => '']
        ],
    ],
];
