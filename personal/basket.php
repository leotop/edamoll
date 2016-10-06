<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//mail("sergey@edamoll.ru","test","text_TEST");
$APPLICATION->SetTitle("Корзина");
?><!--Трэкер "Корзина"--> 
<script>document.write('<img src="http://mixmarket.biz/tr.plx?e=3779415&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'" width="1" height="1"/>');</script> 
<!--Трэкер "Корзина"-->

<?
if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"],"utm_source=mixmarket")<>false && strpos($_COOKIE["__utmz"],"utm_medium=cpo")<>false) 
{?>
 <script>
document.write('<img src="http://mixmarket.biz/uni/tev.php?id=1294926071&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'" width="1" height="1"/>');
</script>
<noscript><img src="http://mixmarket.biz/uni/tev.php?id=1294926071" width="1" height="1"/>
</noscript>
<?}?>

<div style="position: relative;" id="cart_area_full"> 
  <div class="basket"> 
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
  
?> <?$APPLICATION->IncludeComponent("bitrix:eshop.sale.basket.basket", "edamoll_basket_NEW", array(
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"COLUMNS_LIST" => array(
		0 => "NAME",
		1 => "PRICE",
		2 => "DISCOUNT",
		3 => "QUANTITY",
		4 => "DELETE",
		5 => "DELAY",
	),
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
	),
	false
);?>

 </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
