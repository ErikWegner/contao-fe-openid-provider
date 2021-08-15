<?php

$GLOBALS['BE_MOD']['system']['feopenid'] = [
    'tables' => ['tl_feopenid_client', 'tl_feopenid_redirecturi'],
];

$GLOBALS['TL_MODELS']['tl_feopenid_client'] = ErikWegner\FeOpenidProvider\Model\ClientModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_redirecturi'] = ErikWegner\FeOpenidProvider\Model\RedirectUriModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_accesstoken'] = ErikWegner\FeOpenidProvider\Model\AccessTokenModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_authcode'] = ErikWegner\FeOpenidProvider\Model\AuthCodeModel::class;
$GLOBALS['TL_MODELS']['tl_feopenid_refreshtoken'] = ErikWegner\FeOpenidProvider\Model\RefreshTokenModel::class;

/** Clean expired tokens */
$GLOBALS['TL_CRON']['hourly'][] = [\ErikWegner\FeOpenidProvider\Service\Cron::class, 'onHourly'];

/**
 * Register callbacks to provide additional fields for access tokens.
 *
 * The callback function must return a dictionary of string keys and
 * JSON applicable values. To register a callback, add a entry:
 * The array key is used as name for a sub structure. The registered value can be
 */
$GLOBALS['FEOPENID']['access_token_additional_fields_callbacks'] = [
    '' => ['ErikWegner\FeOpenidProvider\Service\DefaultProfileFields', 'generateFromMember'],
    'contao' => ['ErikWegner\FeOpenidProvider\Service\DefaultProfileFields', 'generateContaoStructureFromMember'],
];
