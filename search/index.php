<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("�����");
?> <?
$gname= isset($_GET["q"])?urldecode($_GET["q"]):"";

/*$gname2=str_replace (" ","%",$gname);
$gname= preg_replace('%[^A-Za-z�-��-�0-9\%]%', '', $gname2); */
//$arrFilter=array(
//    "NAME" => $gname);

$words=array();
foreach(explode(" ",$gname) as $value)
  {
    $words[]=array("NAME" => "%".$value."%",);

  }
$arrFilter=array(
	">CATALOG_QUANTITY"=>0,
    array(
        "LOGIC" => "OR",
	     	"ID" => $gname,
        "NAME" => "%".$gname."%",
         array(
           "LOGIC" => "AND",
           $words
         )


    ));


if(isset($_GET["q"]))
  {
    $gname= isset($_GET["q"])?urldecode($_GET["q"]):"";

    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
    $arFilter= $arrFilter;

    $res = CIBlockElement::GetList(Array(), $arFilter, false,  $arSelect);
    $count=$res->SelectedRowsCount();
    $arFields=array("NAME"=>strtolower($gname),"SORT"=>$count,"IBLOCK_ID"=>17,);
    $arSelect = Array("ID");
    $arFilter =array(
      "IBLOCK_ID"=>17,"=NAME"=>$gname
    );
    $el = new CIBlockElement;
    $res = CIBlockElement::GetList(Array(), $arFilter, false,  $arSelect);
    if($ob = $res->GetNextElement())
      {
        $arElement = $ob->GetFields();
        $el->Update($arElement["ID"],$arFields);

      }
    else
      {
        $el->Add($arFields);
      }
  }
global $SorPagePararms,$SorPagePararmsOrder;

?><?
$gElCount= isset($_GET["el_count"]) ? intval($_GET["el_count"]) : "40";

$APPLICATION->IncludeComponent("bitrix:catalog.section", "template1", array(
	"IBLOCK_TYPE" => "1c_catalog",
	"IBLOCK_ID" => "11",
	"SECTION_ID" => "",
	"SECTION_CODE" => "",
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
	"PAGE_ELEMENT_COUNT" => ($_GET["ALL"]==1) ? intval("60") : $gElCount,
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
		0 => "���������",
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
	"PAGER_TITLE" => "������",
	"PAGER_SHOW_ALWAYS" => "Y",
	"PAGER_TEMPLATE" => ($_GET["ALL"]==1) ? "inviz_search" :  "edamoll",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?> <?
if ($GLOBALS['g_nosearch']=="Y"){
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
		"PRICE_CODE" => array(0=>"���������",),
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
}?> 
<br />
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>