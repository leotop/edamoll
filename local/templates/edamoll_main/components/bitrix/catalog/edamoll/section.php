<? 
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
        die(); 
    }
?>
<div class="sidebar">
    <?
        $APPLICATION->IncludeFile(SITE_DIR."include/discount.php", array(), array("MODE" => "html"));
    ?>
    <div class="edamoll_menu_left">
        <?
            $pictline = "";
            $rsParentSection = CIBlockSection::GetList(
                array('left_margin' => 'asc'), 
                array('CODE' => $arResult["VARIABLES"]["SECTION_CODE"])
            );

            if ($arParentSection = $rsParentSection->GetNext()) {
                if ($arParentSection['DEPTH_LEVEL'] == 1) {
                ?>
                <div class="item-text">
                    <a class="pinktext"
                        href="<?= $arParentSection['SECTION_PAGE_URL']; ?>"><?=$arParentSection['NAME'];?>
                    </a>
                </div>
                <?
                    $arFilter = array(
                        'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                        '>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],
                        '<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],
                        'DEPTH_LEVEL' => 2
                    );
                    $rsSect = CIBlockSection::GetList(
                        array('left_margin' => 'asc'), 
                        $arFilter
                    );
                    while ($arSect = $rsSect->GetNext()) { 
                        $sectionElementsCount = CIBlockSection::GetSectionElementsCount(
                            $arSect["ID"],
                            array()
                        );
                        if (intval($sectionElementsCount) != 0) {
                            $big_picture = CFile::GetPath($arSect["PICTURE"]);
                            if ($big_picture <> "") {
                                $pictline .= '<div class="pict_cont"><a href="'.$arSect['SECTION_PAGE_URL'].'"><div class="picto" style="background-image:url('.
                                $big_picture.')"></div><div class="pict_name">'.$arSect['NAME'].'</div></a></div>';
                            }                   

                        ?>
                        <div class="item-text"> 
                            <a href="<?=$arSect['SECTION_PAGE_URL'];?>"><?=$arSect['NAME'];?></a>
                        </div>
                        <?
                        }
                    }
                }

                if ($arParentSection['DEPTH_LEVEL'] == 2) {
                    $arFilter = array(
                        'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                        '<LEFT_BORDER' => $arParentSection['LEFT_MARGIN'],
                        '>RIGHT_BORDER' => $arParentSection['RIGHT_MARGIN'],
                        'DEPTH_LEVEL' => 1
                    );
                    $rsSect = CIBlockSection::GetList(
                        array('left_margin' => 'asc'), 
                        $arFilter
                    );
                    if ($arSect = $rsSect->GetNext()) {
                    ?>
                    <div class="item-text">
                        <a class="blacktext" href="<?=$arSect['SECTION_PAGE_URL'];?>"><?=$arSect['NAME'];?></a>
                    </div>
                    <?
                        $arFilter2 = array(
                            'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                            '>LEFT_MARGIN' => $arSect['LEFT_MARGIN'],
                            '<RIGHT_MARGIN' => $arSect['RIGHT_MARGIN'],
                            'DEPTH_LEVEL' => 2
                        );
                        $rsSect2 = CIBlockSection::GetList(
                            array('left_margin' => 'asc'), 
                            $arFilter2
                        );

                        while ($arSect2 = $rsSect2->GetNext()) {
                            $gact = "";
                            if ($arResult["VARIABLES"]["SECTION_CODE"] == $arSect2["CODE"]) {
                                $gact = " pictact";
                            }
                            $big_picture = CFile::GetPath($arSect2["PICTURE"]);
                            if ($big_picture <> "") {
                                $pictline .= '<div class="pict_cont"><a href="'.$arSect2['SECTION_PAGE_URL'].'"><div class="picto'.
                                $gact.'" style="background-image:url('.$big_picture.')"> </div><div class="pict_name">'.$arSect2['NAME'].'</div></a></div>';
                            }
                        }
                        $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "", array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_CODE" => $arSect["CODE"],
                            "G_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "G_SECTION_CODE2" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                            "TOP_DEPTH" => 2,
                            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                            ), $component);
                    }
                }

                if ($arParentSection['DEPTH_LEVEL'] == 3) {
                    $arFilter = array(
                        'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                        '<LEFT_BORDER' => $arParentSection['LEFT_MARGIN'],
                        '>RIGHT_BORDER' => $arParentSection['RIGHT_MARGIN'],
                        'DEPTH_LEVEL' => 1
                    );
                    $rsSect = CIBlockSection::GetList(
                        array('left_margin' => 'asc'), 
                        $arFilter
                    );
                    if ($arSect = $rsSect->GetNext()) {
                        $g_code = "";
                        $arFilter2 = array(
                            'IBLOCK_ID' => $arParentSection['IBLOCK_ID'],
                            '<LEFT_BORDER' => $arParentSection['LEFT_MARGIN'],
                            '>RIGHT_BORDER' => $arParentSection['RIGHT_MARGIN'],
                            'DEPTH_LEVEL' => 2
                        );
                        $rsSect2 = CIBlockSection::GetList(
                            array('left_margin' => 'asc'), 
                            $arFilter2
                        );
                        if ($arSect2 = $rsSect2->GetNext()) {
                            $g_code = $arSect2["CODE"];
                        }
                    ?>
                    <div class="item-text">
                        <a class="blacktext" href="<?=$arSect['SECTION_PAGE_URL'];?>"><?=$arSect['NAME'];?></a>
                    </div>
                    <?
                        $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "", array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_CODE" => $arSect["CODE"],
                            "G_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "G_SECTION_CODE2" => $g_code,
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                            "TOP_DEPTH" => 2,
                            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
                            ), $component);
                    }
                }
            }
        ?>
    </div>
    <? 
        if ($arParams["USE_FILTER"] == "Y" && $arResult["VARIABLES"]["SECTION_CODE"] <> "produkty") {
            $APPLICATION->IncludeComponent("bitrix:catalog.filter", "new_fltr", array(
                "IBLOCK_TYPE" => "1c_catalog",
                "IBLOCK_ID" => "11",
                "gItems" => $arResult["VARIABLES"]["SECTION_CODE"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "FIELD_CODE" => array( 
                    0 => "",
                    1 => "",
                    2 => "",
                ),
                "PROPERTY_CODE" => array(
                    0 => "MARKA",
                    1 => "STRANA",
                    2 => "KKAL",
                    3 => "",
                    4 => "",
                    5 => "",
                ),
                "LIST_HEIGHT" => "5",
                "TEXT_WIDTH" => "20",
                "NUMBER_WIDTH" => "5",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => "N",
                "SAVE_IN_SESSION" => "N",
                "PRICE_CODE" => array(
                    0 => "Розничная",
                )
                ), false);
        ?>
        <br/>
        <? } ?>
</div>

<div class="workarea_small">

    <? 
        if ($pictline <> "") {
        ?>
        <div class="pictos">
            <?=$pictline?>
        </div>
        <div class="clear">
        </div>
        <?
        }
        $APPLICATION->IncludeComponent("bitrix:breadcrumb", "template1", array(
            "START_FROM" => "0",
            "PATH" => "",
            "SITE_ID" => "s1",
            ), false);
    ?>
    <h3>
        <?=$arResult["VARIABLES"]["NAME"]?>
    </h3>
    <? 
        if ($arParams["USE_COMPARE"] == "Y"){ 
            $APPLICATION->IncludeComponent("bitrix:catalog.compare.list", "", array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "NAME" => $arParams["COMPARE_NAME"],
                "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
                "COMPARE_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["compare"],
                ), $component);
        ?>
        <br/>
        <?
        }
        $gElCount = isset($_GET["el_count"]) ? intval($_GET["el_count"]) : $arParams["PAGE_ELEMENT_COUNT"];
        global $SorPagePararms, $SorPagePararmsOrder, $arFilter;
        $arFilter[">CATALOG_QUANTITY"] = 0;
        $APPLICATION->IncludeComponent("bitrix:catalog.section", "", array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $SorPagePararms,
            "ELEMENT_SORT_ORDER" => $SorPagePararmsOrder,
            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "CACHE_TYPE" => "N",
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => "N",
            "SET_TITLE" => $arParams["SET_TITLE"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT" => ($_GET["ALL"] == 1) ?
            intval("60") : $gElCount,
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => ($_GET["ALL"] == 1) ? "ajax" :
            $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
            "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            "ADD_SECTIONS_CHAIN" => "Y",
            ), $component);

        if(empty($_GET)) {
            if (CModule::IncludeModule("iblock") && $arResult["VARIABLES"]["SECTION_CODE"] != "") {
                $Count = 0;
                $MIN_PRICE = 0;
                $MAX_PRICE = 0;
                $arLink = array();
                $arFilter = array(
                    'IBLOCK_ID' => IntVal($arParams["IBLOCK_ID"]),
                    "CODE" => $arResult["VARIABLES"]["SECTION_CODE"] 
                );
                $rsSect = CIBlockSection::GetList(
                    array(),
                    $arFilter,
                    false
                );
                if ($arSect = $rsSect->GetNext()) {
                    $arSection=$arSect;
                }
                $arSelect = array(
                    "ID",
                    "NAME",
                    "DETAIL_PAGE_URL"
                );
                $arFilter = array(
                    "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "INCLUDE_SUBSECTIONS" => "Y",
                    ">CATALOG_QUANTITY" => 0
                );
                $res = CIBlockElement::GetList(
                    array("RAND" => "ASC"), 
                    $arFilter, 
                    false, 
                    array("nTopCount" => 2), 
                    $arSelect);
                $arLink = array();
                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    $arLink[] = "<a class='selected' style='color:#000000' href='".$arFields["DETAIL_PAGE_URL"]."'>".$arFields["NAME"]."</a>";
                }
                $arSelect = array(
                    "ID",
                );
                $arFilter = array(
                    "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "INCLUDE_SUBSECTIONS" => "Y",
                );
                $res = CIBlockElement::GetList(
                    array(), 
                    $arFilter, 
                    false, 
                    false, 
                    $arSelect
                );
                $Count = $res->SelectedRowsCount();
                $arSelect = Array(
                    "ID",
                    "NAME",
                    "CATALOG_PRICE_2"
                );
                $arFilter = Array(
                    "IBLOCK_ID" => IntVal($arParams["IBLOCK_ID"]),
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "INCLUDE_SUBSECTIONS" => "Y",
                    ">CATALOG_QUANTITY" => 0
                );
                $res = CIBlockElement::GetList(
                    array("CATALOG_PRICE_2" => "ASC"), 
                    $arFilter, 
                    false, 
                    array("nTopCount" => 1), 
                    $arSelect
                );
                if ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    $MIN_PRICE = intval($arFields["CATALOG_PRICE_2"]);
                }
                $res = CIBlockElement::GetList(
                    array("CATALOG_PRICE_2" => "DESC"), 
                    $arFilter, 
                    false, 
                    array("nTopCount" => 1), 
                    $arSelect
                );
                if ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    $MAX_PRICE = intval($arFields["CATALOG_PRICE_2"]);
                }
                if (!empty($arLink) && $Count > 0 && $MIN_PRICE > 0 && $MAX_PRICE > 0) {
                    $Str = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/include/SeoText.php");
                    $Str =
                    str_replace(array(
                        "#LINK#",
                        "#LINK1#",
                        "#COUNT#",
                        "#MIN_PRICE#",
                        "#MAX_PRICE#",
                        "#NAME#"
                        ), array(
                            $arLink[0],
                            $arLink[1],
                            $Count,
                            $MIN_PRICE,
                            $MAX_PRICE,
                            $arSection["NAME"],
                        ), $Str);
                    echo($Str . "<br /><br />");
                }

            }

            $APPLICATION->IncludeFile(SITE_DIR . "include/" . $arResult["VARIABLES"]["SECTION_CODE"] . ".php", Array(), Array(
                "MODE" => "html",
                "NAME" => " включаемую область раздела",
                "TEMPLATE" => "empty.php"
            ));

        } 
    ?>
</div>
