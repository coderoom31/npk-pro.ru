<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

?>

<?=Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => Html::cssClassFromArray([
        'ns-bitrix' => true,
        'c-sale-personal-section' => true,
        'c-sale-personal-section-default-main-profile-default' => true,
    ], true)
]) ?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <?if ($arResult["strProfileError"]) {?>
            <div class="intec-ui intec-ui-control-alert intec-ui-scheme-red intec-ui-m-b-20">
                <strong><?=$arResult["strProfileError"];?></strong>
            </div>
        <?}?>
        <?if ($arResult['DATA_SAVED'] == 'Y') {?>
            <div class="intec-ui intec-ui-control-alert intec-ui-scheme-green-1 intec-ui-m-b-20">
                <strong><?=Loc::getMessage('PROFILE_DATA_SAVED');?></strong>
            </div>
        <?}?>
        <form method="post" name="form1" action="<?=$APPLICATION->GetCurUri()?>" enctype="multipart/form-data" role="form">
            <?=$arResult["BX_SESSION_CHECK"]?>
            <input type="hidden" name="lang" class="intec-ui intec-ui-control-input" value="<?=LANG?>" />
            <input type="hidden" name="ID" class="intec-ui intec-ui-control-input" value="<?=$arResult["ID"]?>" />
            <input type="hidden" name="LOGIN" class="intec-ui intec-ui-control-input" value="<?=$arResult["arUser"]["LOGIN"]?>" />

            <div class="intec-grid intec-grid-wrap intec-grid-i-10 main-profile-block-shown" id="user_div_reg">
                <div class="intec-grid-item-1 main-profile-block-date-info">
                    <?if($arResult["ID"] > 0) {
                        if ($arResult["arUser"]["TIMESTAMP_X"]) {?>
                            <div class="intec-ui intec-ui-control-alert intec-ui-scheme-current intec-ui-m-b-10">
                                <span><strong><?=Loc::getMessage('LAST_UPDATE')?></strong></span>
                                <span><strong><?=$arResult["arUser"]["TIMESTAMP_X"]?></strong></span>
                            </div>
                        <?}

                        if ($arResult["arUser"]["LAST_LOGIN"]) {?>
                            <div class="intec-ui intec-ui-control-alert intec-ui-scheme-current">
                                <span><strong><?=Loc::getMessage('LAST_LOGIN')?></strong></span>
                                <span><strong><?=$arResult["arUser"]["LAST_LOGIN"]?></strong></span>
                            </div>
                        <?}
                    }?>
                </div>

                <div class="intec-grid-item-1 intec-grid intec-grid-wrap intec-grid main-profile-block-user-info">
                    <?if (!in_array(LANGUAGE_ID,array('ru', 'ua'))) {?>
                        <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                            <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                                <label class="intec-grid-item-auto main-profile-form-label" for="main-profile-title"><?=Loc::getMessage('main_profile_title')?></label>
                                <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?=$arResult["arUser"]["TITLE"]?>" />
                            </div>
                        </div>
                    <?}?>
                    <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                        <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                            <label class="intec-grid-item-auto main-profile-form-label" for="main-profile-name"><?=Loc::getMessage('NAME')?></label>
                            <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?=$arResult["arUser"]["NAME"]?>" />
                        </div>
                    </div>
                    <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                        <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                            <label class="intec-grid-item-auto main-profile-form-label" for="main-profile-last-name"><?=Loc::getMessage('LAST_NAME')?></label>
                            <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?=$arResult["arUser"]["LAST_NAME"]?>" />
                        </div>
                    </div>
                    <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                        <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                            <label class="intec-grid-item-auto main-profile-form-label" for="main-profile-second-name"><?=Loc::getMessage('SECOND_NAME')?></label>
                            <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" />
                        </div>
                    </div>
                    <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                        <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                            <label class="intec-grid-item-auto main-profile-form-label" for="main-profile-email"><?=Loc::getMessage('EMAIL')?></label>
                            <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?=$arResult["arUser"]["EMAIL"]?>" />
                        </div>
                    </div>
                    <?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == '') {?>
                        <div class="intec-grid-item-1 form-group">
                            <div class="main-profile-form-password-annotation">
                                <?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?>
                            </div>
                        </div>

                        <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                            <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                                <label class="intec-grid-item-auto intec-grid-item-1024 intec-grid-item-1024-shrink-1 main-profile-form-label" for="main-profile-password"><?=Loc::getMessage('NEW_PASSWORD_REQ')?></label>
                                <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control bx-auth-input main-profile-password" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off"/>
                            </div>
                        </div>

                        <div class="intec-grid-item-1 intec-ui-m-b-10 form-group">
                            <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                                <label class="intec-grid-item-auto intec-grid-item-1024 intec-grid-item-1024-shrink-1 main-profile-form-label main-profile-password" for="main-profile-password-confirm">
                                    <?=Loc::getMessage('NEW_PASSWORD_CONFIRM')?>
                                </label>
                                <input class="intec-ui intec-ui-control-input intec-ui-mod-block intec-ui-m-l-10 form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
                            </div>
                        </div>

                    <?}?>
                </div>
            </div>

            <div class="intec-ui-m-t-20 main-profile-form-buttons-block">
                <input type="submit" name="save" class="intec-ui intec-ui intec-ui-control-button intec-ui-scheme-current intec-ui-size-2 main-profile-submit" value="<?=(($arResult["ID"]>0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD"))?>">
                &nbsp;
                <input type="submit" class="intec-ui intec-ui-control-button intec-ui-scheme-current intec-ui-size-2"  name="reset" value="<?echo GetMessage("MAIN_RESET")?>">
            </div>
        </form>
    </div>
</div>
<?= Html::endTag('div') ?>