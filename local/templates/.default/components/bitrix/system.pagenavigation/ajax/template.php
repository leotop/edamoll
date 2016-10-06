<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
        die();
    }

    if (!$arResult["NavShowAlways"]) {
        if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
            return;
        }
    }
    $g_sect = (isset($_GET["SECT"])) ? $_GET["SECT"] : str_replace("/","",$arResult["sUrlPath"]);
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

    if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
    ?>
    <div style="text-align: center;" id="PAGEN_<?=$arResult["NavNum"]?>_<?=($arResult["NavPageNomer"] + 1)?>">
        <img alt="loading" src="/include/img/ajax-loader.gif" />
        <script type="text/javascript">
            window.onscroll = function() { 
                var scrolled = window.pageYOffset || document.documentElement.scrollTop;
                var clientHeight = document.documentElement.clientHeight;
                if (scrolled > 200) {
                    document.getElementById('scroll_menu').style.display = 'block';
                } else {
                    document.getElementById('scroll_menu').style.display = 'none';
                }

                if (scrolled + clientHeight >= $("#PAGEN_<?=$arResult["NavNum"]?>_<?=($arResult["NavPageNomer"] + 1)?>").offset().top) {
                    $.ajax({
                        type: "GET",
                        url: "/include/catalog_pager.php",
                        data: "SECT=<?=$g_sect?>&ALL=1&PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>&SHOW_SORT=1",
                        dataType: "html",
                        success: function(fillter){
                            $("#PAGEN_<?=$arResult["NavNum"]?>_<?=($arResult["NavPageNomer"] + 1)?>").html(fillter);
                        }
                    });
                    window.onscroll = function() { 
                        var scrolled = window.pageYOffset || document.documentElement.scrollTop;
                        if (scrolled > 200) {
                            document.getElementById('scroll_menu').style.display = 'block';
                        } else {
                            document.getElementById('scroll_menu').style.display = 'none';
                        }
                    }
                }
            }
        </script>
    </div>
    <? 
    }
?>