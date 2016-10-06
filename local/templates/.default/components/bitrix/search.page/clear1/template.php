<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="search-page">

<?if(isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
	?>
	<div class="search-language-guess">
		<?echo GetMessage("CT_BSP_KEYBOARD_WARNING", array("#query#"=>'<a href="'.$arResult["ORIGINAL_QUERY_URL"].'">'.$arResult["REQUEST"]["ORIGINAL_QUERY"].'</a>'))?>
	</div><br /><?
endif;?>

	<div class="search-result">
	<?if($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false):?>
	<?elseif($arResult["ERROR_CODE"]!=0):?>
		<p><?=GetMessage("CT_BSP_ERROR")?></p>
		<?ShowError($arResult["ERROR_TEXT"]);?>
		<p><?=GetMessage("CT_BSP_CORRECT_AND_CONTINUE")?></p>
		<br /><br />
		<p><?=GetMessage("CT_BSP_SINTAX")?><br /><b><?=GetMessage("CT_BSP_LOGIC")?></b></p>
		<table border="0" cellpadding="5">
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_OPERATOR")?></td><td valign="top"><?=GetMessage("CT_BSP_SYNONIM")?></td>
				<td><?=GetMessage("CT_BSP_DESCRIPTION")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_AND")?></td><td valign="top">and, &amp;, +</td>
				<td><?=GetMessage("CT_BSP_AND_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_OR")?></td><td valign="top">or, |</td>
				<td><?=GetMessage("CT_BSP_OR_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top"><?=GetMessage("CT_BSP_NOT")?></td><td valign="top">not, ~</td>
				<td><?=GetMessage("CT_BSP_NOT_ALT")?></td>
			</tr>
			<tr>
				<td align="center" valign="top">( )</td>
				<td valign="top">&nbsp;</td>
				<td><?=GetMessage("CT_BSP_BRACKETS_ALT")?></td>
			</tr>
		</table>
	<?elseif(count($arResult["SEARCH"])>0):?>

<?$GLOBALS['g_nosearch']="N";?>
<div>
		<?if($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		</div>
		<div class="clear"></div>
<? $ar_id = array (); ?>
		<?foreach($arResult["SEARCH"] as $arItem):?>

				<?/*
				<h4><a href="<?echo $arItem["URL"]?>"><?echo $arItem["TITLE_FORMATED"]?></a></h4>
				<div class="search-preview"><?echo $arItem["BODY_FORMATED"]?></div>
*/?>

<? $ar_id[] = $arItem["ID"]; ?>


		<?endforeach;?>
<div class="cont_cont">
<?
	//$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");

$arFilter = Array( "ID"=>$ar_id);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false,  Array());
while($ob = $res->GetNextElement())
{
  $arItem = $ob->GetFields();

$big_picture = CFile::GetPath($arItem["PREVIEW_PICTURE"]);

?>

<div class="catalog_item_container">
<div class="catalog_item" itemscope itemtype = "http://schema.org/Product">
			<?if ($arItem["PREVIEW_PICTURE"]):?>
		<div class="catalog_foto" align="center">
			<div class="img_helper"></div>

<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="item_img" itemprop="image" src="<?=$big_picture?>" alt="<?=htmlspecialchars($arItem["NAME"])?>" /></a></div>
			<?else:?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><div class="catalog_no_foto"></div></a>
			<?endif?>


				<div class="catalog_item_price" align="center">
	<? if($arItem["PRICE"]>0) { ?>
<? $g_dpv=round(100*($arItem["PRICE"]-floor($arItem["PRICE"])));
	  if (strlen($g_dpv)<2) {$g_dpv=$g_dpv."0";}?>
				<span class="item_price price"><?=floor($arItem["PRICE"])?><span class="decimal"><?=$g_dpv?></span></span>
	<?}?>
				</div>

		<div class="catalog_item_name" align="center">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item_title" title="<?=htmlspecialchars($arItem["NAME"])?>">
				<span itemprop = "name"><?=$arItem["NAME"]?></span>
			</a>
		</div>

		</div>

	</div>

<?
}
?>
	</div>
		<div class="clear"></div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"]?>
		<?if($arParams["SHOW_ORDER_BY"] != "N"):?>
			<div class="search-sorting"><label><?echo GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
			<?if($arResult["REQUEST"]["HOW"]=="d"):?>
				<a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
			<?else:?>
				<b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
			<?endif;?>
			</div>

		<?endif;?>
	<?else:?>
<div class="largetext">
	По вашему запросу <span class="pinktext">"<?print_r($arResult["REQUEST"]["QUERY"])?>"</span> ничего не найдено. попробуйте еще раз!
		</div>
<div class="nosearch"> Убедитесь, что все слова написаны без ошибок. 
  <br />
 Попробуйте использовать другие ключевые слова. 
  <br />
 Попробуйте использовать более популярные ключевые слова. 
  <br />
 Попробуйте уменьшить количество слов в запросе.</div>
 <img src="/include/img/packet.png" border="0" alt="Поиск не удался" width="164" height="248"  />
<?$GLOBALS['g_nosearch']="Y"; ?>

	<?endif;?>

	</div>
</div>
