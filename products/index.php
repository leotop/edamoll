<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Продукция");
?><?$APPLICATION->IncludeComponent("bitrix:catalog", "edamoll", array(
	"IBLOCK_TYPE" => "products",
	"IBLOCK_ID" => "2",
	"BASKET_URL" => "",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/products/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_FILTER" => "N",
	"CACHE_GROUPS" => "Y",
	"SET_TITLE" => "Y",
	"SET_STATUS_404" => "Y",
	"USE_ELEMENT_COUNTER" => "Y",
	"USE_FILTER" => "Y",
	"FILTER_NAME" => "",
	"FILTER_FIELD_CODE" => array(
		0 => "",
		1 => "",
	),
	"FILTER_PROPERTY_CODE" => array(
		0 => "SALELEADERS",
		1 => "BRAND",
		2 => "s2",
		3 => "s1",
		4 => "COUNTRY",
		5 => "",
	),
	"FILTER_PRICE_CODE" => array(
		0 => "BASE",
	),
	"USE_REVIEW" => "Y",
	"MESSAGES_PER_PAGE" => "10",
	"USE_CAPTCHA" => "N",
	"REVIEW_AJAX_POST" => "Y",
	"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
	"FORUM_ID" => "",
	"URL_TEMPLATES_READ" => "",
	"SHOW_LINK_TO_FORUM" => "N",
	"POST_FIRST_MESSAGE" => "N",
	"USE_COMPARE" => "N",
	"PRICE_CODE" => array(
		0 => "BASE",
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "N",
	"PRICE_VAT_SHOW_VALUE" => "N",
	"PRODUCT_PROPERTIES" => array(
	),
	"USE_PRODUCT_QUANTITY" => "N",
	"CONVERT_CURRENCY" => "N",
	"SHOW_TOP_ELEMENTS" => "N",
	"SECTION_COUNT_ELEMENTS" => "N",
	"SECTION_TOP_DEPTH" => "2",
	"PAGE_ELEMENT_COUNT" => "40",
	"LINE_ELEMENT_COUNT" => "5",
	"ELEMENT_SORT_FIELD" => "sort",
	"ELEMENT_SORT_ORDER" => "asc",
	"LIST_PROPERTY_CODE" => array(
		0 => "SALELEADERS",
		1 => "PRICE",
		2 => "",
	),
	"INCLUDE_SUBSECTIONS" => "Y",
	"LIST_META_KEYWORDS" => "-",
	"LIST_META_DESCRIPTION" => "-",
	"LIST_BROWSER_TITLE" => "-",
	"DETAIL_PROPERTY_CODE" => array(
		0 => "SALELEADERS",
		1 => "BRAND",
		2 => "s2",
		3 => "s1",
		4 => "COUNTRY",
		5 => "",
	),
	"DETAIL_META_KEYWORDS" => "-",
	"DETAIL_META_DESCRIPTION" => "-",
	"DETAIL_BROWSER_TITLE" => "-",
	"LINK_IBLOCK_TYPE" => "",
	"LINK_IBLOCK_ID" => "",
	"LINK_PROPERTY_SID" => "",
	"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
	"USE_ALSO_BUY" => "Y",
	"ALSO_BUY_ELEMENT_COUNT" => "12",
	"ALSO_BUY_MIN_BUYES" => "2",
	"USE_STORE" => "N",
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Продукция",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "arrows",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
	"PAGER_SHOW_ALL" => "Y",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"sections" => "",
		"section" => "#SECTION_CODE#/",
		"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
		"compare" => "",
	)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>