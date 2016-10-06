<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$Name=strip_tags($arResult["NAME"]);

$Name = HTMLToTxt($Name);
$Name = str_replace(array("\"","'"), "", $Name);
?>
<?$APPLICATION->SetPageProperty("description","В интернет-магазине Edamoll.ru Вы можете приобрести ".$Name." по наиболее выгодной для Вас цене. Мы доставляем продукты по Москве и Московской области.");?>
<?
if ($arResult["PROPERTIES"]["pagetitle"]["VALUE"]<>"") {$title=$arResult["PROPERTIES"]["pagetitle"]["VALUE"];} else {$title=$arResult["NAME"]." - купить по низкой цене в Интернет-магазине edamoll.ru ";}
$APPLICATION->SetPageProperty("title",$title);

?>
<div class="catalog-element">
<div class="catalog-element-left">
<div class="catalog-element-image">
	<div class="img_helper"></div>
	<? if(is_array($arResult["PREVIEW_PICTURE"]) || is_array($arResult["DETAIL_PICTURE"])){?>
	<? if(is_array($arResult["DETAIL_PICTURE"])) {?>

	<?$gmargtop=0;/*round((320-$arResult["DETAIL_PICTURE"]["HEIGHT"])/2);*/?>

					<img border="0"  style="margin-top:<?=$gmargtop?>px;" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
	<? } else{?>
	<?$gmargtop=0;/*round((320-$arResult["PREVIEW_PICTURE"]["HEIGHT"])/2);*/?>

					<img border="0" style="margin-top:<?=$gmargtop?>px;" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
	<?}?>
	<? }else {?>
	<div class="catalog-element_no_foto"></div>

	<?}?>
</div>

	<div class="catalog-element-likes">
<script type="text/javascript">
  VK.init({
    apiId: 3848072,
    onlyWidgets: true
  });
</script>
		<div id="vk_like"></div><br />
<script type="text/javascript">
 VK.Widgets.Like('vk_like');
</script>
<div class="fb-like" data-width="350" data-show-faces="false" data-send="false"></div>
</div>
<? $gg_base_unit="";?>
				<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
	<? if ($arProperty["CODE"]=="CML2_BASE_UNIT") { $gg_base_unit =$arProperty["DISPLAY_VALUE"]; }?>
	<? if ($arProperty["CODE"]=="SALELEADERS") { ?>
<div class="bestseller"></div>
<?}?><?endforeach?>
</div>

<div class="flr">
<h1 class="catalog-element-name">
<?=$arResult["NAME"];?>
	</h1>


<div class="flr catalog-element-prop">
	<b class="propname">Лот№ (ID Товара)</b>&nbsp;<?=$arResult["ID"]?><br />

				<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<? if (($arProperty["CODE"]=="MARKA" || $arProperty["CODE"]=="STRANA") &&$arProperty["DISPLAY_VALUE"]!=="&lt;&gt;") {?>

	<b class="propname"><?=$arProperty["NAME"]?></b>&nbsp;<span class="propval"><?
					if(is_array($arProperty["DISPLAY_VALUE"])):
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($pid=="MANUAL"):
						?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
					else:
						echo $arProperty["DISPLAY_VALUE"];?>
					<?endif?></span><br />


	<? } ?>
				<?endforeach?>
	<br />
	<span class="pinktext">Описание товара</span><br />
<? $ggg_str="";?>
				<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

				<? if ($arProperty["CODE"]!=="SALELEADERS" && $arProperty["CODE"]!=="MARKA" && $arProperty["CODE"]!=="STRANA" && $arProperty["CODE"]!=="CML2_BASE_UNIT") {?>
	<?if ($arProperty["DISPLAY_VALUE"]!=="&lt;&gt;"){
	if ($arProperty["CODE"]!=="KKAL" && $arProperty["CODE"]!=="BELKI" && $arProperty["CODE"]!=="ZHIRY" && $arProperty["CODE"]!=="UGLEVODY"){ ?>
	<b class="propname"><?=$arProperty["NAME"]?></b>&nbsp;<span class="propval"><?
					if(is_array($arProperty["DISPLAY_VALUE"])):
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($pid=="MANUAL"):
						?><a href="<?=$arProperty["VALUE"]?>"><?=GetMessage("CATALOG_DOWNLOAD")?></a><?
					else:
					 echo $arProperty["DISPLAY_VALUE"];?>
	<?endif?></span><br />
	<?}
else
{
$ggg_str.='<b class="propname">'.$arProperty["NAME"].'</b>&nbsp;<span class="propval">'.$arProperty["DISPLAY_VALUE"];
	if ($arProperty["CODE"]=="KKAL") {$ggg_str.=' Ккал</span><br />';} else {$ggg_str.=' г</span><br />';}
}
 } ?>

	<? } ?>
				<?endforeach?>
	<? if ($ggg_str!=="") {?>
	<br /><span class="pinktext">Пищевая ценность на 100 г</span><br />
<? echo $ggg_str;}?>
  <noindex>
	<?if($arResult["DETAIL_TEXT"]):?>
		<br /><?=$arResult["DETAIL_TEXT"]?><br />
	<?elseif($arResult["PREVIEW_TEXT"]):?>
		<br /><?=$arResult["PREVIEW_TEXT"]?><br />
	<?endif;?>
  </noindex>
</div>

<div class="fll catalog-element-prices">

<? $flag_discount=false; ?>

	<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
		<?foreach($arResult["OFFERS"] as $arOffer):?>
			<?foreach($arParams["OFFERS_FIELD_CODE"] as $field_code):?>
				<small><?echo GetMessage("IBLOCK_FIELD_".$field_code)?>:&nbsp;<?
						echo $arOffer[$field_code];?></small><br />
			<?endforeach;?>
			<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<small><?=$arProperty["NAME"]?>:&nbsp;<?
					if(is_array($arProperty["DISPLAY_VALUE"]))
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					else
						echo $arProperty["DISPLAY_VALUE"];?></small><br />
			<?endforeach?>
			<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
				<?if($arPrice["CAN_ACCESS"]):?>
					<p><?=$arResult["CAT_PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp;
					<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
						<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
					<?else:?>
						<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
					<?endif?>
					</p>
				<?endif;?>
			<?endforeach;?>
			<p>
			<?if($arParams["DISPLAY_COMPARE"]):?>
				<noindex>
				<a href="<?echo $arOffer["COMPARE_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_COMPARE")?></a>&nbsp;
				</noindex>
			<?endif?>
			<?if($arOffer["CAN_BUY"]):?>
				<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
					<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
					<table border="0" cellspacing="0" cellpadding="2">
						<tr valign="top">
							<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
							<td>
<a class="minus" onclick="minus('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>')"></a>
						<? if($gg_base_unit=="КГ" || $gg_base_unit=="кг") {$g_qu="1.0";} else {$g_qu="1";} ?>

								<input  onchange="edit_q('q_<?=$arResult["ID"]?>','<?=$arItem["PROPERTIES"]["CML2_BASE_UNIT"]["VALUE"]?>')" id="q_<?=$arResult["ID"]?>" type="text" size="6" class="quantity" type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="<?=$g_qu?> <?=$gg_base_unit?>">
<a class="plus" onclick="plus('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>')"></a>

							</td>
						</tr>
					</table>
					<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
					<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
					<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?echo GetMessage("CATALOG_BUY")?>">
						<a href="<?=$arItem["ADD_URL"]?>" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="addtoCart" value="" onclick="return addToCart(this, '<?=str_replace("'","&lsquo;",$arItem["NAME"])?>','q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>');"></a>
					</form>
				<?else:?>
					<noindex>
					<a href="<?echo $arOffer["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
					&nbsp;<a href="<?echo $arOffer["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_ADD")?></a>
					</noindex>
				<?endif;?>
			<?elseif(count($arResult["CAT_PRICES"]) > 0):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
				<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
					"NOTIFY_ID" => $arOffer['ID'],
					"NOTIFY_URL" => htmlspecialcharsback($arOffer["SUBSCRIBE_URL"]),
					"NOTIFY_USE_CAPTHA" => "N"
					),
					$component
				);?>
			<?endif?>
			</p>
		<?endforeach;?>
	<?else:?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
				<p>
					<?/*
<?=$arResult["CAT_PRICES"][$code]["TITLE"];?>&nbsp;
				<?if($arParams["PRICE_VAT_SHOW_VALUE"] && ($arPrice["VATRATE_VALUE"] > 0)):?>
					<?if($arParams["PRICE_VAT_INCLUDE"]):?>
						(<?echo GetMessage("CATALOG_PRICE_VAT")?>)
					<?else:?>
						(<?echo GetMessage("CATALOG_PRICE_NOVAT")?>)
					<?endif?>
				<?endif;?>:&nbsp;
*/?>
<? $g_pv=round(100*($arPrice["VALUE"]-floor($arPrice["VALUE"])));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
<? $flag_discount=true; ?>
<span itemprop = "price" class="old-price"><?=floor($arPrice["VALUE"])?><span class="decimal"><?=$g_pv?></span></span>
<? $g_dpv=round(100*($arPrice["DISCOUNT_VALUE"]-floor($arPrice["DISCOUNT_VALUE"])));
	  if (strlen($g_dpv)<2) {$g_dpv=$g_dpv."0";}?>
								<span itemprop = "price" class="item_price discount-price"><?=floor($arPrice["DISCOUNT_VALUE"])?><span class="decimal"><?=$g_dpv?></span></span>

				<?else:?>
<span itemprop = "price" class="item_price price"><?=floor($arPrice["VALUE"])?><span class="decimal"><?=$g_pv?></span></span>
				<?endif?>
				</p>
			<?endif;?>
		<?endforeach;?>
		<?if(is_array($arResult["PRICE_MATRIX"])):?>
			<table cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table">
			<thead>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) >= 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<td><?= GetMessage("CATALOG_QUANTITY") ?></td>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td><?= $arType["NAME_LANG"] ?></td>
				<?endforeach?>
			</tr>
			</thead>
			<?foreach ($arResult["PRICE_MATRIX"]["ROWS"] as $ind => $arQuantity):?>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) > 1 || count($arResult["PRICE_MATRIX"]["ROWS"]) == 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<th nowrap>
						<?if(IntVal($arQuantity["QUANTITY_FROM"]) > 0 && IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_FROM_TO")));
						elseif(IntVal($arQuantity["QUANTITY_FROM"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], GetMessage("CATALOG_QUANTITY_FROM"));
						elseif(IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_TO"));
						?>
					</th>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td>
						<?if($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"] < $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"])
							echo '<s>'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"]).'</s> <span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						else
							echo '<span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						?>
					</td>
				<?endforeach?>
			</tr>
			<?endforeach?>
			</table>
			<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?>
				<?if($arParams["PRICE_VAT_INCLUDE"]):?>
					<small><?=GetMessage('CATALOG_VAT_INCLUDED')?></small>
				<?else:?>
					<small><?=GetMessage('CATALOG_VAT_NOT_INCLUDED')?></small>
				<?endif?>
			<?endif;?><br />
		<?endif?>
		<?if($arResult["CAN_BUY"]):?>


			<?if($arParams["USE_PRODUCT_QUANTITY"] || count($arResult["PRODUCT_PROPERTIES"])):?>
				<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
				<?if($arParams["USE_PRODUCT_QUANTITY"] && $arResult["CATALOG_QUANTITY"]>0):?>
						<div><?echo ("Количество");?></div>
<div class="pmcont">
<a class="minus" onclick="minus('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>')"></a>
						<? if($gg_base_unit=="КГ" || $gg_base_unit=="кг") {$g_qu="1.0";} else {$g_qu="1";} ?>

								<input  onchange="edit_q('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>')" id="q_<?=$arResult["ID"]?>" type="text" size="6" class="quantity" type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="<?=$g_qu?> <?=$gg_base_unit?>">
<a class="plus" onclick="plus('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>')"></a>

						</div>

				<?endif;?>
				<table border="0" cellspacing="0" cellpadding="2">

				<?foreach($arResult["PRODUCT_PROPERTIES"] as $pid => $product_property):?>
					<tr valign="top">
						<td><?echo $arResult["PROPERTIES"][$pid]["NAME"]?>:</td>
						<td>
						<?if(
							$arResult["PROPERTIES"][$pid]["PROPERTY_TYPE"] == "L"
							&& $arResult["PROPERTIES"][$pid]["LIST_TYPE"] == "C"
						):?>
							<?foreach($product_property["VALUES"] as $k => $v):?>
								<label><input type="radio" name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]" value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"checked"'?>><?echo $v?></label><br>
							<?endforeach;?>
						<?else:?>
							<select name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]">
								<?foreach($product_property["VALUES"] as $k => $v):?>
									<option value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"selected"'?>><?echo $v?></option>
								<?endforeach;?>
							</select>
						<?endif;?>
						</td>
					</tr>
				<?endforeach;?>
				</table>



				<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
				<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
<div>
	<? if ($arResult["CATALOG_QUANTITY"]>0) { ?>
				<a class="btncart" href="<?=$arItem["ADD_URL"]?>" class="addtoCart" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>"  onclick="return addToCart(this, '<?=str_replace("'","&lsquo;",$arResult["NAME"])?>','q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>');"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></a>
	<a href="#" class="btndelay" onclick="return addToCartDelay('q_<?=$arResult["ID"]?>','<?=$gg_base_unit?>');" style="margin-left: 4px;"><img style="margin-right: 11px;margin-bottom: -5px;" src="/images/time.png">ОТЛОЖИТЬ</a>
    <?
    global $APPLICATION,$USER;
    if($USER->IsAuthorized()){
    $arr = unserialize($_COOKIE['BITRIX_SM_Izb']);
    ?>
      <div id="Favorites">
     <?
    if(in_array($arResult["ID"],$arr) )
      {?>
       <a href="#" class="pinktext" onclick="return DelToIzbrannoeElement(<?=$arResult["ID"]?>)"  ><div class="img_activ_izb img_activ_izb_posi">В избранном</div></a>

      <?}
    else{
      ?>
      <a href="#" class="pinktext" onclick="return addToIzbrannoe(<?=$arResult["ID"]?>);"><div class="img_activ_izb">В избранное</div></a>

    <?
    }?>
      </div>
    <?
    }
    ?>
  <? } else {?>
<span  class="pinktext" >Товар закончился</span>
	<? }?>
					</div>
</form>
			<?else:?>
				<noindex>
				<a href="<?echo $arResult["BUY_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_BUY")?></a>
				&nbsp;<a href="<?echo $arResult["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></a>
				</noindex>
			<?endif;?>
		<?elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"])):?>
			<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
			<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
				"NOTIFY_ID" => $arResult['ID'],
				"NOTIFY_PRODUCT_ID" => $arParams['PRODUCT_ID_VARIABLE'],
				"NOTIFY_ACTION" => $arParams['ACTION_VARIABLE'],
				"NOTIFY_URL" => htmlspecialcharsback($arResult["SUBSCRIBE_URL"]),
				"NOTIFY_USE_CAPTHA" => "N"
				),
				$component
			);?>
		<?endif?>
	<?endif?>
</div>

<? if($flag_discount==true) {?>
<div class="discount_panel" align="center">
<span>
	<? if(!$arPrice["VALUE"]==0){echo(/*round(100*($arPrice["VALUE"]-$arPrice["DISCOUNT_VALUE"])/$arPrice["VALUE"]).*/'%');}?>
	</span>
	</div>
	<?}?>

<? /**
		<br />
	<?if($arResult["DETAIL_TEXT"]):?>
		<br /><?=$arResult["DETAIL_TEXT"]?><br />
	<?elseif($arResult["PREVIEW_TEXT"]):?>
		<br /><?=$arResult["PREVIEW_TEXT"]?><br />
	<?endif;?>
	<?if(count($arResult["LINKED_ELEMENTS"])>0):?>
		<br /><b><?=$arResult["LINKED_ELEMENTS"][0]["IBLOCK_NAME"]?>:</b>
		<ul>
	<?foreach($arResult["LINKED_ELEMENTS"] as $arElement):?>
		<li><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
	<?endforeach;?>
		</ul>
	<?endif?>
**/?>

</div>
</div>
<div class="clear"></div>
<? /* if(is_array($arResult["SECTION"])):?>
		<br /><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=GetMessage("CATALOG_BACK")?></a>
<?endif */?>