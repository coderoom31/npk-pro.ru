<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");

use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Loader;
use intec\core\helpers\Html;

Loader::includeModule('iblock');

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/swiper.min.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/nodes.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/swiper.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/fslightbox.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/nodes.js");

$arResult = [];

$arBanners = \Bitrix\Iblock\Elements\ElementBannerNodesTable::getList([
    'select' => [
            'ID',
            'SLIDER_IMAGE_' => 'SLIDER_IMAGE'
    ],
    'filter' => [
            '=ACTIVE' => 'Y'
    ],
])->fetchAll();

foreach ($arBanners as $arBanner) {
    $arResult['BANNERS'][] = CFile::GetPath($arBanner['SLIDER_IMAGE_IBLOCK_GENERIC_VALUE']);
}

$obProducts = \Bitrix\Iblock\Elements\ElementNodesProductsTable::getList([
    'select' => [
        'ID',
        'NAME',
        'PRODUCT_IMAGE',
        'PRODUCTS_ICONS',
        'PRODUCTS_TABS',
        'PRODUCTS_CONTENTS',
        'PDF',
        'WORD'
    ],
    'filter' => [
        '=ACTIVE' => 'Y'
    ],
])->fetchCollection();

foreach ($obProducts as $obProduct) {
    $id = $obProduct->getId();

    $arResult['PRODUCTS'][$id]['NAME'] = $obProduct->getName();
    $arResult['PRODUCTS'][$id]['IMAGE'] = CFile::GetPath($obProduct->getProductImage()->getValue());
    $arResult['PRODUCTS'][$id]['ICONS'] = unserialize($obProduct->getProductsIcons()->getValue());

    if ($obProduct->getPdf()) {
        $arResult['PRODUCTS'][$id]['PDF'] = CFile::GetPath($obProduct->getPdf()->getValue());
    }

    $i = 0;

    foreach ($obProduct->getProductsTabs()->getAll() as $arTab) {
        $arResult['PRODUCTS'][$id]['TABS'][$i++]['NAME'] = $arTab->getValue();
    }

    $i = 0;

    foreach ($obProduct->getProductsContents()->getAll() as $arContent) {
        $arResult['PRODUCTS'][$id]['TABS'][$i++]['CONTENT'] = unserialize($arContent->getValue());
    }
}

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
            <div class="banner">
                <div class="banner__slider swiper">
                    <div class="swiper-wrapper">
                        <?php if ($arResult['BANNERS']) { ?>
                            <?php foreach ($arResult['BANNERS'] as $arBanner) { ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/nodes/banner.png" alt="slide">
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="swiper-pagination banner__pagination"></div>
                </div>
                <div class="banner__content">
                    <h1 class="banner__title">
                        ЕДИНСТВЕННЫЕ В РОССИИ ПОЛНОФУНКЦИОНАЛЬНЫЕ МОБИЛЬНЫЕ РАСТВОРНЫЕ УЗЛЫ
                    </h1>
                    <ul class="banner__list">
                        <li class="banner__item">Перевозка препаратов в растворном узле</li>
                        <li class="banner__item">Заправляется препаратами на базе</li>
                        <li class="banner__item">Растворный узел и 10 т воды на одном прицепе КАМАЗа</li>
                        <li class="banner__item">Встроенная мешалка для порошковых СЗР</li>
                    </ul>
                    <div class="banner__btns">
                        <a class="banner__download" href="/" download>Скачать опросный лист</a>
                        <a class="banner__play" href="/">Смотреть презентацию <img src="<?php echo SITE_TEMPLATE_PATH ?>/images/nodes/play-icon.svg" alt="icon"></a>
                    </div>
                </div>
            </div>

            <div class="products">

                <?php foreach ($arResult['PRODUCTS'] as $arProduct) { ?>
                    <div class="products__item">
                        <h2 class="products__title mobile"><?php echo $arProduct['NAME']; ?></h2>
                        <div class="products__wrap">
                            <div class="products__img">

                                <?php echo $arProduct['ICONS']['TEXT']; ?>

                                <img class="image" src="<?php echo $arProduct['IMAGE']; ?>" alt="<?php echo $arProduct['NAME']; ?>">
                            </div>
                            <div class="products__block">
                                <h2 class="products__title desktop"><?php echo $arProduct['NAME']; ?></h2>
                                <div class="products__tabs">
                                   <?php foreach ($arProduct['TABS'] as $arTab) { ?>
                                       <div class="products__tab">
                                           <div class="products__header">
                                               <span class="products__name"><?php echo $arTab['NAME']; ?></span>
                                               <div class="products__icon">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M8.58579 9.99986L0.807613 17.778L2.22183 19.1922L10 11.4141L17.7782 19.1922L19.1924 17.778L11.4142 9.99986L19.1924 2.22168L17.7782 0.807471L10 8.58565L2.22183 0.80747L0.807613 2.22168L8.58579 9.99986Z" fill="white"/>
                                                   </svg>
                                               </div>
                                           </div>
                                           <div class="products__content"><?php echo $arTab['CONTENT']['TEXT']; ?></div>
                                       </div>
                                    <?php } ?>
                                </div>
                                <?php if($arProduct['PDF']) { ?>
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

            <div class="system">
                <h2 class="system__title">Смесительные системы Mixmate</h2>
                <div class="system__grid">
                    <div class="system__row three">
                        <?php $i = 0; ?>
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <?php if ($i <= 2) { ?>
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item" style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
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
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item" style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
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
                                <a href="<?php echo $arSystem['LINK']; ?>" class="system__item" style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
                                    <button class="system__btn"><?php echo $arSystem['NAME']; ?></button>
                                    <p class="system__descr"><?php echo $arSystem['TEXT']; ?></p>
                                </a>
                            <?php } ?>
                            <?php $b++; ?>
                        <?php } ?>
                    </div>

                    <div class="system__row mobile">
                        <?php foreach ($arResult['SYSTEMS'] as $arSystem) { ?>
                            <a href="<?php echo $arSystem['LINK']; ?>" class="system__item" style="background-image: url('<?php echo $arSystem['IMAGE']; ?>')">
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
                        <h3 class="form__title">Пригласите меня к себе на предприятие для оценки и более глубокого понимания вашего запроса</h3>
                        <div class="form__inputs">
                            <input type="text" placeholder="Имя" name="name" required>
                            <input type="text" placeholder="Телефон" name="phone" required>
                        </div>
                        <button class="form__btn" >Заказать звонок</button>
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
                            <li>Оцифровка схем обработок  СЗР</li>
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