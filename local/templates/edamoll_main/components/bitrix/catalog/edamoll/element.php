<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die();
define("NOINDEX_MENU", "Y");
?>
<div>
  <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "template1", Array(
                                                                          "START_FROM" => "0",
                                                                          // Номер пункта, начиная с которого будет построена навигационная цепочка
                                                                          "PATH" => "",
                                                                          // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                                                                          "SITE_ID" => "-",
                                                                          // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                                                                     ), false);?>
</div>
<?$ElementID = $APPLICATION->IncludeComponent("bitrix:catalog.element", "", Array(
                                                                                 "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                                                                 "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                                                                 "PROPERTY_CODE" => $arParams["DETAIL_PROPERTY_CODE"],
                                                                                 "META_KEYWORDS" => $arParams["DETAIL_META_KEYWORDS"],
                                                                                 "META_DESCRIPTION" => $arParams["DETAIL_META_DESCRIPTION"],
                                                                                 "BROWSER_TITLE" => $arParams["DETAIL_BROWSER_TITLE"],
                                                                                 "BASKET_URL" => $arParams["BASKET_URL"],
                                                                                 "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                                                                 "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                                                                 "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                                                                 "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                                                                                 "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                                                                                 "CACHE_TYPE" => "N",
                                                                                 //$arParams["CACHE_TYPE"],
                                                                                 "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                                                 "CACHE_GROUPS" => "N",
                                                                                 //$arParams["CACHE_GROUPS"],
                                                                                 "SET_TITLE" => $arParams["SET_TITLE"],
                                                                                 "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                                                                                 "PRICE_CODE" => $arParams["PRICE_CODE"],
                                                                                 "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                                                                 "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                                                                                 "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                                                                 "PRICE_VAT_SHOW_VALUE" => $arParams["PRICE_VAT_SHOW_VALUE"],
                                                                                 "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                                                                 "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
                                                                                 "LINK_IBLOCK_TYPE" => $arParams["LINK_IBLOCK_TYPE"],
                                                                                 "LINK_IBLOCK_ID" => $arParams["LINK_IBLOCK_ID"],
                                                                                 "LINK_PROPERTY_SID" => $arParams["LINK_PROPERTY_SID"],
                                                                                 "LINK_ELEMENTS_URL" => $arParams["LINK_ELEMENTS_URL"],

                                                                                 "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                                                                                 "OFFERS_FIELD_CODE" => $arParams["DETAIL_OFFERS_FIELD_CODE"],
                                                                                 "OFFERS_PROPERTY_CODE" => $arParams["DETAIL_OFFERS_PROPERTY_CODE"],
                                                                                 "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                                                                                 "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],

                                                                                 "ELEMENT_ID" => $arResult["VARIABLES"]["ELEMENT_ID"],
                                                                                 "ELEMENT_CODE" => $arResult["VARIABLES"]["ELEMENT_CODE"],
                                                                                 "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                                                                                 "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                                                                                 "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                                                                                 "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                                                                                 'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                                                                 'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                                                                 'USE_ELEMENT_COUNTER' => $arParams['USE_ELEMENT_COUNTER'],
                                                                            ), $component);?>
<? if ($arParams["USE_REVIEW"] == "Y" && IsModuleInstalled("forum") && $ElementID): ?>
  <br/>
  <?
  $APPLICATION->IncludeComponent("bitrix:forum.topic.reviews", "", Array(
                                                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                                        "MESSAGES_PER_PAGE" => $arParams["MESSAGES_PER_PAGE"],
                                                                        "USE_CAPTCHA" => $arParams["USE_CAPTCHA"],
                                                                        "PATH_TO_SMILE" => $arParams["PATH_TO_SMILE"],
                                                                        "FORUM_ID" => $arParams["FORUM_ID"],
                                                                        "URL_TEMPLATES_READ" => $arParams["URL_TEMPLATES_READ"],
                                                                        "SHOW_LINK_TO_FORUM" => $arParams["SHOW_LINK_TO_FORUM"],
                                                                        "ELEMENT_ID" => $ElementID,
                                                                        //		"MESSAGES_PER_PAGE" => 2,
                                                                        "PAGE_NAVIGATION_TEMPLATE" => "",
                                                                        "SHOW_AVATAR" => "N",
                                                                        "SHOW_RATING" => "N",
                                                                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                                                        "AJAX_POST" => $arParams["REVIEW_AJAX_POST"],
                                                                        "POST_FIRST_MESSAGE" => $arParams["POST_FIRST_MESSAGE"],
                                                                        "URL_TEMPLATES_DETAIL" => $arParams["POST_FIRST_MESSAGE"] === "Y" ?
                                                                              $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"] :
                                                                              "",
                                                                   ), $component);?>
<? endif ?>
<? if ($arParams["USE_ALSO_BUY"] == "Y" && IsModuleInstalled("sale") && $ElementID): ?>

  <?$APPLICATION->IncludeComponent("bitrix:sale.recommended.products", ".default", array(
                                                                                        "ID" => $ElementID,
                                                                                        "MIN_BUYES" => $arParams["ALSO_BUY_MIN_BUYES"],
                                                                                        "ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
                                                                                        "LINE_ELEMENT_COUNT" => $arParams["ALSO_BUY_ELEMENT_COUNT"],
                                                                                        "DETAIL_URL" => $arParams["DETAIL_URL"],
                                                                                        "BASKET_URL" => $arParams["BASKET_URL"],
                                                                                        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                                                                                        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                                                                                        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                                                                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                                                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                                                                        "PRICE_CODE" => $arParams["PRICE_CODE"],
                                                                                        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                                                                                        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
                                                                                        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                                                                                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                                                                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                                                                   ), $component);

  ?>
<? endif ?>
<? if ($arParams["USE_STORE"] == "Y" && IsModuleInstalled("catalog") && $ElementID): ?>
  <?$APPLICATION->IncludeComponent("bitrix:catalog.store.amount", ".default", array(
                                                                                   "PER_PAGE" => "10",
                                                                                   "USE_STORE_PHONE" => $arParams["USE_STORE_PHONE"],
                                                                                   "SCHEDULE" => $arParams["USE_STORE_SCHEDULE"],
                                                                                   "USE_MIN_AMOUNT" => $arParams["USE_MIN_AMOUNT"],
                                                                                   "MIN_AMOUNT" => $arParams["MIN_AMOUNT"],
                                                                                   "ELEMENT_ID" => $ElementID,
                                                                                   "STORE_PATH" => $arParams["STORE_PATH"],
                                                                                   "MAIN_TITLE" => $arParams["MAIN_TITLE"],
                                                                              ), $component);?>
<? endif ?>
<br/> <br/>
<?
echo('<div class="clear"></div>');
if (CModule::IncludeModule("iblock"))
  {
    $arProperty1 = array(
      'SROK_GODNOSTI',
      'KHRANENIE',
      'VES',
      'OBEM',
      'BELKI',
      'ZHIRY',
      'UGLEVODY',
    );
    $arProperty2 = array(
      'SROK_GODNOSTI',
      'KHRANENIE',
      'VES',
      'OBEM',
      'BELKI',
      'ZHIRY',
      'UGLEVODY',
      'PROIZVODITEL',
      'KKAL',
      'TARA',
      'MARKA',
      'STRANA',
    );
    $arSelect = Array(
      "ID",
      "NAME",
      "SECTION_ID",
      "DETAIL_PAGE_URL",
      "CATALOG_PRICE_2",
      "XML_ID",
      'PROPERTY_SROK_GODNOSTI',
      'PROPERTY_KHRANENIE',
      'PROPERTY_VES',
      'PROPERTY_OBEM',
      'PROPERTY_BELKI',
      'PROPERTY_ZHIRY',
      'PROPERTY_UGLEVODY',
      'PROPERTY_PROIZVODITEL',
      'PROPERTY_KKAL',
      'PROPERTY_TARA',
      'PROPERTY_MARKA',
      'PROPERTY_STRANA',

    );
    $arFilter = Array(
      "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
      "ID" => $ElementID,

    );
    function CharList($arProperty, $arProps)
      {
        if (!empty($arProperty) && !empty($arProps))
          {
            $prop = array_rand($arProperty);
            $value = ValueProps($arProps[$arProperty[$prop]], false);
            if ($value == "" || iconv("utf-8", "windows-1251", $value) == '<>')
              {
                unset($arProperty[$prop]);
                return CharList($arProperty, $arProps);
              }
            else
              {
                return $prop;
              }
          }
      }

    function ValueProps($Prop, $true = true)
      {
        if (is_array($Prop["VALUE"]))
          return implode("&nbsp;/&nbsp;", $Prop["~VALUE"]);
        else
          {
            $add = "";
            if ($true)
              {
                if (in_array($Prop["CODE"], array(
                                                 'BELKI',
                                                 'ZHIRY',
                                                 'UGLEVODY'
                                            ))
                )
                  {
                    $add = " г";
                  }
                if (in_array($Prop["CODE"], array('KKAL')))
                  {
                    $add = " Ккал";
                  }
              }
            return $Prop["~VALUE"] . $add;
          }
      }

    $arElement = array();
    $res =
       CIBlockElement::GetList(Array("CATALOG_PRICE_2" => "ASC"), $arFilter, false, Array("nTopCount" => 1), $arSelect);
    if ($ob = $res->GetNextElement())
      {
        $arElement = $ob->GetFields();
        $file = $_SERVER["DOCUMENT_ROOT"] . "/include/DetailText/" . $arElement["XML_ID"] . ".php";
        if (!file_exists($file))
          {
            $arProps = $ob->GetProperties();
            $propsss = CharList($arProperty1, $arProps);
            unset($arProperty2[$propsss]);
            $prop2 = CharList($arProperty2, $arProps);
            $RandProp[0]["NAME"] = $arProps[$arProperty1[$propsss]]["NAME"];
            $RandProp[0]["VALUE"] = ValueProps($arProps[$arProperty1[$propsss]]);
            $RandProp[1]["NAME"] = $arProps[$arProperty2[$prop2]]["NAME"];
            $RandProp[1]["VALUE"] = ValueProps($arProps[$arProperty2[$prop2]]);


            //echo "<pre>" . print_r($arElement, 1) . "</pre>";
            if (!empty($arElement))
              {
                $arSelect = Array(
                  "ID",
                  "NAME",
                  "DETAIL_PAGE_URL"
                );
                $arFilter = Array(
                  "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
                  "SECTION_ID" => $arElement["IBLOCK_SECTION_ID"],
                  "INCLUDE_SUBSECTIONS" => "Y",
                  "!ID" => $ElementID,
                  ">CATALOG_QUANTITY" => 0
                );
                $res =
                   CIBlockElement::GetList(Array("RAND" => "ASC"), $arFilter, false, Array("nTopCount" => 2), $arSelect);
                $arLink = array();
                while ($ob = $res->GetNextElement())
                  {
                    $arFields = $ob->GetFields();
                    $arLink[] =
                       "<a class='selected' style='color:#000000' href='" . $arFields["DETAIL_PAGE_URL"] . "'>" . $arFields["NAME"] . "</a>";
                  }

                $arFilter = array(
                  'IBLOCK_ID' => $arElement['IBLOCK_ID'],
                  "ID" => $arElement["IBLOCK_SECTION_ID"]
                ); // выберет потомков без учета активности
                $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'), $arFilter, false, array("NAME"));
                if ($Section = $rsSect->GetNext())
                  {
                    $arSection = $Section;
                  }

                $Str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/include/SeoTextDetail.php");

                $Str = str_replace(array(
                                        "#NAME#",
                                        "#PRICE#",
                                        "#LINK#",
                                        "#LINK1#",
                                        "#SECTION_NAME#",
                                        "#CHARNAME#",
                                        "#CHARVAL#",
                                        "#CHARNAME2#",
                                        "#CHARVAL2#",

                                   ), array(
                                           $arElement["NAME"],
                                           $arElement["CATALOG_PRICE_2"],
                                           $arLink[0],
                                           $arLink[1],
                                           $arSection["NAME"],
                                           $RandProp[0]["NAME"],
                                           $RandProp[0]["VALUE"],
                                           $RandProp[1]["NAME"],
                                           $RandProp[1]["VALUE"],

                                      ), $Str);

                file_put_contents($file, $Str);
              }
          }
        echo file_get_contents($file);
      }
  }
?>
<?$APPLICATION->IncludeComponent("bitrix:sale.viewed.product", "template1", Array(
                                                                                 "VIEWED_COUNT" => "12",
                                                                                 "VIEWED_NAME" => "Y",
                                                                                 "VIEWED_IMAGE" => "Y",
                                                                                 "VIEWED_PRICE" => "Y",
                                                                                 "VIEWED_CURRENCY" => "RUB",
                                                                                 "VIEWED_CANBUY" => "Y",
                                                                                 "VIEWED_CANBUSKET" => "Y",
                                                                                 "VIEWED_IMG_HEIGHT" => "148",
                                                                                 "VIEWED_IMG_WIDTH" => "148",
                                                                                 "BASKET_URL" => "/personal/basket.php",
                                                                                 "ACTION_VARIABLE" => "action",
                                                                                 "PRODUCT_ID_VARIABLE" => "id",
                                                                                 "USE_PRODUCT_QUANTITY" => "Y",
                                                                                 "SET_TITLE" => "N",
                                                                                 "CACHE_TYPE" => "N",
                                                                                 "CACHE_TIME" => "36000000",
                                                                                 "CACHE_GROUPS" => "N",

                                                                            ));
?>
<?

$res =
   CIBlockElement::GetList(Array("SORT" => "ASC"), Array("ID" => $arResult["VARIABLES"]["ELEMENT_ID"]), false, false, Array());
if ($ar_res = $res->GetNext())
  $APPLICATION->AddChainItem($ar_res["NAME"], "");
?>
