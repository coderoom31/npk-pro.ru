<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

?>
<script type="text/javascript">
    template.load(function() {
        var obStoreAmount = new JCCatalogStoreSKU(<?= CUtil::PhpToJSObject($arResult['JS'], false, true, true); ?>);

        offers.on('change', function (event, offer, values) {
            obStoreAmount.offerOnChange(offer.id);
        });
    }, {
        'name': '[Component] bitrix:catalog.store.amount (.default)',
        'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>
    });
</script>