<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

?>
<?
CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");
if ($_GET["q"] != ""):
    $arSection = array();
    $arFilter =
       array(
         'IBLOCK_ID' => 11,
         "%NAME" => urldecode($_GET["q"])
       ); // выберет потомков без учета активности

    $rsSect =
       CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter, false, array(
                                                                                     "SECTION_PAGE_URL",
                                                                                     "NAME"
                                                                                ));
    while ($arSect = $rsSect->GetNext())
      {
        $arSection[] = $arSect;
      }
    $arElements=array();
    $arSelect = Array("ID","SORT","NAME");
    $arFilter =array(
      "IBLOCK_ID"=>17,"%NAME"=> strtolower(urldecode($_GET["q"]))
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false,  $arSelect);
    while($arElement = $res->GetNext())
      {
        $arElements[] = $arElement;
      }
    ?>

    <div class="search_suggest"><!--?xml version="1.0"?-->
      <div class="container">
    <? if (count($arElements) > 0): ?>

    <div class="requests">
          <div class="head">Популярные запросы</div>
          <div class="samples">
      <? foreach ($arElements as $arItem): ?>
            <div class="item searclinl" rel="<?= $arItem["NAME"] ?>"><span class="suggest"><?= $arItem["NAME"] ?></span><span class="result">
                                            около <?= $arItem["SORT"] ?><span>товаров</span></span></div>
      <? endforeach ?>

          </div>
        </div>
    <? endif ?>

        <? if (count($arSection) > 0): ?>
          <div class="catalogs">
            <div class="head">Разделы</div>
            <div class="catalogs">
              <? foreach ($arSection as $arItem): ?>
                <div class="item"><a class="suggest" href="<?= $arItem["SECTION_PAGE_URL"] ?>"
                                     id="7_value"><?= $arItem["NAME"] ?></a></div>
              <? endforeach ?>
            </div>
          </div>
        <? endif ?>
      </div>
    </div>

  <? endif ?>