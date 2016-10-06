<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
</div>
<? if(defined("NOINDEX_MENU")) echo ("<noindex>"); ?>
<div id="header_menu">	
    <div id="top-menu">
        <div id="top-menu-inner">

            <?
                $APPLICATION->IncludeComponent("bitrix:menu", "edamoll_top_menu", array(
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "bottom",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                );
            ?>
        </div>
    </div>
</div>
<div id="scroll_menu">
    <div id="scroll_menu_top">
        <div id="scroll-menu-div">
            <?
                $APPLICATION->IncludeComponent("bitrix:menu", "edamoll_scroll_menu", Array(
                "ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
                "MENU_CACHE_TYPE" => "N",	// Тип кеширования
                "MENU_CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
                "MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
                "MAX_LEVEL" => "2",	// Уровень вложенности меню
                "CHILD_MENU_TYPE" => "",	// Тип меню для остальных уровней
                "USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N",	// Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
                ),
                false,
                array(
                "ACTIVE_COMPONENT" => "Y"
                )
                );
            ?>
            <div id="cart_line_scroll">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:sale.basket.basket.small",
                    "edamoll_small_basket_scroll",
                    Array(
                        "PATH_TO_BASKET" => "/personal/basket.php",
                        "PATH_TO_ORDER" => "/personal/order.php"
                    )
                );?> </div>

        </div>
    </div>
    <div id="scroll-menu-div2">
        <?$APPLICATION->IncludeComponent("bitrix:search.form", "edamoll_search_form_scroll", Array(
                "PAGE" => "#SITE_DIR#search/index.php",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
                "USE_SUGGEST" => "N",	// Показывать подсказку с поисковыми фразами
                ),
                false
            );?>
    </div>
</div>
<? if(defined("NOINDEX_MENU")) echo ("</noindex>"); ?>
<div class="modal" id="addItemInCart"></div>	
<div id="space-for-footer"></div>

</div>
<noindex>
    <?
        $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "eshop", array(

            ),
            false
        );
    ?>
    <div class="modal login_window" id="ed_reg">
        <?
            $APPLICATION->IncludeComponent(
                "bitrix:main.register",
                "edamoll",
                Array(
                    "SHOW_FIELDS" => "",
                    "REQUIRED_FIELDS" => "",
                    "AUTH" => "Y",
                    "USE_BACKURL" => "Y",
                    "SUCCESS_PAGE" => "/personal/",
                    "SET_TITLE" => "N",
                    "USER_PROPERTY" => ""
                )
            );
        ?>
        <?
            $APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "eda2", array(

                ),
                false
            );
        ?>
        <div class="a_log"><a href="#">войти как зарегистрированный <br /> пользователь</a></div>
        <script type="text/javascript">
            $( "#ed_reg>.close_button" ).click(function() {
                $('.modal').css('display','none');$('#dark').css('display','none');
            });
        </script>
        <div class="close_button" onclick="$('.modal').css('display','none');$('#dark').css('display','none');"></div>
    </div>
</noindex>
<div id="footer">

    <div id="socnet" class="sidebar">
        <?
            $APPLICATION->IncludeFile(
                SITE_DIR."include/socnet.php",
                Array(),
                Array("MODE"=>"html")
            );
        ?>
    </div>
    <div class="footer-links">	
        <?
            $APPLICATION->IncludeComponent("bitrix:menu", "edamoll_bottom_menu", array(
                "ROOT_MENU_TYPE" => "top",
                "MENU_CACHE_TYPE" => "N",
                "MENU_CACHE_TIME" => "36000000",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "bottom",
                "USE_EXT" => "Y",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
                ),
                false
            );
        ?>
        <div id="footer_links_area">
            <?
                $APPLICATION->IncludeFile(
                    SITE_DIR."include/footerlinks.php",
                    Array(),
                    Array("MODE"=>"html")
                );
            ?>
        </div>

    </div>
</div>


<div id="dark" onclick="$('#dark').css('display','none');$('.modal').css('display','none');"></div>
<?if (defined("ERROR_REG") && ERROR_REG==="Y"){?>
    <script type="text/javascript">
        var modalH = $("#ed_reg").height(); $("#ed_reg").css({"margin-top":"-"+(parseInt(modalH)/2)+"px" });
        $('.modal').css('display','none');
        $('#dark').css('display','block');
        $('#ed_reg').css('display','block');

    </script>
    <?}?>
</div>
<script src="/include/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function($){
        $(window).load(function(){
            $(".filter_vals").mCustomScrollbar();
        });
    })(jQuery);
</script>

<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 976899923;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/976899923/?value=0&amp;guid=ON&amp;script=0"/>
    </div>
</noscript>

<script type="text/javascript">
    (window.Image ? (new Image()) : document.createElement('img')).src = location.protocol + '//vk.com/rtrg?r=PIkNaA6dHQFsfvBN0ULPzYVAf5bk5vwFiqocNWjZ7YeOIki9LJ4lpWmdG/CsuIEBb43lh/6PKuFYNtsvRtI923JjFYqsDqFIG4LoBfGb2a13N1CTHqddlG3glqjqjGFR0RTqy*JiPnJNZtuTcywFtB4RGlj0XjYTFQbUqfbO09E-';
</script>


</body>
</html>