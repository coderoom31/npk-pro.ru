<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Security\Sign\Signer;
use intec\core\helpers\JavaScript;

/**
 * @var array $arResult
 * @var array $arParams
 * @var array $arNavigation
 * @var string $sTemplateId
 * @var CBitrixComponentTemplate $this
 */

$signer = new Signer();

$arParameters = JavaScript::toObject([
    'component' => [
        'path' => $this->getComponent()->getPath().'/ajax.php',
        'template' => $this->GetName(),
        'parameters' => $signer->sign(
            base64_encode(serialize($arParams)),
            'main.news'
        )
    ],
    'navigation' => [
        'id' => $arNavigation['ID'],
        'current' => $arNavigation['PAGE']['CURRENT'],
        'count' => $arNavigation['PAGE']['COUNT']
    ],
    'container' => [
        'root' => '#'.$sTemplateId,
        'items' => '[data-role="items"]',
        'button' => '[data-role="navigation.button"]'
    ]
]);

?>
<script type="text/javascript">
    template.load(function (data) {
        let navigation = new MainNewsNavigation();

        navigation.init(<?= $arParameters ?>);
    }, {
        'name': '[Component] intec.universe:main.news (template.1)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
        'loader': {
            'name': 'lazy'
        }
    });
</script>