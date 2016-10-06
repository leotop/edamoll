<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult) > 0):  ?>
	<? 
	$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
	$arNotify = unserialize($notifyOption);
?><div class="clear"></div>
		<h3 class="SALELEADERS fll"><span class="pinktext">недавно просмотренные</span></h3>
<?if(count($arResult) > 6): ?>
<div class="rightar" onclick='rightar("foo_1")'></div>
<div class="leftar" onclick='leftar("foo_1")'></div>
<?endif?>
<div class="clear"></div>
<div class="listitem-carousel">

	<div class="lsnn" id="foo_1">

<?foreach($arResult as $key => $arItem):

	if(is_array($arItem))
	{$flag_discount=false;
	 //$bPicture = is_array($arItem["PREVIEW_IMG"]);
		?>
<div class="catalog_item_container">
  <?if ($arItem["CAN_BUY"]):?>
    <div class="catalog_item_buy">
      <form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">

        <a class="minus" onclick="minus('q_<?=$arItem['PRODUCT_ID']?>','<?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>')"></a>
        <? if($arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]=="КГ" || $arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]=="кг") {$g_qu="1.0";} else {$g_qu="1";} ?>

        <input  onchange="edit_q('q_<?=$arItem['PRODUCT_ID']?>','<?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>')" id="q_<?=$arItem['PRODUCT_ID']?>" type="text" size="6" class="quantity" type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="<?=$g_qu?> <?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>">
        <a class="plus" onclick="plus('q_<?=$arItem['PRODUCT_ID']?>','<?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>')"></a>

        <input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
        <input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arItem["ID"]?>">

        <a href="#" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="addtoCart" value="" onclick="return addToCart(this, '<?=str_replace('"',"&lsquo;",$arItem["NAME"])?>','q_<?=$arItem['PRODUCT_ID']?>','<?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>');"></a>
      </form>

    </div>
  <?endif?>
<div class="catalog_item" itemscope itemtype = "http://schema.org/Product">
	<?if (is_array($arItem["PICTURE"])){?>

			<?$gmargtop=round((148-$arItem["PICTURE"]["height"])/2);?>

		<div class="catalog_foto" align="center">
			<div class="img_helper"></div><a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
<img class="item_img" itemprop="image" src="<?=$arItem["PICTURE"]["src"]?>" width="<?=$arItem["PICTURE"]["width"]?>" height="<?=$arItem["PICTURE"]["height"]?>" alt="<?=htmlspecialchars($arItem["NAME"])?>" /></a></div>
	<?}else{?>
	<? if (empty($arItem["PREVIEW_PICTURE"])) {?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><div class="catalog_no_foto"></div></a>
	<?}
			else {
				$big_picture = CFile::GetPath($arItem["DETAIL_PICTURE"]);


				//echo($arItem["PREVIEW_PICTURE"]);
				//echo CFile::ShowImage($arItem["PREVIEW_PICTURE"], 148, 148);
				//	echo($big_picture);
?>
		<div class="catalog_foto" align="center"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
<img   style="margin-top:0px;" class="item_img" itemprop="image" src="<?=$big_picture?>" width="<?=$arItem["PICTURE"]["width"]?>" height="<?=$arItem["PICTURE"]["height"]?>" alt="<?=htmlspecialchars($arItem["NAME"])?>" /></a></div>
<?
}}?>


				<div class="catalog_item_price" align="center">
	<? if($arItem["PRICE"]>$arItem["DISCOUNT_PRICE"]) { ?>

    <? $g_dpv=round(100*($arItem["PRICE"]-floor($arItem["PRICE"])));
    if (strlen($g_dpv)<2) {$g_dpv="0".$g_dpv;}?>
    <span itemprop="price" class="old-price"><?=floor($arItem["PRICE"])?><span class="decimal"><?=$g_dpv?></span></span>
    <? $g_dpv=round(100*($arItem["DISCOUNT_PRICE"]-floor($arItem["DISCOUNT_PRICE"])));
    if (strlen($g_dpv)<2) {$g_dpv="0".$g_dpv;}?>
    <span itemprop="price" class="item_price discount-price"><?=floor($arItem["DISCOUNT_PRICE"])?><span class="decimal"><?=$g_dpv?></span></span>

  <?}else{?>
    <? $g_dpv=round(100*($arItem["PRICE"]-floor($arItem["PRICE"])));
    if (strlen($g_dpv)<2) {$g_dpv="0".$g_dpv;}?>
    <span class="item_price price"><?=floor($arItem["PRICE"])?><span class="decimal"><?=$g_dpv?></span></span>

  <?}?>

				</div>

		<div class="catalog_item_name" align="center">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item_title" title="<?=$arItem["NAME"]?>">
				<span itemprop = "name"><?=$arItem["NAME"]?></span>
			</a>
		</div>

		</div>
  <?if($arItem["PRICE"]>$arItem["DISCOUNT_PRICE"]) :?>
  <div align="center" class="discount_panel">
<span>
	%	</span>
  </div>
<? endif ?>
	</div>
<?
	}
endforeach;
?>
	</div>
	<div class="clear"></div>
</div>
<?elseif($USER->IsAdmin()):?>
<h3 class="hitsale"><span></span><?=GetMessage("CR_TITLE_".$arParams["FLAG_PROPERTY_CODE"])?></h3>
<div class="listitem-carousel">
	<?=GetMessage("CR_TITLE_NULL")?>
</div>
<?endif;?>

