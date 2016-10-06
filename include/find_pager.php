<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
?>
<?
$gname= isset($_GET["q"])?urldecode($_GET["q"]):"";

$gname2=str_replace (" ","%",$gname);
$gname= preg_replace('%[^A-Za-zА-Яа-я0-9\%]%', '', $gname2); 
//$arrFilter=array(
//    "NAME" => $gname);
$arrFilter=array(
	">CATALOG_QUANTITY"=>0,
    array(
        "LOGIC" => "OR",
		"ID" => $gname,
        "NAME" => "%".$gname."%",


    ));
if( $_GET["SECT"]=="discount")
{
    $arrFilter=array(
        ">CATALOG_QUANTITY"=>0,
       ">PROPERTY_DISCOUNTS"=>0
    );
    $_GET["SECT"]="";
    global $pageDiscount;
    $pageDiscount='discount';
}
global $SorPagePararms,$SorPagePararmsOrder;

?>

<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "template1", array(
	"IBLOCK_TYPE" => "1c_catalog",
	"IBLOCK_ID" => "11",
	"SECTION_CODE" => $_GET["SECT"],
	"SECTION_USER_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"ELEMENT_SORT_FIELD" => $SorPagePararms,
	"ELEMENT_SORT_ORDER" => $SorPagePararmsOrder,
	"ELEMENT_SORT_FIELD2" => "id",
	"ELEMENT_SORT_ORDER2" => "desc",
	"FILTER_NAME" => "arrFilter",
	"INCLUDE_SUBSECTIONS" => "Y",
	"SHOW_ALL_WO_SECTION" => "Y",
	"HIDE_NOT_AVAILABLE" => "N",
	"PAGE_ELEMENT_COUNT" => "60",
	"LINE_ELEMENT_COUNT" => "5",
	"PROPERTY_CODE" => array(
		0 => "CML2_BASE_UNIT",
		1 => "",
	),
	"OFFERS_LIMIT" => "5",
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/basket.php",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"ADD_SECTIONS_CHAIN" => "N",
	"DISPLAY_COMPARE" => "N",
	"SET_TITLE" => "Y",
	"SET_STATUS_404" => "N",
	"CACHE_FILTER" => "N",
	"PRICE_CODE" => array(
		0 => "Розничная",
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"PRODUCT_PROPERTIES" => array(
	),
	"USE_PRODUCT_QUANTITY" => "Y",
	"CONVERT_CURRENCY" => "N",
	"QUANTITY_FLOAT" => "Y",
	"DISPLAY_TOP_PAGER" => "Y",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => "inviz_search",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>