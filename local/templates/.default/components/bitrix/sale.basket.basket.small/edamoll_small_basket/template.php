<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*if ($arResult["READY"]=="Y" || $arResult["DELAY"]=="Y"):*/?>


<div class="bot"> 
  <table cellspacing="0" cellpadding="0" border="0"> 
    <tbody> 
		<tr><td rowspan="4"><a href="<?=$arParams["PATH_TO_BASKET"]?>"><img id="bxid_374690" src="/include/img/korzina.png" border="0" alt="Корзина" width="57" height="97"  /></a></td> 
<td width="10" rowspan="4"></td><td><a id="bxid_788280" href="<?=$arParams["PATH_TO_BASKET"]?>" ><span class="pinktext undrln">корзина</span></a></td><td width="10" rowspan="4"></td><td></td></tr>
     


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
      <tr><td>Отложенные</td><td>(<?= $g_delay_q?>)</td></tr>
     
      <tr><td>Товаров</td><td><b><font color="#FF0039"><?= $g_q?></font></b></td></tr>
     
		<tr><td>На сумму</td><td><font color="#FF0039"><b><?=round($g_sum)?> р.</b></font> 
          <br />
         </td></tr>
     </tbody>
   </table>
 </div>

<?/*endif;*/?>
