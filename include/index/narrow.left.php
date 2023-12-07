<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\helpers\Html;
use intec\core\collections\Arrays;
use intec\core\io\Path;

/**
 * @var Arrays $blocks
 * @var string $page
 * @var Closure $render($block, $data = [])
 * @var Path $path
 * @global CMain $APPLICATION
 */

$render($blocks->get('icons'));
$render($blocks->get('banner'));
$render($blocks->get('services'));
$render($blocks->get('sections'));
$render($blocks->get('categories'));
$render($blocks->get('products'));
$render($blocks->get('stages'));
$render($blocks->get('video'));
$render($blocks->get('projects'));
$render($blocks->get('rates'));
$render($blocks->get('certificates'));
$render($blocks->get('faq'));
$render($blocks->get('videos'));
$render($blocks->get('shares'));
$render($blocks->get('advantages'));
$render($blocks->get('staff'));
$render($blocks->get('articles'));
$render($blocks->get('reviews'));
$render($blocks->get('gallery'));
$render($blocks->get('about'));
$render($blocks->get('brands'));

?>
