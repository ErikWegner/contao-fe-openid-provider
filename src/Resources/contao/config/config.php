<?php

$GLOBALS['BE_MOD']['system']['feopenid'] = [
    'tables' => ['tl_feopenid_client', 'tl_feopenid_redirecturi'],
];

$GLOBALS['TL_MODELS']['tl_feopenid_client'] = ErikWegner\FeOpenidProvider\Model\ClientModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_redirecturi'] = ErikWegner\FeOpenidProvider\Model\RedirectUriModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_accesstoken'] = ErikWegner\FeOpenidProvider\Model\AccessTokenModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_authcode'] = ErikWegner\FeOpenidProvider\Model\AuthCodeModel::class;
