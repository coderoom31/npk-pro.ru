<?php
?>
<div class="products">

    <?php foreach ($arResult['ITEMS'] as $arProduct) { ?>
        <div class="products__item">
            <h2 class="products__title mobile"><?php echo $arProduct['NAME']; ?></h2>
            <div class="products__wrap">
                <div class="products__img">

                    <?php echo $arProduct['ICONS']['TEXT']; ?>

                    <img class="image" src="<?php echo $arProduct['IMAGE']; ?>"
                         alt="<?php echo $arProduct['NAME']; ?>">
                </div>
                <div class="products__block">
                    <h2 class="products__title desktop"><?php echo $arProduct['NAME']; ?></h2>
                    <div class="products__tabs">
                        <?php foreach ($arProduct['TABS'] as $arTab) { ?>
                            <div class="products__tab">
                                <div class="products__header">
                                    <span class="products__name"><?php echo $arTab['NAME']; ?></span>
                                    <div class="products__icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M8.58579 9.99986L0.807613 17.778L2.22183 19.1922L10 11.4141L17.7782 19.1922L19.1924 17.778L11.4142 9.99986L19.1924 2.22168L17.7782 0.807471L10 8.58565L2.22183 0.80747L0.807613 2.22168L8.58579 9.99986Z"
                                                  fill="white"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="products__content"><?php echo $arTab['CONTENT']['TEXT']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($arProduct['PDF']) { ?>
                        <div class="products__files">
                            <a href="<?php echo $arProduct['PDF']; ?>" download>
                                <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/nodes/pdf.svg" alt="pdf">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>