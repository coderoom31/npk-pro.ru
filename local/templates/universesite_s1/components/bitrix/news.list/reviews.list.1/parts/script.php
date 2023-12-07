<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;

/**
 * @var string $sTemplateId
 * @var array $arVisual
 */

?>
    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');

            var root = data.nodes;
            var container = $('[data-role="container"]', root);

            <?php if ($arVisual['VIDEO']['SHOW']) { ?>
            container.lightGallery({
                'selector': '[data-role="media"]'
            });
            <?php } ?>
        }, {
            'name': '[Component] bitrix:news.list (reviews.list.1)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<? if($arVisual['VIDEO']['BIG']['FULL']) { ?>
    <script>
        template.load(function(data){
            var $ = this.getLibrary('$');
            var paddings = 40;
            $('.big-view').each(function(){
                var review = $(this).find('.reviews-list-item-review');
                var indent = 88 - (review.height() + paddings);
                review.css('bottom',indent+'px');
            });

            $(window).on('resize',function(){
                $('.big-view').each(function(){
                    var review = $(this).find('.reviews-list-item-review');
                    var indent = 88 - (review.height() + paddings);
                    review.css('bottom',indent+'px');
                });
            });
        }, {
            'name': '[Component] bitrix:news.list (reviews.list.1)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<? } ?>