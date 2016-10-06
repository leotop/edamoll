<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новая страница");
?><?
if (CModule::IncludeModule("iblock")):
$gel=CIBlockElement::GetList(
 Array("PROPERTY_MARKA_VALUE"=>"ASC"),
 Array("IBLOCK_ID"=>"11","SECTION_CODE"=>"khumus","INCLUDE_SUBSECTIONS"=>"Y",">CATALOG_QUANTITY"=>0),
 false,
 false,
 Array("ID","PROPERTY_KKAL","PROPERTY_MARKA")
);
while($ob = $gel->GetNextElement()){ 
 $arFieldz = $ob->GetFields();  
 $arFieldsMARKA[$arFieldz["PROPERTY_MARKA_ENUM_ID"]]=$arFieldz;
 $arFieldsSTRANA[$arFieldz["PROPERTY_STRANA_ENUM_ID"]]=$arFieldz;
		if (trim($arFieldz["PROPERTY_KKAL_VALUE"])!== "" && $arFieldz["PROPERTY_KKAL_VALUE"]!== "&lt;&gt;"){
$arFieldsKKAL[$arFieldz["PROPERTY_KKAL_ENUM_ID"]]=$arFieldz;
 $arFieldsKKAL2[]=(double)str_replace ( ",", ".", $arFieldz["PROPERTY_KKAL_VALUE"]);};
}

$s="";
?>
	<?foreach($arFieldsMARKA as $val2 => $ar2):?>
	<? if(trim($ar2["PROPERTY_MARKA_VALUE"])!== "" && $ar2["PROPERTY_MARKA_VALUE"]!== "&lt;&gt;") {

	$s.="{".$val2."|".$ar2["PROPERTY_MARKA_VALUE"]."}";

	}?>
	<?endforeach;?>
<?
echo($s);
endif;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>