<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="scroll_cart_container">
  <table cellspacing="0" cellpadding="0" border="0"> 
    <tbody> 
		<tr><td rowspan="2"><a href="<?=$arParams["PATH_TO_BASKET"]?>"><img id="bxid_374690" src="/include/img/korzina_small.png" border="0" alt="Корзина" width="31" height="61"  /></a></td> 
<td width="15" rowspan="2"></td><td><a id="bxid_788280" href="<?=$arParams["PATH_TO_BASKET"]?>" ><span class="pinktext undrln">корзина</span></a></td><td width="15" rowspan="2"></td>



<?$g_q=0;$g_sum=0;$g_delay_q=0;?>

		<?
		foreach ($arResult["ITEMS"] as $v)
		{
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
			{
				?>
							<? $g_sum+= $v["QUANTITY"]*$v["PRICE"];?>
							<? $g_q++ ;?>
				<?
			}

			if ($v["DELAY"]=="Y" && $v["CAN_BUY"]=="Y")
			{
				?>

							<?$g_delay_q++;?>

				<?
			}

		}
		?>
<td>Товаров</td><td width="7" rowspan="2"></td><td><b><font color="#FF0039"><?= $g_q?></font></b></td></tr>
      <tr><td>Отложенные (<?= $g_delay_q?>)</td><td>На сумму</td><td><font color="#FF0039"><b><?=round($g_sum)?> р.</b></font> 
         </td></tr>
     </tbody>
   </table>
</div>

