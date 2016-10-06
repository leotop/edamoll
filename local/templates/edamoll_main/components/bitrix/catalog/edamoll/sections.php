<?
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

//LocalRedirect("/404.php");



	 /*
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
*/
?>
<?/*
<div class="e404"></div>
<div class="e404_2">
	<div><h1 class="e404h1">ошибка</h1></div>
	<div class="pinktext">страница не найдена</div>
<a href="/"><button class="whitetext" style="background: none repeat scroll 0% 0% rgb(255, 0, 57); height: 38px; width: 280px; border: medium none;">
      перейти на главную страницу
    </button></a>
</div>

<?


$APPLICATION->IncludeComponent(
	"bitrix:eshop.catalog.top",
	"edamoll_top_search",
	Array(
		"IBLOCK_TYPE_ID" => "1c_catalog",
		"IBLOCK_ID" => "11",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_COUNT" => "12",
		"FLAG_PROPERTY_CODE" => "SALELEADERS",
		"OFFERS_LIMIT" => "6",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id_top",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_COMPARE" => "N",
		"PRICE_CODE" => array(0=>"Розничная",),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => array(),
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_IMG_WIDTH" => "148",
		"DISPLAY_IMG_HEIGHT" => "148",
		"USE_PRODUCT_QUANTITY" => "Y",
		"SHARPEN" => "80"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);

*/?>
