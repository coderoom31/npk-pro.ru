<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\template\Properties;

/**
 * @var array $arParams
 * @var bool $bAjax
 */

if (!defined('EDITOR')) {
    if (Properties::get('template-images-lazyload-use'))
        $arParams['LAZYLOAD_USE'] = 'Y';

    if (Properties::get('base-consent'))
        $arParams['CONSENT_SHOW'] = 'Y';
}