<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

?>
<?
global $APPLICATION;
$arr = unserialize($_COOKIE['BITRIX_SM_Izb']);
if(!in_array($_GET['id'],$arr) )
  {
    $arr[] = $_GET['id'];

    $APPLICATION->set_cookie("Izb", serialize($arr), time()+60*60*24*30*12*2);

  }

?>