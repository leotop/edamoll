<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
  $APPLICATION->IncludeFile(
	SITE_DIR."include/discount.php",
	Array(),
	Array("MODE"=>"html")
  );
  ?>

<?if (!empty($arResult)):?>
<div class="edamoll_menu_left">
<ul>
<?
$previousLevel = 0;
foreach($arResult as $arItem):
?>
	<? if ($arItem["DEPTH_LEVEL"]<3) {?>
	<?if ($arItem["DEPTH_LEVEL"]==1 && $arItem["DEPTH_LEVEL"] <= $previousLevel):?>
		<br />
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>
			<li>
<div class="item-text <?if ($arItem["DEPTH_LEVEL"]==1) echo('blacktext');?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
	</li>



	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>
				<li>
					<div class="page"></div>
					<div class="item-text <?if ($arItem["DEPTH_LEVEL"]==1) echo('blacktext');?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
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