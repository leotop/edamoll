<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if ($arResult["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"]<>"") {
$APPLICATION->SetTitle($arResult["NAME"]." в интернет-супермаркете edamoll, купить товары ".$arResult["NAME"]." (".$arResult["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"].") по доступной цене");

echo ("<h1>".$arResult["NAME"]." (".$arResult["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"].")"."</h1>");
}
else {
$APPLICATION->SetTitle($arResult["NAME"]." в интернет-супермаркете edamoll, купить товары ".$arResult["NAME"]. " по доступной цене");

 echo ("<h1>"."Купить товары ".$arResult["NAME"]."</h1>");
}
?>

<div class="catalog-element">
		<?if(is_array($arResult["PREVIEW_PICTURE"])):?>
				<?if(is_array($arResult["PREVIEW_PICTURE"])):?>
					<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				<?endif?>
		<?endif;?>
			<?/*
			<td width="100%" valign="top">
				<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
					<?=$arProperty["NAME"]?>:<b>&nbsp;<?
					if(is_array($arProperty["DISPLAY_VALUE"])):
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($pid=="MANUAL"):
						?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
					else:
						echo $arProperty["DISPLAY_VALUE"];?>
					<?endif?></b><br />
				<?endforeach?>
			</td>
*/?>
	<? if ($arResult["DISPLAY_PROPERTIES"]["URL2"]["VALUE"]<>"") {
	echo("<br /><a rel='nofollow' target='_blank' href='".$arResult["DISPLAY_PROPERTIES"]["URL2"]["VALUE"]."'>".$arResult["DISPLAY_PROPERTIES"]["URL2"]["VALUE"]."</a>");
}?>
	<?if($arResult["PREVIEW_TEXT"]):?>
		<br /><?=$arResult["PREVIEW_TEXT"]?><br />
	<?endif;?>

</div>
<br />

<?
$GLOBALS['g_brand_elem']["name"]=$arResult["NAME"];
$GLOBALS['g_brand_elem']["h"]="<h3>";


if ($arResult["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"]<>"") {

$GLOBALS['g_brand_elem']["h"].="Купить товары ".$arResult["NAME"]." (".$arResult["DISPLAY_PROPERTIES"]["NAME2"]["VALUE"].") в интернет-магазине едамолл";
}
else
{
$GLOBALS['g_brand_elem']["h"].="Купить товары ".$arResult["NAME"]." в интернет-магазине едамолл";
} 

$GLOBALS['g_brand_elem']["h"].="</h3>";
?>