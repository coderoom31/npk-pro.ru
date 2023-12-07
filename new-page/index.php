<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая KJK");

use \Bitrix\Main\Page\Asset;


Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/swiper.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/nodes.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/swiper.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/fslightbox.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/nodes.js");

$arResult = [];
?>



<?php
$arSystems = \Bitrix\Iblock\Elements\ElementNodesSystemTable::getList([
    'select' => [
        'ID',
        'NAME',
        'PREVIEW_PICTURE',
        'PREVIEW_TEXT',
        'LINK_' => 'LINK'
    ],
    'filter' => [
        '=ACTIVE' => 'Y'
    ],
])->fetchAll();

foreach ($arSystems as $arSystem) {
    $arResult['SYSTEMS'][$arSystem['ID']]['NAME'] = $arSystem['NAME'];
    $arResult['SYSTEMS'][$arSystem['ID']]['IMAGE'] = CFile::GetPath($arSystem['PREVIEW_PICTURE']);
    $arResult['SYSTEMS'][$arSystem['ID']]['TEXT'] = $arSystem['PREVIEW_TEXT'];
    $arResult['SYSTEMS'][$arSystem['ID']]['LINK'] = $arSystem['LINK_VALUE'];
}

$arOffers = \Bitrix\Iblock\Elements\ElementNodesOfferTable::getList([
    'select' => [
        'ID',
        'NAME',
        'IMAGE_' => 'IMAGE',
        'DESCRIPTION_' => 'DESCRIPTION',
        'PRICE_' => 'PRICE'
    ],
    'filter' => [
        '=ACTIVE' => 'Y'
    ],
])->fetchAll();

foreach ($arOffers as $arOffer) {
    $arResult['OFFERS'][$arOffer['ID']]['NAME'] = $arOffer['NAME'];
    $arResult['OFFERS'][$arOffer['ID']]['IMAGE'] = CFile::GetPath($arOffer['IMAGE_IBLOCK_GENERIC_VALUE']);
    $arResult['OFFERS'][$arOffer['ID']]['DESCRIPTION'] = $arOffer['DESCRIPTION_VALUE'];
    $arResult['OFFERS'][$arOffer['ID']]['PRICE'] = $arOffer['PRICE_VALUE'];
}

$obProjects = \Bitrix\Iblock\Elements\ElementNodesProjectsTable::getList([
    'select' => [
        'ID',
        'IMAGES',
    ],
    'filter' => [
        '=ACTIVE' => 'Y'
    ],
])->fetchCollection();

foreach ($obProjects as $obProject) {
    foreach ($obProject->getImages()->getAll() as $image) {
        $arResult['PROJECTS'][] = CFile::GetPath($image->getValue());
    }
}
?>

    <div class="intec-content">
        <div class="intec-content-wrapper">

            <?php
            $APPLICATION->IncludeComponent(
                'coderoom:banners.nodes',
                '',
                [
                    'HEADER' => 'ЕДИНСТВЕННЫЕ В РОССИИ ПОЛНОФУНКЦИОНАЛЬНЫЕ МОБИЛЬНЫЕ РАСТВОРНЫЕ УЗЛЫ'
                ]
            );
            ?>

            <?php
            $APPLICATION->IncludeComponent(
                'coderoom:products.nodes',
                '',
                [
                ]
            );
            ?>


            <div class="system">
                <h2 class="system__title">Смесительные системы Mixmate</h2>
                <div class="system__grid">
                    <div class="system__row three">
                        <?php $i = 0; ?>
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <?php if ($i <= 2) { ?>
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                                   style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                                    <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                                    <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                                </a>
                            <?php } ?>
                            <?php $i++; ?>
                        <?php } ?>
                    </div>
                    <div class="system__row two">
                        <?php $a = 0; ?>
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <?php if ($a <= 4 && $a > 2) { ?>
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                                   style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                                    <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                                    <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                                </a>
                            <?php } ?>
                            <?php $a++; ?>
                        <?php } ?>
                    </div>
                    <div class="system__row three">
                        <?php $b = 0; ?>
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <?php if ($b <= 7 && $b > 4) { ?>
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                                   style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                                    <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                                    <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                                </a>
                            <?php } ?>
                            <?php $b++; ?>
                        <?php } ?>
                    </div>

                    <div class="system__row mobile">
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <a href="<?php echo $arSystem['LINK']; ?>" class="system__item"
                               style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                                <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                                <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="form">
                <div class="form__wrap">
                    <form class="form__form">
                        <h3 class="form__title">Пригласите меня к себе на предприятие для оценки и более глубокого
                            понимания вашего запроса</h3>
                        <div class="form__inputs">
                            <input type="text" placeholder="Имя" name="name" required>
                            <input type="text" placeholder="Телефон" name="phone" required>
                        </div>
                        <button class="form__btn">Заказать звонок</button>
                        <p class="form__status green">Ваша заявка успешно отправлена.</p>
                    </form>
                    <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/nodes/form-image.png" alt="image">
                </div>
            </div>

            <div class="nodes">
                <h2 class="system__title nodes-title">Наши растворные узлы</h2>
                <div class="nodes__items">
                    <?php foreach ($arResult['OFFERS'] as $arOffer) { ?>
                        <div class="nodes__item">
                            <img src="<?php echo $arOffer['IMAGE']; ?>" alt="<?php echo $arOffer['NAME']; ?>">
                            <div class="nodes__info">
                                <h3><?php echo $arOffer['NAME']; ?></h3>
                                <p><?php echo $arOffer['DESCRIPTION']; ?></p>
                                <div class="nodes__price">
                                    <p><?php echo $arOffer['PRICE']; ?></p>
                                    <span>Ежемесячный платёж с учетом НДС</span>
                                </div>
                                <button class="nodes__btn">Купить оборудование в лизинг</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="benefit">
                <h2 class="system__title benefit__title">Комплексный подход</h2>
                <p class="benefit__descr">Полная включённость для достижения лучшего результата</p>
                <div class="benefit__items">
                    <div class="benefit__item">
                        <span class="benefit__count">01</span>
                        <p class="benefit__name">Проектирование</p>
                        <ul class="benefit__list">
                            <li>Индивидуальное проектирование Готовые проекты площадок СЗР</li>
                            <li>Безналичный расчет с НДС или без НДС</li>
                            <li>Автоматизация вашего растворного узла оборудованием Mixmate</li>
                        </ul>
                    </div>
                    <div class="benefit__item">
                        <span class="benefit__count">02</span>
                        <p class="benefit__name">Обучение</p>
                        <ul class="benefit__list">
                            <li>Оцифровка схем обработок СЗР</li>
                            <li>Обучение персонала и сопровождение производства</li>
                            <li>Настройка синхронизации данных с ГИС</li>
                        </ul>
                    </div>
                    <div class="benefit__item">
                        <span class="benefit__count">03</span>
                        <p class="benefit__name">Условия поставки</p>
                        <ul class="benefit__list">
                            <li>Предоплата 30-70 %</li>
                            <li>Срок поставки 90 дней</li>
                            <li>Гарантия 2 года</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="projects">
                <h2 class="system__title projects__title">Наши проекты</h2>
                <div class="projects__items">
                    <div class="projects__row two">
                        <?php $i = 0; ?>
                        <?php foreach ($arResult['PROJECTS'] as $image) { ?>
                            <?php if ($i <= 1) { ?>
                                <a data-fslightbox="desktop" href="<?php echo $image; ?>" class="projects__item">
                                    <img src="<?php echo $image; ?>" alt="image">
                                </a>
                            <?php } ?>
                            <?php $i++; ?>
                        <?php } ?>
                    </div>
                    <div class="projects__row three">
                        <?php $a = 0; ?>
                        <?php foreach ($arResult['PROJECTS'] as $image) { ?>
                            <?php if ($a <= 4 && $a > 1) { ?>
                                <a data-fslightbox="desktop" href="<?php echo $image; ?>" class="projects__item">
                                    <img src="<?php echo $image; ?>" alt="image">
                                </a>
                            <?php } ?>
                            <?php $a++; ?>
                        <?php } ?>
                    </div>
                    <div class="projects__row two">
                        <?php $b = 0; ?>
                        <?php foreach ($arResult['PROJECTS'] as $image) { ?>
                            <?php if ($b <= 6 && $b > 4) { ?>
                                <a data-fslightbox="desktop" href="<?php echo $image; ?>" class="projects__item">
                                    <img src="<?php echo $image; ?>" alt="image">
                                </a>
                            <?php } ?>
                            <?php $b++; ?>
                        <?php } ?>
                    </div>
                    <div class="projects__row mobile">
                        <?php foreach ($arResult['PROJECTS'] as $image) { ?>
                            <a data-fslightbox="mobile" href="<?php echo $image; ?>" class="projects__item">
                                <img src="<?php echo $image; ?>" alt="image">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup" data-modal>
        <div class="popup__dialog">
            <div class="popup__content">
                <button class="popup-close">&times;</button>
                <form class="form__form">
                    <h3 class="form__title">Заказать звонок</h3>
                    <div class="form__inputs">
                        <input type="text" placeholder="Имя" name="name" required>
                        <input type="text" placeholder="Телефон" name="phone" required>
                    </div>
                    <button class="form__btn">Отправить</button>
                    <p class="form__status green">Ваша заявка успешно отправлена.</p>
                </form>
            </div>
        </div>
    </div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>