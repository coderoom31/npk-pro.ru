<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var array $arVisual
 * @var string $sTemplateId
 */

$arSlider = $arVisual['SLIDER'];
$arResponsive = [
    '0' => ['items' => 1]
];

if ($arVisual['COLUMNS'] >= 2)
    $arResponsive['551'] = ['items' => 2];

if ($arVisual['COLUMNS'] >= 3)
    $arResponsive['751'] = ['items' => 3];

if ($arVisual['COLUMNS'] >= 4)
    $arResponsive['901'] = ['items' => 4];

if ($arVisual['COLUMNS'] >= 5)
    $arResponsive['1051'] = ['items' => 5];

?>
<?php if (!defined('EDITOR')) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var gallery = $('[data-entity="gallery"]', data.nodes);

            gallery.lightGallery({
                'selector': '[data-play="true"]'
            });
        }, {
            'name': '[Component] intec.universe:main.videos (template.1) > gallery',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>
<?php if ($arSlider['USE']) { ?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');
            var slider = $('[data-role="slider"]', data.nodes);

            slider.owlCarousel(<?= JavaScript::toObject([
                'items' => $arVisual['COLUMNS'],
                'autoplay' => $arSlider['AUTO']['USE'],
                'autoplaySpeed' => $arSlider['AUTO']['SPEED'],
                'autoplayTimeout' => $arSlider['AUTO']['TIME'],
                'autoplayHoverPause' => $arSlider['AUTO']['PAUSE'],
                'loop' => $arSlider['LOOP'],
                'nav' => false,
                'navText' => ['', ''],
                'dots' => true,
                'responsive' => $arResponsive
            ]) ?>);
        }, {
            'name': '[Component] intec.universe:main.videos (template.1) > slider',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php } ?>
<?php unset($arResponsive, $arSlider) ?>