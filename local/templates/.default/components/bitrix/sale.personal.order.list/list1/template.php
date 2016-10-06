<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
?>
<table border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="100%">
<div class="mgbot">
			Вы можете отследить путь вашего заказа <br />
А так же посмотреть предыдущие заказы
			</div>
			<br/>
			<?
			foreach($arResult["ORDERS"] as $key => $vval)
			{
				//foreach($val as $vval)
				{
					//	$bNoOrder = false;
?>
					<table class="sale_personal_order_list">
						<tr>
							<td><a href="/personal/order.php?ORDER_ID=
<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>">
								<b class="undrln">
								<?echo GetMessage("STPOL_ORDER_NO")?>
								<?=$vval["ORDER"]["ACCOUNT_NUMBER"]?>
								<?echo GetMessage("STPOL_FROM")?>
								<?= $vval["ORDER"]["DATE_INSERT"]; ?>
								</b></a>
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