<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>



	<?if($arResult["AUTH_SERVICES"]): /*?>
		<p class="tal"><strong><?echo GetMessage("AUTH_TITLE")?></strong></p>
<? */ endif?>
<div class="soc_net_div">
	<?
	ShowMessage($arParams["~AUTH_RESULT"]);
	ShowMessage($arResult['ERROR_MESSAGE']);
	?>
		<?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
			array(
				"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
				"CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
				"AUTH_URL"=>$arResult["AUTH_URL"],
				"POST"=>$arResult["POST"],
			),
			$component,
			array("HIDE_ICONS"=>"Y")
		);?>
</div>

