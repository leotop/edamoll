<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(count($arResult["ITEMS"]) > 0): ?>
	<?
	$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
	$arNotify = unserialize($notifyOption);
	?>

<? if (!$_GET["ALL"]==1) {?>
<div class="nav_top">
<?echo $arResult["NAV_STRING"];?>
</div><div class= "clear"></div>

<?}else{?>
    <div class="nav_top">
      <div class="system-nav-orange">
        <div class="nav-all-div fll" >
          <?
          $APPLICATION->IncludeFile(
            SITE_DIR."include/sort_products.php",
            Array(),
            Array("MODE"=>"html")
          );
          ?>
        </div>
      </div>
    </div><div class= "clear"></div>

  <?}
  ?>
<? if (!$_GET["ALL"]==1) {?>
<h3 class="SALELEADERS"><span class="pinktext"></span></h3>
<? } ?>
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
                     <?
                    if(!is_numeric($arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"])){
                        $base_quantity = $arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"];
                    } else {
                        $base_quantity = '';
                    }
                    ?>
<div class="catalog_item_buy">

					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">

<a class="minus" onclick="minus('q_<?=$arItem['ID']?>','<?=$base_quantity?>')"></a>
						<? if($arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]=="��" || $arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]=="��") {$g_qu="1.0";} else {$g_qu="1";} ?>

								<input  onchange="edit_q('q_<?=$arItem['ID']?>','<?=$base_quantity?>')" id="q_<?=$arItem['ID']?>" type="text" size="6" class="quantity" type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="<?=$g_qu?> <?=$base_quantity?>">
<a class="plus" onclick="plus('q_<?=$arItem['ID']?>','<?=$base_quantity?>')"></a>
					<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
					<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arItem["ID"]?>">

						<a href="<?=$arItem["ADD_URL"]?>" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="addtoCart" value="" onclick="return addToCart(this, '<?=str_replace("'","&lsquo;",$arItem["NAME"])?>','q_<?=$arItem['ID']?>','<?=$base_quantity?>');"></a>

					</form>

</div>
					<?endif?>
<div class="catalog_item" itemscope itemtype = "http://schema.org/Product">
			<?if (is_array(($arItem["PREVIEW_PICTURE"]))):?>
<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		<div class="catalog_foto" align="center">
			<?$gmargtop=round((148-$arItem["PREVIEW_PICTURE"]["HEIGHT"])/2);?>
			<div class="img_helper"></div>
			<img class="item_img" itemprop="image" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["NAME"]?>" /></div></a>
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
								<span itemprop = "price" class="item_price discount-price"><?=floor($arPrice["DISCOUNT_VALUE"])?><span class="decimal"><?=$g_dpv?></span></span>
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
	<? if(!$arPrice["VALUE"]==0){echo(/*round(100*($arPrice["VALUE"]-$arPrice["DISCOUNT_VALUE"])/$arPrice["VALUE"]).*/'%');}?>
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
<div class="nav_bot">
<?echo $arResult["NAV_STRING"];?>
</div><div class= "clear"></div>
</div>
<?elseif($USER->IsAdmin()):?>
<h3 class="hitsale"><span></span><?=GetMessage("CR_TITLE_".$arParams["FLAG_PROPERTY_CODE"])?></h3>
<div class="listitem-carousel">
	<?=GetMessage("CR_TITLE_NULL")?>
</div>
<?endif;?>

