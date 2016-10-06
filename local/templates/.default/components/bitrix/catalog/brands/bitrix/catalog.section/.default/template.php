<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
	<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<? $arrRes=array();?>
		<?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
<? 
if (substr($arElement["NAME"],0,1)<="9" && substr($arElement["NAME"],0,1)>="0" )
{
$arrRes["0-9"][$arElement["NAME"]]=$arElement["DETAIL_PAGE_URL"];
 }
else
{
$arrRes[substr($arElement["NAME"],0,1)][$arElement["NAME"]]=$arElement["DETAIL_PAGE_URL"];
	/*
	if ($arElement["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"]<>""){
$arrRes[substr($arElement["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"],0,1)][$arElement["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"]]=$arElement["DETAIL_PAGE_URL"];
}*/
}

?>
	<?/*

<td valign="top" width="<?=round(100/$arParams["LINE_ELEMENT_COUNT"])?>%">
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a><br />
		</td>


		<?if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
		<tr>
		<?endif;?>

		<td valign="top" width="<?=round(100/$arParams["LINE_ELEMENT_COUNT"])?>%" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
		<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a><br />
		</td>

		<?$cell++;
		if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
			</tr>
		<?endif?>
*/?>
		<?endforeach; // foreach($arResult["ITEMS"] as $arElement):?>
<?
	foreach($arrRes as $cell=>$arElement) {
?>
<tr><td colspan="<?=$arParams["LINE_ELEMENT_COUNT"]?>" class="pinktext" style="text-align:left;border-top:1px solid rgb(96,96,96)"><?=$cell?></td></tr>
<? $cell=0;?>
<?foreach($arElement as $cell2=>$arElement2) {
if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
		<tr>
		<?endif;?>

		<td valign="top" width="<?=round(100/$arParams["LINE_ELEMENT_COUNT"])?>%">
		<a href="<?=$arElement2?>"><?=$cell2?></a><br />
		</td>

		<?$cell++;
		if($cell%$arParams["LINE_ELEMENT_COUNT"] == 0):?>
			</tr>
		<?endif?>
<?
	}
?>
<?
													 }


?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
