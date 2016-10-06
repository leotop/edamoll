<? if($_GET["SHOW_SORT"]!=1): ?>
<span>—ортировать по:</span>
<?
global $SorPagePararms,$SorPagePararmsOrder;
$sort="";
if($SorPagePararmsOrder=="asc")
  {
    $sort="&BY=DESC";
  }
?>
<a rel="nofollow"  <? if($SorPagePararms == "PROPERTY_RATING"): ?> onclick="return false;" style="color: #999999;cursor: text;"  <? endif ?>  href="<?= $APPLICATION->GetCurPageParam("SORT=RATING&BY=DESC", array("SORT","BY")); ?>">попул€рности</a>&nbsp;|
<a rel="nofollow"  <? if($SorPagePararms == "CATALOG_PRICE_2"): ?>style="color: #999999"<? endif ?> href="<?= $APPLICATION->GetCurPageParam("SORT=PRICE".$sort, array("SORT","BY")); ?>" >цене</a>&nbsp;|
<a rel="nofollow" <? if($SorPagePararms == "PROPERTY_DISCOUNTS"): ?> onclick="return false;" style="color: #999999;cursor: text;"  <? endif ?> href="<?= $APPLICATION->GetCurPageParam("SORT=DISCOUNT&BY=DESC", array("SORT","BY")); ?>">скидке</a>&nbsp;&nbsp;
<? if($SorPagePararms!="SORT"): ?><a rel="nofollow"  href="<?= $APPLICATION->GetCurPageParam("".$sort, array("SORT","BY")); ?>">сбросить</a><? endif ?>
<? endif ?>