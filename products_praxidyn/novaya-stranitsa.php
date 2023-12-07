<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "Мобильный растворный узел СЗР, стационарный растворный узел СЗР");
$APPLICATION->SetPageProperty("title", "Вопрос/ответ Praxidyn");
$APPLICATION->SetPageProperty("keywords", "Оборудование для производства растворов средств защиты растений");
$APPLICATION->SetPageProperty("description", "Сервис");
$APPLICATION->SetTitle("Новая страница");
?><?$APPLICATION->IncludeComponent(
	"bitrix:support.faq.element.list",
	"",
Array()
);?><?$APPLICATION->IncludeComponent(
	"bitrix:support.faq.section.list",
	"",
Array(),
false
);?><?$APPLICATION->IncludeComponent(
	"bitrix:support.faq.element.detail",
	"",
Array()
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>