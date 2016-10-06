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


<?elseif($arItem["CODE"]=="KKAL" ):;?>
<?
$arFields="";
$arFields2="";
if (CModule::IncludeModule("iblock")):
$gel=CIBlockElement::GetList(
 Array("PROPERTY_KKAL_VALUE"=>"ASC"),
 Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"SECTION_CODE"=>$arParams["gItems"],"INCLUDE_SUBSECTIONS"=>"Y",">CATALOG_QUANTITY"=>0),
 false,
 false,
 Array("ID","PROPERTY_KKAL")
);
while($ob = $gel->GetNextElement()){ 
 $arFieldz = $ob->GetFields();  
		if (trim($arFieldz["PROPERTY_KKAL_VALUE"])!== "" && $arFieldz["PROPERTY_KKAL_VALUE"]!== "&lt;&gt;"){
$arFields[$arFieldz["PROPERTY_KKAL_ENUM_ID"]]=$arFieldz;
 $arFields2[]=(double)str_replace ( ",", ".", $arFieldz["PROPERTY_KKAL_VALUE"]);};
	// $arProps = $ob->GetProperties();
			//print_r($arFieldz);
}
;
endif;
?>
	<? if (count($arFields2)>1) {?>
<?$af_KKAL_MIN=max($arFields2);$af_KKAL_MAX=min($arFields2);$af_KKAL_MAX2=max($arFields2);$af_KKAL_MIN2=min($arFields2);?>
	<?foreach($arFields as $val2 => $ar2):?>
	<?/*
	 ?>
	<? $ar=$arItem["VALUES"][$val2];?>
	<input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
	/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label><br />
<?*/
	if ($ar["CHECKED"]) {
	if ((double)str_replace ( ",", ".", $ar["VALUE"]) >= $af_KKAL_MAX){
$af_KKAL_MAX=(double)str_replace ( ",", ".", $ar["VALUE"]);
$af_KKAL_MAX2=$af_KKAL_MAX;
}
	if ((double)str_replace ( ",", ".", $ar["VALUE"]) < $af_KKAL_MIN || $af_KKAL_MIN == (double)str_replace ( ",", ".", $ar["VALUE"])){
$af_KKAL_MIN=(double)str_replace ( ",", ".", $ar["VALUE"]);
$af_KKAL_MIN2=$af_KKAL_MIN;
}
}
?>

	<?endforeach;?>

<div  class="filter_name2">Калории<br /><br /></div>
<div class="filter_vals2">
 <script>
$(function() {
$( "#slider-range_kkal" ).slider({
range: true,
min: <? echo $af_KKAL_MIN2; ?>,
max: <? echo $af_KKAL_MAX2; ?>,
values: [ <? if ($_GET["af_KKAL_MIN"]!=""){echo $_GET["af_KKAL_MIN"];}else{echo $af_KKAL_MIN2;}?>, <?  if ($_GET["af_KKAL_MAX"]!=""){echo $_GET["af_KKAL_MAX"];}else{echo $af_KKAL_MAX2;}?> ],

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
									<span class="min-price"><?echo $af_KKAL_MIN2;?> ккал</span>
								</td>
								<td style="text-align:right;">
									<span class="max-price"><?echo  $af_KKAL_MAX2;?> ккал</span>
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
									value="<? if ($_GET["af_KKAL_MIN"]!=""){echo $_GET["af_KKAL_MIN"];}else{echo $af_KKAL_MIN2;}?>"
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
									value="<?  if ($_GET["af_KKAL_MAX"]!=""){echo $_GET["af_KKAL_MAX"];}else{echo $af_KKAL_MAX2;}?>"
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
			<?elseif(!empty($arItem["VALUES"])):;?>
	<? if ($arItem["CODE"]=="MARKA"){?>
<?
$arFields="";
if (CModule::IncludeModule("iblock")):
$gel=CIBlockElement::GetList(
 Array("PROPERTY_MARKA_VALUE"=>"ASC"),
 Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"SECTION_CODE"=>$arParams["gItems"],"INCLUDE_SUBSECTIONS"=>"Y",">CATALOG_QUANTITY"=>0),
 false,
 false,
 Array("ID","PROPERTY_MARKA")
);
while($ob = $gel->GetNextElement()){ 
 $arFieldz = $ob->GetFields();  
$arFields[$arFieldz["PROPERTY_MARKA_ENUM_ID"]]=$arFieldz;
	// $arProps = $ob->GetProperties();
	//print_r($arProps);
}
						//print_r($arFields);
 if (count($arFields)>1) {?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
	<? } else {?><div> <? }
endif;
?>
	<?foreach($arFields as $val2 => $ar2):?>
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
$arFields="";
if (CModule::IncludeModule("iblock")):
$gel=CIBlockElement::GetList(
 Array("PROPERTY_STRANA_VALUE"=>"ASC"),
 Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"],"SECTION_CODE"=>$arParams["gItems"],"INCLUDE_SUBSECTIONS"=>"Y",">CATALOG_QUANTITY"=>0),
 false,
 false,
 Array("ID","PROPERTY_STRANA")
);
while($ob = $gel->GetNextElement()){ 
 $arFieldz = $ob->GetFields();  
$arFields[$arFieldz["PROPERTY_STRANA_ENUM_ID"]]=$arFieldz;
	// $arProps = $ob->GetProperties();
	//print_r($arProps);
}
						//print_r($arFields);

endif;
?><?
 if (count($arFields)>1) {?>
<div  class="filter_name"><?= ($arItem["NAME"]=="Розничная")?"Цена":$arItem["NAME"] ?><br /><br /></div>
<div class="filter_vals">
	<? } else {?><div> <? }?>
	<?foreach($arFields as $val2 => $ar2):?>
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
	<?/*
		<div class="modef" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
			<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
			<a href="<?echo $arResult["FILTER_URL"]?>" class="showchild"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
			<!--<span class="ecke"></span>-->
</div>*/?>

</form>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>
</div>