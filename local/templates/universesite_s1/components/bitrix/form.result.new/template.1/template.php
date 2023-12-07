<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\Type;

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!Loader::includeModule('intec.core'))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

?>
<div id="<?= $sTemplateId ?>" class="ns-bitrix c-form-result-new c-form-result-new-template-1 intec-ui-form">
    <?php if ($arResult['isFormNote'] === 'Y') { ?>
        <div class="form-result-new-message form-result-new-message-note">
            <div class="intec-grid intec-grid-wrap intec-grid-a-v-center">
                <div class="intec-grid-item-auto form-result-new-message-note-icon">
                    <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M34.937 10.1982L19.5102 25.625L11.7988 17.9116" stroke="#0065FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M37.875 19.5C37.875 29.6491 29.6491 37.875 19.5 37.875C9.35087 37.875 1.125 29.6491 1.125 19.5C1.125 9.35087 9.35087 1.125 19.5 1.125C22.4665 1.125 25.2595 1.84571 27.7402 3.09317" stroke="#0065FF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="intec-grid-item-auto intec-grid-item-shrink-1 form-result-new-message-note-text">
                    <?= $arResult['FORM_NOTE'] ?>
                </div>
                <div class="intec-grid-item-1 form-result-new-message-note-button-wrapper">
                    <button id="form-result-new-message-note-close-button" class="form-result-new-message-note-button intec-ui intec-ui-control-button intec-ui-scheme-current">
                        <?= Loc::getMessage('C_FORM_RESULT_NEW_DEFAULT_BUTTONS_RESET') ?>
                    </button>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <?= $arResult['FORM_HEADER'] ?>
            <?php if ($arResult["isFormErrors"] == 'Y') { ?>
                <div class="form-result-new-message intec-ui intec-ui-control-alert intec-ui-scheme-red">
                    <?= $arResult['FORM_ERRORS_TEXT'] ?>
                </div>
            <?php } ?>
            <?php if (!empty($arResult['arForm']['DESCRIPTION'])) { ?>
                <div class="form-result-new-description">
                    <?= $arResult['arForm']['DESCRIPTION'] ?>
                </div>
            <?php } ?>

            <?php if (!empty($arResult['QUESTIONS']) || $arResult['isUseCaptcha']) { ?>

                <div class="form-result-new-fields intec-ui-form-fields">

                    <?php foreach ($arResult['QUESTIONS'] as $question) { ?>
                        <?= Html::beginTag('label', [
                            'class' => Html::cssClassFromArray([
                                'form-result-new-field' => true,
                                'intec-ui-form-field' => true,
                                'intec-ui-form-field-required' => $arResult['QUESTIONS']['TEXT']['REQUIRED'] === 'Y'
                            ], true)
                        ]) ?>
                            <span class="form-result-new-field-title intec-ui-form-field-title">
                                <?= $question['CAPTION'] ?>
                                <?= $question['IS_INPUT_CAPTION_IMAGE'] == 'Y' ? '<br />'. $question['IMAGE']['HTML_CODE'] : '' ?>
                            </span>
                            <span class="form-result-new-field-content intec-ui-form-field-content">
                                <?= $question['HTML_CODE'] ?>
                            </span>
                        <?= Html::endTag('label') ?>
                    <?php } ?>

                    <?php if ($arResult['isUseCaptcha'] == 'Y') { ?>
                        <div class="form-result-new-field form-result-new-field-captcha intec-ui-form-field intec-ui-form-field-required">
                            <div class="form-result-new-field-title intec-ui-form-field-title">
                                <?= Loc::getMessage('C_FORM_RESULT_NEW_DEFAULT_FIELDS_CAPTCHA') ?>
                            </div>
                            <div class="form-result-new-field-content intec-ui-form-field-content">
                                <?= Html::hiddenInput('captcha_sid', $arResult['CAPTCHACode']) ?>
                                <div class="form-result-new-captcha intec-grid intec-grid-nowrap intec-grid-i-h-5">
                                    <div class="form-result-new-captcha-image intec-grid-item-auto">
                                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= Html::encode($arResult['CAPTCHACode']) ?>" width="180" height="40" />
                                    </div>
                                    <div class="form-result-new-captcha-input intec-grid-item">
                                        <input type="text" class=" intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-mod-round-3 intec-ui-size-2" name="captcha_word" size="30" maxlength="50" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            <?php } ?>
            <?php if ($arResult['CONSENT']['SHOW']) { ?>
                <div class="form-result-new-consent">
                    <label class="intec-ui intec-ui-control-switch intec-ui-scheme-current">
                        <input type="checkbox" checked="checked" onchange="this.checked = !this.checked" />
                        <span class="intec-ui-part-selector"></span>
                        <span class="intec-ui-part-content"><?= Loc::getMessage('C_FORM_RESULT_NEW_DEFAULT_CONSENT', [
                            '#URL#' => $arResult['CONSENT']['URL']
                        ]) ?></span>
                    </label>
                </div>
            <?php } ?>
            <div class="form-result-new-buttons">
                <div class="intec-grid-item-auto">
                    <?= Html::hiddenInput('web_form_sent', 'Y') ?>
                    <?= Html::submitButton(!empty($arResult['arForm']['BUTTON']) ? $arResult['arForm']['BUTTON'] : Loc::getMessage('C_FORM_RESULT_NEW_DEFAULT_BUTTONS_SUBMIT'), [
                        'class' => [
                            'intec-ui' => [
                                '',
                                'control-button',
                                'scheme-current'
                            ]
                        ],
                        'name' => 'web_form_submit',
                        'value' => 'Y',
                        'disabled' => Type::toInteger($arResult['F_RIGHT']) < 10 ? 'disabled' : null
                    ]) ?>
                </div>
            </div>
        <?= $arResult['FORM_FOOTER'] ?>
    <?php } ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');

            var root = data.nodes;
            var form = $('form', root);

            var button = $('#form-result-new-message-note-close-button', root);
            button.on("click", function () {
                var form = document.querySelector("#UniverseWebForm");
                var overlay = document.querySelector("#popup-window-overlay-UniverseWebForm");
                form.style.display = "none";
                overlay.style.display = "none";
            });

            form.on('submit', function () {
                if (window.yandex && window.yandex.metrika) {
                    window.yandex.metrika.reachGoal('forms');
                    window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['arForm']['ID']) ?>);
                    window.yandex.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['arForm']['ID'].'.send') ?>);
                }
            });
        }, {
            'name': '[Component] bitrix:form.result.new (.template.1)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>
        });
    </script>
</div>