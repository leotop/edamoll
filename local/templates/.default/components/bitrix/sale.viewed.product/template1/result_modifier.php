<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die(); ?>

<?
foreach ($arResult as $key => $val)
  {
    $img = "";
    if ($val["DETAIL_PICTURE"] > 0)
      $img = $val["DETAIL_PICTURE"];
    elseif ($val["PREVIEW_PICTURE"] > 0)
      $img = $val["PREVIEW_PICTURE"];

    $file =
       CFile::ResizeImageGet($img, array(
                                        'width' => $arParams["VIEWED_IMG_WIDTH"],
                                        'height' => $arParams["VIEWED_IMG_HEIGHT"]
                                   ), BX_RESIZE_IMAGE_PROPORTIONAL, true);

    $val["PICTURE"] = $file;
    if (CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
      {
        $db_props =
           CIBlockElement::GetProperty($val["IBLOCK_ID"], $val["PRODUCT_ID"], array("sort" => "asc"), Array("CODE" => "CML2_BASE_UNIT"));
        if ($ar_props = $db_props->Fetch())
          {
            $val["PROPERTIES"]["CML2_BASE_UNIT"]=$ar_props;
          }
        $arPrice = CCatalogProduct::GetOptimalPrice($val["PRODUCT_ID"], 1, $arGroups, "N", array(),"s1");
        $val["PRICE"]=$arPrice["PRICE"]["PRICE"];
        $val["DISCOUNT_PRICE"]=$arPrice["DISCOUNT_PRICE"];
      }
    $arResult[$key] = $val;
  }
?>