<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?=$APPLICATION->AddChainItem($arResult["NAME"], "");?>
<h2 style="color:rgb(255,0,57);"><?=$arResult["NAME"]?></h2>

<?if(count($arResult["ITEMS"]) > 0): ?>
	<?
	$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
	$arNotify = unserialize($notifyOption);
	?>
<h3 class="SALELEADERS"><span class="pinktext"></span></h3>
<div class="listitem-carousel">

	<div class="lsnn" id="foo_<?=ToLower($arParams["FLAG_PROPERTY_CODE"])?>">

<?foreach($arResult["ITEMS"] as $key => $arItem):
//print_r($arItem["PRICES"]);
//print_r($arItem);
	if(is_array($arItem))
	{$flag_discount=false;
	 //$bPicture = is_array($arItem["PREVIEW_IMG"]);
		?>
<div class="catalog_item_container">
					<?if ($arItem["CAN_BUY"]):?>
<div class="catalog_item_buy">

					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
<a class="minus" onclick="minus('q_<?=$arItem['ID']?>')"></a>
								<input id="q_<?=$arItem['ID']?>" type="text" size="6" class="quantity" type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1">
<a class="plus" onclick="plus('q_<?=$arItem['ID']?>')"></a>
					<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
					<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arItem["ID"]?>">
					<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="addtoCart" value="">
					</form>

</div>
					<?endif?>
<div class="catalog_item" itemscope itemtype = "http://schema.org/Product">
			<?if (is_array(($arItem["PREVIEW_PICTURE"]))):?>
		<div class="catalog_foto" align="center"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img class="item_img" itemprop="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" /></a></div>
			<?else:?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><div class="catalog_no_foto"></div></a>
			<?endif?>


				<div class="catalog_item_price" align="center">
<?
					$numPrices = count($arParams["PRICE_CODE"]);
					foreach($arItem["PRICES"] as $code=>$arPrice):
						if($arPrice["CAN_ACCESS"]):?>
							<?if ($numPrices>1):?><p style="padding: 0; margin-bottom: 5px;"><?=$arResult["PRICES"][$code]["TITLE"];?>:</p><?endif?>
<? $g_pv=round(100*($arPrice["VALUE"]-floor($arPrice["VALUE"])));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>
							<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):
$flag_discount=true;
?>
<span itemprop = "price" class="old-price"><?=floor($arPrice["VALUE"])?><span class="decimal"><?=$g_pv?></span></span>
<? $g_dpv=round(100*($arPrice["DISCOUNT_VALUE"]-floor($arPrice["DISCOUNT_VALUE"])));
	  if (strlen($g_dpv)<2) {$g_dpv=$g_dpv."0";}?>
								<span itemprop = "price" class="item_price discount-price"><?=floor($arPrice["DISCOUNT_VALUE"])?><span class="decimal"><?=$g_pv?></span></span>
							<?else:?>
								<span itemprop = "price" class="item_price price"><?=floor($arPrice["VALUE"])?><span class="decimal"><?=$g_pv?></span></span>
							<?endif;
						endif;
					endforeach;
				?>
				</div>

		<div class="catalog_item_name" align="center">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item_title" title="<?=$arItem["NAME"]?>">
				<span itemprop = "name"><?=$arItem["NAME"]?></span>
			</a>
		</div>

		</div>
	<? if($flag_discount==true) {?>
<div class="discount_panel" align="center">
<span>
	<? if(!$arPrice["VALUE"]==0){echo(round(100*($arPrice["VALUE"]-$arPrice["DISCOUNT_VALUE"])/$arPrice["VALUE"]).'%');}?> 
	</span>
	</div>
	<?}?>
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

