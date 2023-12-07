<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!Loader::includeModule('intec.core'))
    return;

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

Loc::loadMessages(__FILE__);

?>
<div id="<?= $sTemplateId ?>" class="ns-bitrix c-catalog-element c-catalog-element-services-default-3">
    <?php include(__DIR__.'/parts/blocks.php') ?>


<? if($arResult["DISPLAY_PROPERTIES"]["IMG_GALLERY"]["VALUE"]) :?>
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="widget gallery-in-service">
				<div class="widget-header">
					<div class="widget-header-wrapper intec-content">
						<div class="widget-header-wrapper-2 intec-content-wrapper">
									<div class="widget-title align-left">
									Галерея                       
								 </div>
							</div>
					</div>
				</div>
				<div class="img-list widget-content">
						<?foreach ($arResult["DISPLAY_PROPERTIES"]["IMG_GALLERY"]["VALUE"] as $files):?> 
							<div class="img-list-item">
								<? $arFile = CFile::GetFileArray($files); 
								if( $arFile) :?>
									<a class="fancybox fancybox-services" rel="group" href="<?=$arFile["SRC"]?>">
										<img src="<?=$arFile["SRC"]?>" alt="img">
									</a>
								<? endif; ?> 
							</div>
						<?endforeach?>
				</div>
			</div>
		</div>
<? endif; ?> 
</div>




