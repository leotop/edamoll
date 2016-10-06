<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="filter_div">
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
	<?foreach($arResult["HIDDEN"] as $arItem):?>
	<? if ($arItem["CONTROL_NAME"]!="af_KKAL_MIN" && $arItem["CONTROL_NAME"]!="af_KKAL_MAX") {?>
		<input
			type="hidden"
			name="<?echo $arItem["CONTROL_NAME"]?>"
			id="<?echo $arItem["CONTROL_ID"]?>"
			value="<?echo $arItem["HTML_VALUE"]?>"
		/>
	<? } ?>
	<?endforeach;?>

<?
CModule::IncludeModule('iblock');
$arFieldsKKAL=array();
$arFieldsMARKA=array();

$arFieldsSTRANA=array();
  $arFilter2 = Array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'CODE'=>$arParams["gItems"]);
  $db_list2 = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter2, false,array("UF_KKAL_MIN",'UF_KKAL_MAX','UF_BRANDS','UF_COUNTRY'));
  while($ar_result2 = $db_list2->GetNext())
  {
	$arFieldsKKAL["MIN"]=$ar_result2["UF_KKAL_MIN"];
	$arFieldsKKAL["MAX"]=$ar_result2["UF_KKAL_MAX"];
  }

?>	
	
	
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if( $arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"])):?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">

					<?
						//$arItem["VALUES"]["MIN"]["VALUE"];
						//$arItem["VALUES"]["MAX"]["VALUE"];
					?>

						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<span class="min-price"><?echo GetMessage("CT_BCSF_FILTER_FROM")?></span>
								</td>
								<td style="text-align:right;">
									<span class="max-price"><?echo GetMessage("CT_BCSF_FILTER_TO")?></span>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 10px;"><input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
								<td><input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
							</tr>
						</table>

			</div>


<?elseif($arItem["CODE"]=="KKAL" ):?>

	<? if ($arFieldsKKAL["MAX"]<>"") {?>

<div  class="filter_name2">Калории<br /><br /></div>
<div class="filter_vals2">
 <script>
$(function() {
$( "#slider-range_kkal" ).slider({
range: true,
min: <? echo $arFieldsKKAL["MIN"]; ?>,
max: <? echo $arFieldsKKAL["MAX"]; ?>,
values: [ <? if ($_GET["af_KKAL_MIN"]!=""){echo $_GET["af_KKAL_MIN"];}else{echo $arFieldsKKAL["MIN"];}?>, <?  if ($_GET["af_KKAL_MAX"]!=""){echo $_GET["af_KKAL_MAX"];}else{echo $arFieldsKKAL["MAX"];}?> ],

slide: function( event, ui ) {
	//alert("slide! "+$( "#af_KKAL_MIN" ).html());
$( "#af_KKAL_MIN" ).val(ui.values[ 0 ]);
$( "#af_KKAL_MAX" ).val(ui.values[ 1 ]);
}
});
$("#slider-range_kkal>a").first().css("background-position","left top");
});


</script>

						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<span class="min-price"><? if ($_GET["af_KKAL_MIN"]!=""){echo $_GET["af_KKAL_MIN"];}else{echo $arFieldsKKAL["MIN"];}?> ккал</span>
								</td>
								<td style="text-align:right;">
									<span class="max-price"><?  if ($_GET["af_KKAL_MAX"]!=""){echo $_GET["af_KKAL_MAX"];}else{echo $arFieldsKKAL["MAX"];}?> ккал</span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
<div id="slider-range_kkal"></div>
								</td>

							</tr>
							<tr>
								<td>
									<span class="min-price"><?echo GetMessage("CT_BCSF_FILTER_FROM")?></span>
								</td>
								<td style="text-align:right;">
									<span class="max-price"><?echo GetMessage("CT_BCSF_FILTER_TO")?></span>
								</td>
							</tr>
							<tr>
								<td style="padding-right: 10px;"><input
									class="min-price"
									type="text"
									name="af_KKAL_MIN"
									id="af_KKAL_MIN"
									value="<? if ($_GET["af_KKAL_MIN"]!=""){echo $_GET["af_KKAL_MIN"];}else{echo $arFieldsKKAL["MIN"];}?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
onchange="$(function(){
var value1=$('#af_KKAL_MIN').val();
var value2=$('#af_KKAL_MAX').val();

	if(parseInt(value1) > parseInt(value2)){
	value1 = value2;
	$('input#af_KKAL_MAX').val(value1);
	}
$('#slider-range_kkal').slider('values',1,parseFloat(value1));
});"
								/></td>
								<td><input
									class="max-price"
									type="text"
									name="af_KKAL_MAX"
									id="af_KKAL_MAX"
									value="<?  if ($_GET["af_KKAL_MAX"]!=""){echo $_GET["af_KKAL_MAX"];}else{echo $arFieldsKKAL["MAX"];}?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
onchange="$(function(){
var value1=$('#af_KKAL_MIN').val();
var value2=$('#af_KKAL_MAX').val();

	if(parseInt(value1) > parseInt(value2)){
	value2 = value1;
	$('input#af_KKAL_MIN').val(value1);
	}
$('#slider-range_kkal').slider('values',0,parseFloat(value2));
});"
								/></td>
							</tr>
						</table>

			</div>
	<? }?>

	<?elseif(!empty($arItem["VALUES"])):?>
	<? if ($arItem["CODE"]=="MARKA"){?>
<?
 if (count($arFieldsMARKA)>1) {?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
	<? } else {?><div> <? }
?>
	<?foreach($arFieldsMARKA as $val2 => $ar2):?>
	<? if(trim($ar2["PROPERTY_MARKA_VALUE"])!== "" && $ar2["PROPERTY_MARKA_VALUE"]!== "&lt;&gt;") {?>
	<? $ar=$arItem["VALUES"][$val2];?>
					<input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
	/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label><br />
	<?}?>
	<?endforeach;?>
	<?} elseif ($arItem["CODE"]=="STRANA") { ?>
<?
 if (count($arFieldsSTRANA)>1) {?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
	<? } else {?><div> <? }?>
	<?foreach($arFieldsSTRANA as $val2 => $ar2):?>
	<? if(trim($ar2["PROPERTY_STRANA_VALUE"])!== "" && $ar2["PROPERTY_STRANA_VALUE"]!== "&lt;&gt;") {?>
	<? $ar=$arItem["VALUES"][$val2];?>
					<input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
	/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label><br />
	<?}?>
	<?endforeach;?>
	<?} else {
?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
?>
					<?foreach($arItem["VALUES"] as $val => $ar):?>
					<input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
	/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label><br />
					<?endforeach;?>
		</div>
	<? } ?>
			</div>
			<?endif;?>
		<?endforeach;?>

<div  class="filter_name" style="padding-bottom: 20px;">
		<input  class="filter_btn" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
		<input  class="filter_btn" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />
			</div>

</form>

<script>

</script>
</div>