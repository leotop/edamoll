<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

/*
$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:eshop.menu.sections", "", array(
	"IBLOCK_TYPE_ID" => "1c_catalog",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000"
	),
	false,
	Array('HIDE_ICONS' => 'Y')
);
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
	//print_r($aMenuLinksExt);


*/
$aMenuLinksExt=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", Array( 
   "ID"   =>   $_REQUEST["SECTION_ID"], 
   "IBLOCK_TYPE"   =>   "1c_catalog", 
   "IBLOCK_ID"   =>   "11", 
	"SECTION_URL"   =>   "/#SECTION_CODE#/", 
   "DEPTH_LEVEL"   =>   "3", 
   "CACHE_TYPE"   =>   "A", 
   "CACHE_TIME"   =>   "3600" 
   ) 
); 

$aMenuLinks = array_merge($aMenuLinksExt,$aMenuLinks);
?>

