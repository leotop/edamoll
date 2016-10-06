<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!CModule::IncludeModule("iblock")) return; ?>
<div id="id-cart-list">
	<div class="sort">
		<?/*<div class="sorttext"><?=GetMessage("SALE_PRD_IN_BASKET")?></div> */?>
		<a href="javascript:void(0)" id="sortbutton1" class="sortbutton current"><?=GetMessage("SALE_PRD_IN_BASKET_ACT")?> (<?=count($arResult["ITEMS"]["AnDelCanBuy"])?>)</a>
		<?if ($countItemsDelay=count($arResult["ITEMS"]["DelDelCanBuy"])):?><a id="sortbutton2" href="javascript:void(0)" onclick="ShowBasketItems(2);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_SHELVE")?> (<?=$countItemsDelay?>)</a><?endif?>

		<? /* if ($countItemsSubscribe=count($arResult["ITEMS"]["ProdSubscribe"])):?><a href="javascript:void(0)" onclick="ShowBasketItems(3);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_SUBSCRIBE")?> (<?=$countItemsSubscribe?>)</a><?endif?>
<?if ($countItemsNotAvailable=count($arResult["ITEMS"]["nAnCanBuy"])):?><a href="javascript:void(0)" onclick="ShowBasketItems(4);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_NOTA")?> (<?=$countItemsNotAvailable?>)</a><?endif */?>
	</div>
<?$numCells = 0;?>
<table class="equipment mycurrentorders" rules="rows" style="width:830px">
	<thead>
		<tr>
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
				<td></td>
				<td><?= GetMessage("SALE_NAME")?></td>
				<?$numCells += 2;?>
			<?endif;?>
			<?if (in_array("VAT", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_VAT")?></td>
				<?$numCells++;?>
			<?endif;?>
			<?if (in_array("TYPE", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-type"><?= GetMessage("SALE_PRICE_TYPE")?></td>
				<?$numCells++;?>
			<?endif;?>
			<?if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-discount"><?= GetMessage("SALE_DISCOUNT")?></td>
				<?$numCells++;?>
			<?endif;?>
			<?if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-weight"><?= GetMessage("SALE_WEIGHT")?></td>
				<?$numCells++;?>
			<?endif;?>
			<?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-quantity"><?= GetMessage("SALE_QUANTITY")?></td>
				<?$numCells++;?>
			<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-price"><?= GetMessage("SALE_PRICE")?></td>
				<?$numCells++;?>
				<td class="cart-item-price">Сумма</td>
<?$numCells++;?>
			<?endif;?>
			<?if (in_array("DELAY", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-delay"></td>
				<?$numCells++;?>
			<?endif;?>

					<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
			<td class="deleteitem"></td>
					<?endif;?>
		</tr>
	</thead>
<?if(count($arResult["ITEMS"]["AnDelCanBuy"]) > 0):?>
	<tbody>
	<?
	$i=0; $iii=1;
	foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
	{
		?>
		<tr>
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
				<td class="td_cart_image">
					<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
						<a href="<?=$arBasketItems["DETAIL_PAGE_URL"]?>">
					<?endif;?>
					<?if (!empty($arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"])) :?>
						<img src="<?=$arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"]?>" alt="<?=$arBasketItems["NAME"] ?>"/>
					<?else:?>
						<img src="/bitrix/components/bitrix/eshop.sale.basket.basket/templates/.default/images/no-photo.png" alt="<?=$arBasketItems["NAME"] ?>"/>
					<?endif?>
					<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
						</a>
					<?endif;?>
				</td>
				<td class="cart-item-name">
					<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
						<a href="<?=$arBasketItems["DETAIL_PAGE_URL"]?>">
					<?endif;?>
						<?=$arBasketItems["NAME"] ?>
					<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
						</a>
					<?endif;?>
					<?if (in_array("PROPS", $arParams["COLUMNS_LIST"]))
					{
						foreach($arBasketItems["PROPS"] as $val)
						{
							echo "<br />".$val["NAME"].": ".$val["VALUE"];
						}
					}?>
				</td>
			<?endif;?>
			<?if (in_array("VAT", $arParams["COLUMNS_LIST"])):?>
				<td><?=$arBasketItems["VAT_RATE_FORMATED"]?></td>
			<?endif;?>
			<?if (in_array("TYPE", $arParams["COLUMNS_LIST"])):?>
				<td><?=$arBasketItems["NOTES"]?></td>
			<?endif;?>
			<?if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"])):?>
				<td><?=$arBasketItems["DISCOUNT_PRICE_PERCENT_FORMATED"]?></td>
			<?endif;?>
			<?if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])):?>
				<td><?=$arBasketItems["WEIGHT_FORMATED"]?></td>
			<?endif;?>
			<? if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
				<td>
<input type="hidden" id="helper" value="1">
					<div class="count_nav">


<?
$GG_BU="";
$db_props = CIBlockElement::GetProperty( 11,$arBasketItems["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"CML2_BASE_UNIT"));
		if($ar_props = $db_props->Fetch()){$GG_BU=$ar_props["VALUE"];}
		if($GG_BU=="КГ" || $GG_BU=="кг") {
$gg_quant=number_format($arBasketItems["QUANTITY"],1)." кг";
} else {$gg_quant=number_format($arBasketItems["QUANTITY"],0)." шт";}
		//$(".bc$arBasketItems["ID"]").first().val(bc--);
?>

						<a href="javascript:void(0)" class="plus"
 onclick='plus("ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>","<?=$GG_BU?>");var bc = $(".bc<?=$arBasketItems["ID"]?>").first().val();ajaxpostshow("/include/cart_big.php", "ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>"+"&ajaxbasketcount="+bc, ".basket" );'></a>
<input id="ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>" class="quantity basket-count-update bc<?=$arBasketItems["ID"]?>"
 maxlength="10" type="text" name="QUANTITY_<?=$arBasketItems["ID"]?>" value="<?=$gg_quant?>" size="6"
  onChange='edit_q("ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>","<?=$GG_BU?>");var bc = $(".bc<?=$arBasketItems["ID"]?>").first().val();ajaxpostshow("/include/cart_big.php", "ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>"+"&ajaxbasketcount="+bc, ".basket" );'>

<a href="javascript:void(0)" class="minus"
 onclick='minus("ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>","<?=$GG_BU?>");var bc = $(".bc<?=$arBasketItems["ID"]?>").first().val();ajaxpostshow("/include/cart_big.php", "ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>"+"&ajaxbasketcount="+bc, ".basket" );'></a>
					</div>
				</td>
<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-price">

<? $g_pv=round(100*($arBasketItems["PRICE"]-floor($arBasketItems["PRICE"])));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

<span class="price"><?=floor($arBasketItems["PRICE"])?><span class="decimal"><?=$g_pv?></span></span>


				</td>
			<td  class="cart-item-price"><?$summ=$arBasketItems["QUANTITY"]*$arBasketItems["PRICE"]; $g_pv=floor(100*($summ-floor($summ)));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

<span class="summ"><?=floor($summ)?><span class="decimal"><?=$g_pv?></span></span></td>
			<?endif;?>
			<?if (in_array("DELAY", $arParams["COLUMNS_LIST"])):?>
				<td><a class="setaside" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["shelve"])?>"
 onclick='ajaxpostshow("/include/cart_big.php", "ajaxaction=delay&ajaxdelayid=<?=$arBasketItems["ID"];?>", ".basket" );return false;' title="<?=GetMessage("SALE_DELETE_PRD")?>"><?=GetMessage("SALE_OTLOG")?></a></td>
			<?endif;?>
					<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
			<td><a class="deleteitem basket-list-delete" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["delete"])?>" id="ajaxaction=delete&ajaxdeleteid=<?=$arBasketItems['ID'];?>"
 onclick='ajaxpostshow("/include/cart_big.php", "ajaxaction=delete&ajaxdeleteid=<?=$arBasketItems["ID"];?>", ".basket" );return false;' title="<?=GetMessage("SALE_DELETE_PRD")?>">Удалить</a></td>
					<?endif;?>
		</tr><?
		$i++;$iii++;
	}
	?>
	</tbody>
</table>
<table class="myorders_itog">
	<tbody>
		<tr class="blacktext">
			<td class="fullsummlbl">Общая стоимость:<br /></td>
			<td><? $g_pv=floor(100*($arResult["allSum"]-floor($arResult["allSum"])));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

<span class="fullsumm"><?=floor($arResult["allSum"])?><span class="decimal"><?=$g_pv?></span></span></td>
		</tr>
		<?if ($arParams["HIDE_COUPON"] != "Y"):?>
		<tr class="blacktext" colspan="2">
			<td  style="height: 40px;">Купон на скидку:</td></tr>
		<tr>

			<td colspan="2" class="tal">
				<input class="input_text_style"
					<?if(empty($arResult["COUPON"])):?>
						onclick="if (this.value=='Введите код')this.value=''; this.style.color='black'"
						onblur="if (this.value=='') {this.value='Введите код'; this.style.color='#a9a9a9'}"
						style="color:#a9a9a9"
					<?endif;?>
						value="<?if(!empty($arResult["COUPON"])):?><?=$arResult["COUPON"]?><?else:?>Введите код<?endif;?>"
						name="COUPON">
<input type="submit" value="использовать" name="BasketRefresh" class="whitetext btuse">
			</td>
		</tr>
		<?endif;?>
		<?if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])):?>
			<tr>
				<td><?echo GetMessage("SALE_ALL_WEIGHT")?>:</td>
				<td><?=$arResult["allWeight_FORMATED"]?></td>
			</tr>
		<?endif;?>
		<?if (doubleval($arResult["DISCOUNT_PRICE"]) > 0):?>
			<tr>
				<td><?echo GetMessage("SALE_CONTENT_DISCOUNT")?><?
					if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0)
						echo " (".$arResult["DISCOUNT_PERCENT_FORMATED"].")";?>:
				</td>
				<td><?=$arResult["DISCOUNT_PRICE_FORMATED"]?></td>
			</tr>
		<?endif;?>
		<?if ($arParams['PRICE_VAT_SHOW_VALUE'] == 'Y'):?>
			<tr>
				<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
				<td><?=$arResult["allNOVATSum_FORMATED"]?></td>
			</tr>
			<tr>
				<td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
				<td><?=$arResult["allVATSum_FORMATED"]?></td>
			</tr>
		<?endif;?>

	</tbody>
</table>
<br/>
	<button type="submit" value="<?echo GetMessage("SALE_ORDER")?>" name="BasketOrder"  id="basketOrderButton2" class="bt3"><?echo GetMessage("SALE_ORDER")?></button>
<button type="submit" value="<?echo GetMessage("SALE_ORDER")?>" name="BasketOrder"  id="basketOrderButtonTop" class="bt3"><?echo GetMessage("SALE_ORDER")?></button>

<?else:?>
	<tbody>
		<tr>
			<td colspan="<?=$numCells?>" style="text-align:center">
				<div class="cart-notetext"><?=GetMessage("SALE_NO_ACTIVE_PRD");?></div>
				<a href="<?=SITE_DIR?>" class="bt3"><?=GetMessage("SALE_NO_ACTIVE_PRD_START")?></a><br><br>
			</td>
		</tr>
	</tbody>
</table>
<?endif;?>
</div>
<?