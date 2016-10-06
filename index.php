<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
    $APPLICATION->SetPageProperty("keywords", "Доставка продуктов, купить продукты питания, доставка продуктов питания, продукты питания на дом, Едамол, Едамолл, edamol, edamoll");
    $APPLICATION->SetTitle("Edamoll - интернет супермаркет, доставка продуктов питания на дом по Москве и Московской области.");
?>
<?
    if ($_SERVER["REQUEST_URI"]=="/" || substr($_SERVER["REQUEST_URI"],0,2)=="/?" || substr($_SERVER["REQUEST_URI"],0,10)=="/index.php" 
        || $_SERVER["REQUEST_URI"]=="/bitrix/urlrewrite.php") {
    ?>
    <div class="sidebar">	 		 
        <div id="left-menu">
            <?
                $APPLICATION->IncludeComponent("bitrix:menu", "edamoll_left_menu",
                    array(
                        "ROOT_MENU_TYPE" => "left",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "36000000",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => array()
                    ),
                    false,
                    array('ACTIVE_COMPONENT' => 'Y')
                );
            ?> 			
        </div>
    </div>

    <div class="workarea_small"> 
        <script type="text/javascript">
            var hwSlideSpeed = 700;
            var hwTimeOut = 3000;
            var hwNeedLinks = true;

            $(document).ready(function(e) {
                $('.slide').css(
                    {"position" : "absolute",
                        "top":'0', "left": '0'}).hide().eq(0).show();
                var slideNum = 0;
                var slideTime;
                slideCount = $("#slider .slide").size();
                var animSlide = function(arrow){
                    clearTimeout(slideTime);
                    $('.slide').eq(slideNum).fadeOut(hwSlideSpeed);
                    if(arrow == "next"){
                        if(slideNum == (slideCount-1)){slideNum=0;}
                        else{slideNum++}
                    }
                    else if(arrow == "prew")
                    {
                        if(slideNum == 0){slideNum=slideCount-1;}
                        else{slideNum-=1}
                    }
                    else{
                        slideNum = arrow;
                    }
                    $('.slide').eq(slideNum).fadeIn(hwSlideSpeed, rotator);
                    $(".control-slide.active").removeClass("active");
                    $('.control-slide').eq(slideNum).addClass('active');
                }
                if(hwNeedLinks){
                    var $linkArrow = $('<span id="prewbutton" ></span><span id="nextbutton"  ></span>')
                    .prependTo('#slider');     
                    $('#nextbutton').click(function(){
                        animSlide("next");

                    })
                    $('#prewbutton').click(function(){
                        animSlide("prew");
                    })
                }
                var $adderSpan = '';
                $('.slide').each(function(index) {
                    $adderSpan += '<span class = "control-slide">' + index + '</span>';
                });
                $('<div class ="sli-links">' + $adderSpan +'</div>').appendTo('#slider-wrap');
                $(".control-slide:first").addClass("active");

                $('.control-slide').click(function(){
                    var goToNum = parseFloat($(this).text());
                    animSlide(goToNum);
                });
                var pause = false;
                var rotator = function(){
                    if(!pause){slideTime = setTimeout(function(){animSlide('next')}, hwTimeOut);}
                }
                $('#slider-wrap').hover(   
                    function(){clearTimeout(slideTime); pause = true;},
                    function(){pause = false; rotator();
                });
                rotator();
            });
        </script>

        <div id="slider-wrap"> 
            <div id="slider"> 
                <div class="slide"><a href="http://edamoll.ru/ovoshchi_frukty_yagody/" ><img id="bxid_404854" src="/images/3.png" width="829" height="312"  /> </a></div>
                <div class="slide"><a href="http://edamoll.ru/myaso/" ><img id="bxid_404854" src="/images/4.png" width="829" height="312"  /> </a></div>
            </div>
        </div> 

        <p>
            <?
                $APPLICATION->IncludeComponent(
                    "bitrix:eshop.catalog.top",
                    "edamoll_catalog_top",
                    Array(
                        "IBLOCK_TYPE_ID" => "1c_catalog",
                        "IBLOCK_ID" => "11",
                        "ELEMENT_SORT_FIELD" => "sort",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "ELEMENT_COUNT" => "10",
                        "FLAG_PROPERTY_CODE" => "SALELEADERS",
                        "OFFERS_LIMIT" => "5",
                        "ACTION_VARIABLE" => "action",
                        "PRODUCT_ID_VARIABLE" => "id_top",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_GROUPS" => "Y",
                        "DISPLAY_COMPARE" => "N",
                        "PRICE_CODE" => array(0=>"Розничная",),
                        "USE_PRICE_COUNT" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRODUCT_PROPERTIES" => array(),
                        "CONVERT_CURRENCY" => "N",
                        "DISPLAY_IMG_WIDTH" => "148",
                        "DISPLAY_IMG_HEIGHT" => "148",
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "USE_PRODUCT_QUANTITY" => "Y",
                        "SHARPEN" => "80"
                    ),
                    false,
                    Array(
                        'ACTIVE_COMPONENT' => 'Y'
                    )
                );
            ?>
        </p>
        <?
            $APPLICATION->IncludeFile(
                SITE_DIR."include/main_page_text.php",
                Array(),
                Array("MODE"=>"html")
            );
        ?> 
    </div>
    <?
    } else {    
        if ($_SERVER["REQUEST_URI"]=="/produkty_pitaniya" || $_SERVER["REQUEST_URI"]=="/produkty_pitaniya/") {
            LocalRedirect("/produkty/");
        }
        if (!strpos($_SERVER["REQUEST_URI"],"?")===false) { 
            $gg_str=substr($_SERVER["REQUEST_URI"],1,strpos($_SERVER["REQUEST_URI"],"?")-1);
        } else {
            $gg_str=substr($_SERVER["REQUEST_URI"],1);
        }
        CModule::IncludeModule("iblock");

        $resss = CIBlockSection::GetList(
            Array("SORT"=>"ASC"),
            Array("CODE"=>$gg_str),
            false,
            Array(),
            false
        );

        if ($ar_res = $resss->GetNext()) {
            if (isset($_GET["from"])) {
                LocalRedirect("$gg_str"."/"."?from=".$_GET["from"]);
            } else{
                LocalRedirect("$gg_str"."/");
            }
        }

        if (substr($_SERVER["REQUEST_URI"],0,6)=="/item/" && strlen($_SERVER["REQUEST_URI"])>7) {
            if (!strpos($_SERVER["REQUEST_URI"],"/",7)===false) {
                $gg_str=substr($_SERVER["REQUEST_URI"],6,strpos($_SERVER["REQUEST_URI"],"/",7)-6);
                /*
                if (!strpos($gg_str,"?")===false)
                {$gg_str=substr($_SERVER["REQUEST_URI"],1,strpos($_SERVER["REQUEST_URI"],"?")-1);}
                */
                $resss = CIBlockElement::GetList(
                    Array("SORT"=>"ASC"),
                    Array("ID"=>$gg_str),
                    false,
                    false,
                    Array()
                );

                if($ar_res = $resss->GetNext() && $gg_str<>"/" && $gg_str<>"") {
                    if (isset($_GET["from"])) {
                        LocalRedirect("/item/"."$gg_str"."?from=".$_GET["from"]);
                    } else {
                        LocalRedirect("/item/"."$gg_str");
                    }
                }
            }
        }

        $APPLICATION->IncludeComponent(
            "bitrix:catalog", 
            "edamoll", 
            array(
                "IBLOCK_TYPE" => "1c_catalog",
                "IBLOCK_ID" => "11",
                "HIDE_NOT_AVAILABLE" => "Y",
                "BASKET_URL" => "",
                "ACTION_VARIABLE" => "action",
                "PRODUCT_ID_VARIABLE" => "id",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "SEF_MODE" => "Y",
                "SEF_FOLDER" => "/",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "Y",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "36000000",
                "CACHE_FILTER" => "Y",
                "CACHE_GROUPS" => "Y",
                "SET_TITLE" => "Y",
                "SET_STATUS_404" => "Y",
                "USE_ELEMENT_COUNTER" => "Y",
                "USE_FILTER" => "Y",
                "FILTER_NAME" => "arFilter",
                "FILTER_FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "FILTER_PROPERTY_CODE" => array(
                    0 => "MARKA",
                    1 => "",
                ),
                "FILTER_PRICE_CODE" => array(
                    0 => "Розничная",
                ),
                "USE_REVIEW" => "N",
                "MESSAGES_PER_PAGE" => "3",
                "USE_CAPTCHA" => "N",
                "REVIEW_AJAX_POST" => "Y",
                "PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
                "FORUM_ID" => "1",
                "URL_TEMPLATES_READ" => "",
                "SHOW_LINK_TO_FORUM" => "N",
                "POST_FIRST_MESSAGE" => "N",
                "USE_COMPARE" => "N",
                "PRICE_CODE" => array(
                    0 => "Розничная",
                ),
                "USE_PRICE_COUNT" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "PRICE_VAT_INCLUDE" => "N",
                "PRICE_VAT_SHOW_VALUE" => "N",
                "PRODUCT_PROPERTIES" => array(
                ),
                "USE_PRODUCT_QUANTITY" => "Y",
                "CONVERT_CURRENCY" => "N",
                "QUANTITY_FLOAT" => "N",
                "SHOW_TOP_ELEMENTS" => "N",
                "SECTION_COUNT_ELEMENTS" => "N",
                "SECTION_TOP_DEPTH" => "2",
                "PAGE_ELEMENT_COUNT" => "40",
                "LINE_ELEMENT_COUNT" => "5",
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_ORDER" => "asc",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER2" => "desc",
                "LIST_PROPERTY_CODE" => array(
                    0 => "SALELEADERS",
                    1 => "MARKA",
                    2 => "PROIZVODITEL",
                    3 => "KRASITELI",
                    4 => "KHRANENIE",
                    5 => "PITANIE",
                    6 => "OBEM",
                    7 => "TARA",
                    8 => "STRANA",
                    9 => "VITAMINY",
                    10 => "KKAL",
                    11 => "BELKI",
                    12 => "ZHIRY",
                    13 => "UGLEVODY",
                    14 => "GOST",
                    15 => "VOZRAST",
                    16 => "SROK_GODNOSTI",
                    17 => "VES",
                    18 => "",
                ),
                "INCLUDE_SUBSECTIONS" => "A",
                "LIST_META_KEYWORDS" => "-",
                "LIST_META_DESCRIPTION" => "-",
                "LIST_BROWSER_TITLE" => "UF_PAGETITLE",
                "DETAIL_PROPERTY_CODE" => array(
                    0 => "SALELEADERS",
                    1 => "MARKA",
                    2 => "PROIZVODITEL",
                    3 => "KRASITELI",
                    4 => "CML2_BASE_UNIT",
                    5 => "KHRANENIE",
                    6 => "PITANIE",
                    7 => "OBEM",
                    8 => "TARA",
                    9 => "STRANA",
                    10 => "VITAMINY",
                    11 => "KKAL",
                    12 => "BELKI",
                    13 => "ZHIRY",
                    14 => "UGLEVODY",
                    15 => "GOST",
                    16 => "VOZRAST",
                    17 => "SROK_GODNOSTI",
                    18 => "VES",
                    19 => "",
                ),
                "DETAIL_META_KEYWORDS" => "-",
                "DETAIL_META_DESCRIPTION" => "-",
                "DETAIL_BROWSER_TITLE" => "pagetitle",
                "LINK_IBLOCK_TYPE" => "",
                "LINK_IBLOCK_ID" => "",
                "LINK_PROPERTY_SID" => "",
                "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
                "USE_ALSO_BUY" => "N",
                "USE_STORE" => "N",
                "DISPLAY_TOP_PAGER" => "Y",
                "DISPLAY_BOTTOM_PAGER" => "Y",
                "PAGER_TITLE" => "Продукция",
                "PAGER_SHOW_ALWAYS" => "Y",
                "PAGER_TEMPLATE" => "edamoll",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
                "PAGER_SHOW_ALL" => "Y",
                "AJAX_OPTION_ADDITIONAL" => "",
                "COMPONENT_TEMPLATE" => "edamoll",
                "USE_MAIN_ELEMENT_SECTION" => "N",
                "SET_LAST_MODIFIED" => "N",
                "ADD_SECTIONS_CHAIN" => "Y",
                "ADD_ELEMENT_CHAIN" => "N",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "SECTION_BACKGROUND_IMAGE" => "-",
                "DETAIL_SET_CANONICAL_URL" => "N",
                "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
                "DETAIL_BACKGROUND_IMAGE" => "-",
                "SHOW_DEACTIVATED" => "N",
                "USE_GIFTS_DETAIL" => "Y",
                "USE_GIFTS_SECTION" => "Y",
                "USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
                "GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "3",
                "GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
                "GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
                "GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
                "GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "3",
                "GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
                "GIFTS_SECTION_LIST_BLOCK_TITLE" => "Подарки к товарам этого раздела",
                "GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "Подарок",
                "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
                "GIFTS_SHOW_OLD_PRICE" => "Y",
                "GIFTS_SHOW_NAME" => "Y",
                "GIFTS_SHOW_IMAGE" => "Y",
                "GIFTS_MESS_BTN_BUY" => "Выбрать",
                "GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "3",
                "GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
                "GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                "DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
                "SEF_URL_TEMPLATES" => array(
                    "sections" => "",
                    "section" => "#SECTION_CODE#/",
                    "element" => "item/#ELEMENT_ID#",
                    "compare" => "compare.php?action=#ACTION_CODE#",
                    "smart_filter" => "#SECTION_CODE#/filter/#SMART_FILTER_PATH#/apply/",
                ),
                "VARIABLE_ALIASES" => array(
                    "compare" => array(
                        "ACTION_CODE" => "action",
                    ),
                )
            ),
            false
        ); 
    } 
?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>