<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use Bitrix\Main\Localization\Loc;
use intec\Core;
use intec\core\helpers\FileHelper;
use intec\constructor\Module as Constructor;
use intec\constructor\models\build\Template;

Loc::loadMessages(__FILE__);

require(__DIR__.'/parts/preload.php');

$request = Core::$app->request;
$page->execute(['state' => 'loading']);

/** @var Template $template */
$template = $build->getTemplate();

if (empty($template))
    return;

foreach ($template->getPropertiesValues() as $key => $value)
    $properties->set($key, $value);

unset($value);
unset($key);

if (!Constructor::isLite())
    $template->populateRelation('build', $build);

if (FileHelper::isFile($directory.'/parts/custom/initialize.php'))
    include($directory.'/parts/custom/initialize.php');

require($directory.'/parts/metrika.php');
require($directory.'/parts/assets.php');

if (FileHelper::isFile($directory.'/parts/custom/start.php'))
    include($directory.'/parts/custom/start.php');

$APPLICATION->AddBufferContent([
    'intec\\template\\Marking',
    'openGraph'
]);

$page->execute(['state' => 'loaded']);
$part = Constructor::isLite() ? 'lite' : 'base';

?><!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>"  prefix="og: //ogp.me/ns#">
    <head>
        <?php if (FileHelper::isFile($directory.'/parts/custom/header.start.php')) include($directory.'/parts/custom/header.start.php') ?>
        <title><?php $APPLICATION->ShowTitle() ?></title>
        <?php $APPLICATION->ShowHead() ?>
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <meta name="cmsmagazine" content="79468b886bf88b23144291bf1d99aa1c" />

		<link rel="canonical" href="https://<?php  echo $_SERVER['HTTP_HOST'];?><? echo $APPLICATION->GetCurDir(); ?>" />

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="/favicon.png">

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(85027396, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/85027396" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6GKE919JZM"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6GKE919JZM');
</script>

        <?php if (!Constructor::isLite()) { ?>
            <style type="text/css"><?= $template->getCss() ?></style>
            <style type="text/css"><?= $template->getLess() ?></style>
            <script type="text/javascript"><?= $template->getJs() ?></script>
        <?php } ?>
		<?php $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css", true); ?>
        <?php if (FileHelper::isFile($directory.'/parts/custom/header.end.php')) include($directory.'/parts/custom/header.end.php') ?>

		<meta property="og:title" content="<?=$APPLICATION->ShowTitle(false);?>"/>
		<meta property="og:description" content="<?$APPLICATION->ShowProperty('description');?>"/>
		<meta property="og:image" content="https://npk-pro.ru/include/logotype.png">
		<meta property="og:type" content="website"/>
		<meta property="og:url" content= "https://<?php  echo $_SERVER['HTTP_HOST'];?><? echo $APPLICATION->GetCurDir(); ?>" />
		<meta property="og:site_name" content="NPK PRO - смесительные системы для агрохимии"/>

    </head>
    <body class="public intec-adaptive">
        <?php if (FileHelper::isFile($directory.'/parts/custom/body.start.php')) include($directory.'/parts/custom/body.start.php') ?>
        <?php $APPLICATION->IncludeComponent(
            'intec.universe:system',
            'basket.manager',
            array(
                'BASKET' => 'Y',
                'COMPARE' => 'Y',
                'COMPARE_NAME' => 'compare',
                'CACHE_TYPE' => 'N'
            ),
            false,
            array('HIDE_ICONS' => 'Y')
        ); ?>
        <?php if (
            $properties->get('base-settings-show') == 'all' ||
            $properties->get('base-settings-show') == 'admin' && $USER->IsAdmin()
        ) { ?>
            <?php $APPLICATION->IncludeComponent(
                'intec.universe:system.settings',
                '.default',
                array(
                    'MODE' => 'render',
                    'MENU_ROOT_TYPE' => 'top',
                    'MENU_CHILD_TYPE' => 'left'
                ),
                false,
                array(
                    'HIDE_ICONS' => 'N'
                )
            ); ?>
        <? } ?>
        <?php include($directory.'/parts/'.$part.'/header.php'); ?>