<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="subscribe_form_container">
<div class="subscribe_form_text">
Подпишитесь на наши рекламные рассылки
</div>
<div class="subscribe-form">
<form action="<?=$arResult["FORM_ACTION"]?>">
<div class="chkbox">
<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
	<label for="sf_RUB_ID_<?=$itemValue["ID"]?>">
	<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>" checked/> <?=$itemValue["NAME"]?>
	</label><br />
<?endforeach;?>
	</div>
	<table border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td><input id="subscribe_form_email" type="text" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" /></td>
			<td align="right"><input id="subscribe_form_btn" type="submit" name="OK" value="ОК" /></td>
		</tr>
	</table>
</form>
</div>
</div>
