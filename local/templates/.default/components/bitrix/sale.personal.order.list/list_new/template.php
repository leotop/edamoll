<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
function showInfoDiv(id){
if ($("#infodiv"+id).hasClass("showinfo")){
$("#addinfo"+id+">span").html("(подробнее)");
$("#infodiv"+id).removeClass("showinfo");
	}
	else{
$("#addinfo"+id+">span").html("(скрыть)");
$("#infodiv"+id).addClass("showinfo")
	}

}
</script>

<table border="0" cellspacing="0" cellpadding="5" style="margin-top: 30px;width: 800px;">
	<tr>
		<td width="100%">
			<?
			foreach($arResult["ORDERS"] as $key => $vval)
			{
				//foreach($val as $vval)
				{
					//	$bNoOrder = false;
?>
					<table class="sale_personal_order_list">
						<tr>
							<td>
<span onclick="showInfoDiv('<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>')">
								<b class="undrln">
								<?echo GetMessage("STPOL_ORDER_NO")?>
								<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>
								<?echo GetMessage("STPOL_FROM")?>
								<?= $vval["ORDER"]["DATE_INSERT"]; ?>
								</b></span>
								<?
								if ($vval["ORDER"]["CANCELED"] == "Y")
									echo GetMessage("STPOL_CANCELED");
								?>
							</td><td>
								<b>
								на сумму
								<?=$vval["ORDER"]["PRICE"]?>р.
							</b></td>
								<?/*
								<?if($vval["ORDER"]["PAYED"]=="Y")
									echo GetMessage("STPOL_PAYED_Y");
								else
									echo GetMessage("STPOL_PAYED_N");
								?>
								<?if(IntVal($vval["ORDER"]["PAY_SYSTEM_ID"])>0)
									echo GetMessage("P_PAY_SYS").$arResult["INFO"]["PAY_SYSTEM"][$vval["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?>
								<br />
								<b><?echo GetMessage("STPOL_STATUS_T")?></b>

*/?>
<td>
	<?=$arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"]?></td>
							<td class="addinfo" id="addinfo<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>"><span onclick="showInfoDiv('<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>')">(подробнее)</span><td>

								<?/*
if(IntVal($vval["ORDER"]["DELIVERY_ID"])>0)
								{
									echo "<b>".GetMessage("P_DELIVERY")."</b>".$arResult["INFO"]["DELIVERY"][$vval["ORDER"]["DELIVERY_ID"]]["NAME"];
								}
								elseif (strpos($vval["ORDER"]["DELIVERY_ID"], ":") !== false)
								{
									echo "<b>".GetMessage("P_DELIVERY")."</b>";
									$arId = explode(":", $vval["ORDER"]["DELIVERY_ID"]);
									echo $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]." (".$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"].")";
								}
*/?>
							
						</tr>

					</table>
			<div class="infodiv" id="infodiv<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>">
<table class="equipment mycurrentorders" rules="rows" style="width:100%">
	<thead>
		<tr>
				<td></td>
				<td>Название</td>

			<td>Количество/Вес</td>

				<td class="cart-item-price">Цена за ед.</td>
				<td class="cart-item-price">Сумма</td>
		</tr>
	</thead>

	<tbody>
<? foreach($vval["BASKET_ITEMS"] as $arItemz)
{?>
<tr>
<?
$big_picture="";$quan=0;
if(!CModule::IncludeModule("iblock"))return; 
	//$res = CIBlockElement::GetByID($arItemz["PRODUCT_ID"]);
$res = CIBlockElement::GetList(
Array("SORT"=>"ASC"),
Array("ID"=>$arItemz["PRODUCT_ID"]),
false,
false,
Array("CATALOG_QUANTITY","PREVIEW_PICTURE","ID"));
 if($ar_res = $res->GetNext()){?>
<?
$big_picture = CFile::GetPath($ar_res["PREVIEW_PICTURE"]);
$quan=$ar_res["CATALOG_QUANTITY"];
}
?>
<?
$base_unit="шт";
$db_props2 = CIBlockElement::GetProperty(11, $arItemz["PRODUCT_ID"], array("sort" => "asc"), Array("CODE"=>"CML2_BASE_UNIT"));
if($ar_props2 = $db_props2->Fetch())
	$base_unit = $ar_props2["VALUE"];
?>
				<td class="td_cart_image">

					<?if (strlen($arItemz["DETAIL_PAGE_URL"])>0):?>
					<a href="/item/<?=$arItemz["PRODUCT_ID"]?>">
					<?endif;?>
					<?if (!empty($big_picture) ):?>
						<img src="<?=$big_picture?>" alt="<?=$arItemz["NAME"] ?>"/>
					<?else:?>
						<img src="/bitrix/components/bitrix/eshop.sale.basket.basket/templates/.default/images/no-photo.png" alt="<?=$arItemz["NAME"] ?>"/>
					<?endif?>
					<?if (strlen($arItemz["DETAIL_PAGE_URL"])>0):?>
						</a>
					<?endif;?>

				</td>

				<td><?=$arItemz["NAME"]?></td>

			<td><?=$arItemz["QUANTITY"]?> <?=$base_unit?></td>


				<td class="cart-item-price">

<? $g_pv=round(100*($arItemz["PRICE"]-floor($arItemz["PRICE"])));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

<span class="price"><?=floor($arItemz["PRICE"])?><span class="decimal"><?=$g_pv?></span></span>


				</td>
			<td  class="cart-item-price"><?$summ=$arItemz["QUANTITY"]*$arItemz["PRICE"]; $g_pv=round(100*($summ-floor($summ)));
	  if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}?>

<span class="summ"><?=floor($summ)?><span class="decimal"><?=$g_pv?></span></span></td>
<td>
	<? if ($arItemz["CAN_BUY"]=="Y" && $quan > 0) {?>
<input id="q_<?=$arItemz["PRODUCT_ID"]?>" type="hidden" value="1">
<a href="" name="actionADD2BASKET" onclick="return addToCart(this, '<?=$arItemz["NAME"]?>','q_<?=$arItemz["PRODUCT_ID"]?>','<?=$base_unit?>');">
	<img src="/include/img/cart.png" width="37" height="27" alt="Добавить в корзину"  /></a>
	<? } else {?>
	<img src="/include/img/cart_g.png" width="37" height="27" alt="Нет в наличии"/>
	<? } ?>
	</td>
</tr>
		<?}?>

</tbody></table>
</div>
				<?
				}
				?>
				<br />
				<?
			}

			if ($bNoOrder)
			{
				?><center><?echo GetMessage("STPOL_NO_ORDERS")?></center><?
			}
			?>
		</td>
	</tr>
</table>