<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bot" style="text-align:center;">
<?
if ($arResult["FORM_TYPE"] == "login"):
?>
	<a href="<?=$arResult["AUTH_URL"]?>" class="pinktext undrln" onclick='var modalH = $("#login").height(); $("#login").css({"display":"block","margin-top":"-"+(parseInt(modalH)/2)+"px" });$("#dark").css("display","block"); return false;'>Войти</a><br /><br />
<?
	if($arResult["NEW_USER_REGISTRATION"] == "Y")
	{
?>
	<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" class="pinktext undrln" onclick='var modalH = $("#ed_reg").height(); $("#ed_reg").css({"display":"block","margin-top":"-"+(parseInt(modalH)/2)+"px" });$("#dark").css("display","block"); return false;'>Регистрация</a>
<?
	}
?>
<?
else:
?>
	<a href="<?=$arResult['PROFILE_URL']?>" class="pinktext undrln"><?/*
	$name = trim($USER->GetFullName());
	if (strlen($name) <= 0)
		$name = $USER->GetLogin();

	echo htmlspecialcharsEx($name);*/
	?>Личный кабинет</a><br />
	<a href="<?=$APPLICATION->GetCurPageParam("logout=yes", Array

("logout"))?>" class="pinktext undrln">Выйти</a>
<?
endif;
?>
</div>