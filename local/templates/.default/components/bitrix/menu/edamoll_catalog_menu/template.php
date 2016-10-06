<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<div class="edamoll_menu_left">
<ul>
<?
$previousLevel = 0;
foreach($arResult as $arItem):
?>
	<? if ($arItem["DEPTH_LEVEL"]<4) {?>
	<?if ($arItem["DEPTH_LEVEL"]==1 && $arItem["DEPTH_LEVEL"] <= $previousLevel):?>
		<br />
	<?endif?>



	<?if ($arItem["IS_PARENT"]):?>
			<li>
<div class="item-text <?if ($arItem["DEPTH_LEVEL"]==1) echo('blacktext');?>">
	<a href="<?=$arItem["LINK"]?>" class="<? if($arItem["CODE"]==$arParams["G_SECTION_CODE"]) {echo("active");}?>"><?if ($arItem["DEPTH_LEVEL"]==3) echo(' - ');?><?=$arItem["TEXT"]?></a></div>
	</li>



	<?else:?>
	<? print_r($arItem);?> <br /> <? print_r($arParams);?>

		<?if ($arItem["PERMISSION"] > "D"):?>
				<li>
					<div class="page"></div>
					<div class="item-text <?if ($arItem["DEPTH_LEVEL"]==1) echo('blacktext');?>">
<a href="<?=$arItem["LINK"]?>"  class="<? if($arItem["CODE"]==$arParams["G_SECTION_CODE"]) {echo("active");}?>"><?if ($arItem["DEPTH_LEVEL"]==3) echo(' - ');?><?=$arItem["TEXT"]?></a></div>
				</li>
		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
					<? } ?>
<?endforeach?>

	<?/*if ($previousLevel > 1)://close last item tags?>
					<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif*/?>

</ul>
</div>
<?endif?>