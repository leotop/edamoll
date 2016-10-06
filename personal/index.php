<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<script type="text/javascript">
function LKShowTab(id){
$(".LKhead").removeClass("pinktext");
$(".LKhead").addClass("blacktext");
$("#LKhead"+id).removeClass("blacktext");
$("#LKhead"+id).addClass("pinktext");

$(".LKtab").css("display","none");
$("#LK"+id).css("display","block");
}
</script>
 
<h2>Личный кабинет</h2>
 
<br />
 
<div onclick="LKShowTab('1');" class="pinktext LKhead fll" id="LKhead1">МОИ ДАННЫЕ</div>
 <? if($USER->IsAuthorized()) {?> 
<div onclick="LKShowTab('2');" class="blacktext LKhead fll" id="LKhead2">МОИ ЗАКАЗЫ</div>
 
<div class="blacktext LKhead fll notworking" id="LKhead3">АДРЕСА ДОСТАВКИ</div>
 
<div class="blacktext LKhead fll notworking" id="LKhead4">МОИ БОНУСЫ</div>
 
<div onclick="LKShowTab('5');" class="LKhead fll blacktext" id="LKhead5">ИЗБРАННЫЕ ТОВАРЫ</div>
<?
}
?> 
<div class="clear"></div>
 
<div style="display: block;" id="LK1" class="LKtab"> <?$APPLICATION->IncludeComponent("bitrix:main.profile", "new", Array(
	"AJAX_MODE" => "N",	// Включить режим AJAX
	"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
	"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
	"USER_PROPERTY" => "",	// Показывать доп. свойства
	"SEND_INFO" => "N",	// Генерировать почтовое событие
	"CHECK_RIGHTS" => "N",	// Проверять права доступа
	"USER_PROPERTY_NAME" => "",	// Название закладки с доп. свойствами
	"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
	),
	false
);?> </div>
 <? if($USER->IsAuthorized()) {?> 
<div id="LK2" class="LKtab"> <?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.list", "list_new", Array(
	"PATH_TO_DETAIL" => "",	// Страница c подробной информацией о заказе
	"PATH_TO_COPY" => "",	// Страница повторения заказа
	"PATH_TO_CANCEL" => "",	// Страница отмены заказа
	"PATH_TO_BASKET" => "/personal/basket.php",	// Страница корзины
	"ORDERS_PER_PAGE" => "20",	// Количество заказов, выводимых на страницу
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
	"NAV_TEMPLATE" => "orange",	// Имя шаблона для постраничной навигации
	"ID" => $ID,	// Идентификатор заказа
	),
	false
);?> </div>
  <div id="LK5" class="LKtab">
  <?if(unserialize($_COOKIE['BITRIX_SM_Izb'])):?>

 <?
 $Ids= unserialize($_COOKIE['BITRIX_SM_Izb']);
 ?>
 <? if(count($Ids)>0): ?>
    <h2>ИЗБРАННЫЕ ТОВАРЫ</h2>
<?
//AddDiscontsForSort();
  $gElCount= isset($_GET["el_count"]) ? intval($_GET["el_count"]) : "40";
  global $pageDiscount;
  $pageDiscount='discount';
  $arrFilter["ID"] = unserialize($_COOKIE['BITRIX_SM_Izb']);
  global $SorPagePararms,$SorPagePararmsOrder;
  ?>
   <?$APPLICATION->IncludeComponent("bitrix:catalog.section", "template2", array(
        "IBLOCK_TYPE" => "1c_catalog",
        "IBLOCK_ID" => "11",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "SECTION_USER_FIELDS" => array(
           0 => "",
           1 => "",
        ),
        "ELEMENT_SORT_FIELD" => $SorPagePararms,
        "ELEMENT_SORT_ORDER" => $SorPagePararmsOrder,
        "ELEMENT_SORT_FIELD2" => "id",
        "ELEMENT_SORT_ORDER2" => "desc",
        "FILTER_NAME" => "arrFilter",
        "INCLUDE_SUBSECTIONS" => "Y",
        "SHOW_ALL_WO_SECTION" => "Y",
        "HIDE_NOT_AVAILABLE" => "N",
        "PAGE_ELEMENT_COUNT" =>($_GET["ALL"]==1) ? intval("60") : $gElCount,
        "LINE_ELEMENT_COUNT" => "5",
        "PROPERTY_CODE" => array(
           0 => "CML2_BASE_UNIT",
           1 => "",
        ),
        "OFFERS_LIMIT" => "5",
        "SECTION_URL" => "",
        "DETAIL_URL" => "",
        "BASKET_URL" => "/personal/basket.php",
        "ACTION_VARIABLE" => "action",
        "PRODUCT_ID_VARIABLE" => "id",
        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
        "PRODUCT_PROPS_VARIABLE" => "prop",
        "SECTION_ID_VARIABLE" => "SECTION_ID",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_GROUPS" => "Y",
        "META_KEYWORDS" => "-",
        "META_DESCRIPTION" => "-",
        "BROWSER_TITLE" => "-",
        "ADD_SECTIONS_CHAIN" => "N",
        "DISPLAY_COMPARE" => "N",
        "SET_TITLE" => "Y",
        "SET_STATUS_404" => "N",
        "CACHE_FILTER" => "N",
        "PRICE_CODE" => array(
           0 => "Розничная",
        ),
        "USE_PRICE_COUNT" => "N",
        "SHOW_PRICE_COUNT" => "1",
        "PRICE_VAT_INCLUDE" => "Y",
        "PRODUCT_PROPERTIES" => array(
        ),
        "USE_PRODUCT_QUANTITY" => "Y",
        "CONVERT_CURRENCY" => "N",
        "QUANTITY_FLOAT" => "Y",
        "DISPLAY_TOP_PAGER" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "PAGER_TITLE" => "пїЅпїЅпїЅпїЅпїЅпїЅ",
        "PAGER_SHOW_ALWAYS" => "Y",
        "PAGER_TEMPLATE" =>  ($_GET["ALL"]==1) ? "inviz_search" :  "edamoll",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "AJAX_OPTION_ADDITIONAL" => ""
     ),
     false
  );?>
 <? else: ?>
      <h2>У вас нет избранных товаров</h2>
  <? endif ?>
  <? else: ?>
  <h2>У вас нет избранных товаров</h2>
  <? endif ?>
<?
}
?> </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>