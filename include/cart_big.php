<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
?> <?
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
/* Addition of the goods in a basket at addition in a basket */
if($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'add'){
    Add2BasketByProductID($_POST["ajaxaddid"], 1, array());
}
/* Goods removal at pressing on to remove in a small basket */
if($_POST["ajaxdeleteid"] && $_POST["ajaxaction"] == 'delete'){
    CSaleBasket::Delete($_POST["ajaxdeleteid"]);
}
/* Changes of quantity of the goods after receipt of inquiry from a small basket */
if($_POST["ajaxbasketcountid"] && $_POST["ajaxbasketcount"] && $_POST["ajaxaction"] == 'update'){
    $arFields = array(
       "QUANTITY" => $_POST["ajaxbasketcount"]
    );
    CSaleBasket::Update($_POST["ajaxbasketcountid"], $arFields);
}
// откладываем
if($_POST["ajaxdelayid"] && $_POST["ajaxaction"] == 'delay'){
    $arFields = array(
       "DELAY" => "Y"
    );
    CSaleBasket::Update($_POST["ajaxdelayid"], $arFields);
}

if($_POST["ajaxundelayid"] && $_POST["ajaxaction"] == 'undelay'){
    $arFields = array(
       "DELAY" => "N"
    );
    CSaleBasket::Update($_POST["ajaxundelayid"], $arFields);
}
  
?> <?$APPLICATION->IncludeComponent(
	"bitrix:eshop.sale.basket.basket",
	"edamoll_basket_NEW",
	Array(
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"COLUMNS_LIST" => array(0=>"NAME",1=>"PRICE",2=>"QUANTITY",3=>"DELETE",4=>"DELAY",5=>"DISCOUNT"),
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"PATH_TO_ORDER" => "/personal/order.php",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	)
);?>

<?
if($_POST["ajaxrefresher"]){
?>
 <script>
$( document ).ready(function() {
ShowBasketItems(2);
});
</script>
<?
}
?>