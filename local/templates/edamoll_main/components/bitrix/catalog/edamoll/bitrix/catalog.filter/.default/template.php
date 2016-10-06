<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="filter_div">
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;
?>
	<? /*
	<table class="data-table" cellspacing="0" cellpadding="2" rules="rows">
<tbody>*/?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
	<?/*
				<tr>
					<td valign="top" class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?>
*/?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
<?=$arItem["INPUT"]?>
</div>
	<?/*
</td>

				</tr>
*/?>
			<?endif?>
		<?endforeach;?>
	<?/*
	</tbody>
	<tfoot>
		<tr>
<td >*/?>
<div  class="filter_name" style="padding-bottom: 20px;">
				<input  class="filter_btn"  type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" />
				<input type="hidden" name="set_filter" value="Y" /><br /><br />
<input class="filter_btn"  type="submit" name="del_filter" value="Очистить фильтр" />
	</div>
	<?/*</td>

		</tr>
	</tfoot>
	</table>
*/?>
</form>
</div>