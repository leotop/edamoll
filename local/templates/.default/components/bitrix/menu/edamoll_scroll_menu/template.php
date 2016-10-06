<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?CModule::IncludeModule("iblock");?>

	<div id="scroll-menu-logo">
		<a href="<?=SITE_DIR?>" title="<?=GetMessage('CFT_MAIN')?>" ><img src="/include/img/logo_small.png" alt="edamoll" width="111" height="32"  /></a></div>
<ul id="scroll-menu-1">

<?
$previousLevel = 0;
$second_counter=0;
$previousLevel = 0;
$count = 0;
$gcount1=0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
	<?if ($arItem["DEPTH_LEVEL"] == 1) {$gcount1++;} ?>
	<? if ($gcount1<7) {?>
	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
<?
$g_sec_id= substr($arItem["LINK"],1,strlen($arItem["LINK"])-2);
$ar_res=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("CODE"=>$g_sec_id),false, Array("ID"));
if($rez=$ar_res->GetNext()){$g_sec_id=$rez["ID"];}

$root_counter++;$second_counter=0; $count=CIBlockSection::GetCount(Array("DEPTH_LEVEL"=>2,"SECTION_ID"=>$g_sec_id))?> 

			<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?> whitetext"><?=$arItem["TEXT"]?></a>
				<ul>
		<?else:?>
<?if ($arItem["DEPTH_LEVEL"] == 2){$second_counter++;}?>
<li class="<?if ($arItem["SELECTED"]):?> item-selected<?endif?> <? if(($arItem["DEPTH_LEVEL"] == 2)&&(--$count)&&($second_counter % 6 ==0)) echo("li_right");?>"><a href="<?=$arItem["LINK"]?>" class="parent"><?=$arItem["TEXT"]?>
					<? 
	$g_sec_id= substr($arItem["LINK"],1,strlen($arItem["LINK"])-2); 
if ($g_sec_id!=""){
$ar_result=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID"=>"11", "CODE"=>$g_sec_id),false, Array("DETAIL_PICTURE"));
if($res=$ar_result->GetNext()){
$big_picture = CFile::GetPath($res["DETAIL_PICTURE"]);
	if ($big_picture!=""){
?>
<div class="top_menu_img_cont">
<img src="<?=$big_picture?>"/></div>
						<?}}
}
?>
</a>
				<ul>
		<?endif?>

	<?else:?>


			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?> whitetext"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
<?if ($arItem["DEPTH_LEVEL"] == 2){$second_counter++;}?>
<li class="<?if ($arItem["SELECTED"]):?> item-selected<?endif?> <? if(($arItem["DEPTH_LEVEL"] == 2)&&(--$count)&&($second_counter % 6 ==0)) echo("li_right");?>">
<a href="<?=$arItem["LINK"]?>">
<?=$arItem["TEXT"]?>
					<? 
	$g_sec_id= substr($arItem["LINK"],1,strlen($arItem["LINK"])-2); 
if ($g_sec_id!=""){
$ar_result=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID"=>"11", "CODE"=>$g_sec_id),false, Array("DETAIL_PICTURE"));
if($res=$ar_result->GetNext()){
$big_picture = CFile::GetPath($res["DETAIL_PICTURE"]);
	if ($big_picture!=""){
?>
<div class="top_menu_img_cont">
<img src="<?=$big_picture?>"/></div>
				<?}}
}
?>
</a></li>
			<?endif?>


	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
					<? } ?>
<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<?endif?>