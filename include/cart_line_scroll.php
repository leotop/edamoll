<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
 $APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.small",
	"edamoll_small_basket_scroll",
	Array(
		"PATH_TO_BASKET" => "/personal/basket.php",
		"PATH_TO_ORDER" => "/personal/order.php"
	)
);?>