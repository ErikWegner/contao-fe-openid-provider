<?php

$GLOBALS['BE_MOD']['system']['feopenid'] = [
    'tables' => ['tl_feopenid_client', 'tl_feopenid_redirecturi'],
];

$GLOBALS['TL_MODELS']['tl_feopenid_client'] = ErikWegner\FeOpenidProvider\Model\ClientModel::class;
