<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

/**
 * @global CMain $APPLICATION
 */

?>
<?php $APPLICATION->IncludeComponent(
    'intec.universe:main.widget',
    'contacts.1',
    array(
        "IBLOCK_TYPE" => "content",
        "IBLOCK_ID" => "35",
        "SETTINGS_USE" => "Y",
        "NEWS_COUNT" => "20",
        "MAIN" => "268",
        "PROPERTY_CODE" => [
            "ADDRESS",
            "CITY",
            "PHONE",
            "MAP"
        ],
        "PROPERTY_ADDRESS" => "ADDRESS",
        "PROPERTY_CITY" => "CITY",
        "PROPERTY_PHONE" => "PHONE",
        "PROPERTY_MAP" => "MAP",
        "MAP_VENDOR" => "yandex",
        "WEB_FORM_TEMPLATE" => ".default",
        "WEB_FORM_ID" => "2",
        "WEB_FORM_NAME" => "Задать вопрос",
        "WEB_FORM_CONSENT_URL" => "/company/consent/",
        "FEEDBACK_BUTTON_TEXT" => "Написать",
        "FEEDBACK_TEXT" => "Связаться с руководителем",
        "FEEDBACK_IMAGE" => "#TEMPLATE_PATH#/images/face.png",
        "ADDRESS_SHOW" => "Y",
        "PHONE_SHOW" => "Y",
        "SHOW_FORM" => "Y",
        "FEEDBACK_TEXT_SHOW" => "Y",
        "FEEDBACK_IMAGE_SHOW" => "Y",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => 3600000
    ),
    false,
    array()
); ?>