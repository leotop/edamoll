<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

?> <?
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
/* Addition of the goods in a basket at addition in a basket */

if($_POST["ajaxaddid"] && $_POST["ajaxaction"] == 'add' && $_POST["ajaxaddq"]){
    Add2BasketByProductID($_POST["ajaxaddid"], $_POST["ajaxaddq"], array());
	echo($_POST["ajaxaddid"]." ". $_POST["ajaxaddq"]);
}


if($_POST["ajaxadddelid"] && $_POST["ajaxaction"] == 'adddel'&& $_POST["ajaxadddelq"]){
    Add2BasketByProductID($_POST["ajaxadddelid"], $_POST["ajaxadddelq"], array("DELAY"=>"Y"),array());

}

?>