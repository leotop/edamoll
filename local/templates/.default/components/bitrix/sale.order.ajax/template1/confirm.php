<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if ($arOrder = CSaleOrderPropsValue::GetList(
        array(),
        array("ORDER_ID"=>$arResult["ORDER"]["ACCOUNT_NUMBER"]),
        false,
        false,
        array()
    )) {
        $arrProp = array();
        while ($arVals = $arOrder->Fetch()) {
            $arrProp[$arVals["CODE"]] = $arVals["VALUE"];
        }

        $arBasketItems = array();
        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(

                "ORDER_ID" => $arResult["ORDER"]["ACCOUNT_NUMBER"]
            ),
            false,
            false,
            array()
        );
        $discountPrice = 0;
        while ($arItems = $dbBasketItems->Fetch()) {
            $arBasketItems[] = $arItems;
            $discountPrice += $arItems["QUANTITY"] * $arItems["DISCOUNT_PRICE"];
        }
    }

    if (!empty($arResult["ORDER"])) {
        $Date = strtotime($arResult["ORDER"]["DATE_INSERT"]);
        $diff = time() - $Date;
        if ($diff < 10){
            if (isset($_COOKIE['uid'])) {
            ?>
            <img src="http://ad.admitad.com/register/71aa76bf80/script_type/img/payment_type/sale/product/1/cart/<?=$arResult["ORDER"]["PRICE"]?>/order_id/<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>/uid/<?=$_COOKIE['uid']?>/" width="1" height="1" alt="" />
            <?                             
            } 
            if (isset($_COOKIE['from'])) {
            ?>
            <img src="http://www.qxplus.ru/scripts/sale.php?AccountId=0bd6d758&TotalCost=<?=$arResult["ORDER"]["PRICE"]?>&OrderID=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&ProductID=edamoll_default" width="1" height="1" > 
            <?                             
            } 
        ?>
        <!--Трэкер "Покупка"--> 
        <script>document.write('<img src="http://mixmarket.biz/tr.plx?e=3779408&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'" width="1" height="1"/>');</script> 
        <!--Трэкер "Покупка"-->
        <?
            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=cpanetwork") <> false 
                && strpos($_COOKIE["__utmz"], "utmcmd=cpo") <> false) {
            ?>
            <!-- Cpanetwork.ru Tracking Start -->
            <div id="_cpanetwork-43471298b8"></div>
            <script type="text/javascript">
                (function() {
                    var amount = '<?=$arResult["ORDER"]["PRICE"]?>';
                    var orderId = '<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>';
                    var subId = '';
                    var cpa = document.createElement('script');
                    cpa.type = 'text/javascript';
                    cpa.async = true;
                    cpa.src = '//cpanetwork.ru/tracking/advertiser.js?campaign=49dca3839f&action=43471298b8' + '&amount=' + amount + '&order_id=' + orderId + '&sub_id=' + subId;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(cpa, s);
                })();
            </script>
            <!-- Cpanetwork.ru Tracking End -->
            <?
            }
        ?>

        <?
            /*if($USER->GetID()==2301)
            file_put_contents($_SERVER["DOCUMENT_ROOT"]."/orders.txt",print_r($_COOKIE,1));  */
            if (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=gdeslon") <> false 
                && strpos($_COOKIE["__utmz"], "utmcmd=cpo") <> false) { //SLON 
                $txt = "";
                foreach($arBasketItems as $key=> $Item) {
                    $str = "";
                    if($key != 0) {
                        $str = ",";
                    }
                    $str .= $Item["PRODUCT_ID"].":".$Item["PRICE"];
                    $txt .= str_repeat($str, $Item["QUANTITY"]);


                }
                /*if($USER->GetID()==2301)
                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/orders.txt","\n\n".print_r($txt,1),FILE_APPEND);  */

            ?>
            <script type="text/javascript" src="http://www.gdeslon.ru/thanks.js?codes=<?=$txt?>&order_id=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&merchant_id=59066 "></script>
            <? 
            } 

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=afrek") <> false && 
                strpos($_COOKIE["__utmz"], "utmcmd=cpo") <> false) {
            ?>
            <!-- afrek.ru Tracking Start -->
            <img src="http://pixel.afrek.ru/?goid=979&iid=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&sum=<?=$arResult["ORDER"]["PRICE"]?>" width="1" height="1"/>
            <!-- afrek.ru Tracking End -->
            <?
            }

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=navynos") <> false && 
                strpos($_COOKIE["__utmz"], "utmcmd=cpo") <> false) {
            ?>
            <!-- Offer Goal Conversion: Заказ на сайте -->
            <iframe src="http://tracking.navynosaffiliates.com/aff_goal?a=l&goal_id=50&adv_sub=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&amount=<?=$arResult["ORDER"]["PRICE"]?>" scrolling="no" frameborder="0" width="1" height="1"></iframe>
            <!-- // End Offer Goal Conversion -->
            <?
            }

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=7offer") <> false && 
                strpos($_COOKIE["__utmz"], "utmcmd=cpo")<>false) 
            {
            ?>
            <img src="http://pixel.7offers.ru/519/299/pixel.png?id=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&price=<?=$arResult["ORDER"]["PRICE"]?>&currency=RUR" width="1" height="1">
            <?
            }

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=adpro") <> false && 
                strpos($_COOKIE["__utmz"],"utmcmd=cpo") <> false) {
            ?>
            <img src=http://cpp1.ru/pixel/125.png?advActId=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&leadCost=<?=$arResult["ORDER"]["PRICE"]?> width="1" height="1" />
            <?
            }

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utmccn=partner") <> false && strpos($_COOKIE["__utmz"], "utmcsr=lead-r") <> false && 
                strpos($_COOKIE["__utmz"], "utmcmd=cpo") <> false) {
            ?>
            <img src="http://track.lead-r.ru/?method=ReportAction&transaction_id=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&advertiser_id=23&offer=23MQUwR:<?=$arResult["ORDER"]["PRICE"]?>" 
                alt="" style="width: 0; height: 0; position: absolute;" />
            <?
            }

            if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"], "utm_source=mixmarket") <> false && strpos($_COOKIE["__utmz"], "utm_medium=cpo") <> false) { 
            ?>
            <script>
                var univar1='<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>';
                var univar2='<?=$arResult["ORDER"]["PRICE"]?>';
            document.write('<img src="http://mixmarket.biz/uni/tev.php?id=1294926074&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'&a1='+univar1+'&a2='+univar2+'" width="1" height="1"/>');</script>
            <noscript>
                <img src="http://mixmarket.biz/uni/tev.php?id=1294926074&a1=<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>&a2=<?=$arResult["ORDER"]["PRICE"]?>" width="1" height="1"/>
            </noscript>
            <?
            }
        } 
    ?>
    <script type="text/javascript">
        $(".order_main_h").html("СПАСИБО! ВАШ ЗАКАЗ ПРИНЯТ");
        $(".order_main_h").css("text-align","center");
        var logo_html = $(".bot").html();
        logo_html = '<a href = "/">' + logo_html + '</a>';
        $(".bot").html(logo_html);
    </script>
    <div class="order_res_div">
    <div class="">Номер Вашего заказа <?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>.<br />
        В ближайшее время менеджер<br />свяжется с Вами для уточнения заказа</div>

    <script Language="Javascript">
        function printit(){ 
            if (window.print) {
                window.print() ; 
            } else {
                var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
                document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
                WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box WebBrowser1.outerHTML = ""; 
            }
        }
    </script>
    <input class="print_order" value="РАСПЕЧАТАТЬ" onclick="printit()" type="button">

    <h3>данные вашего заказа <?=$arResult["ORDER"]["DATE_INSERT"]?> (№<?=$arResult["ORDER"]["ACCOUNT_NUMBER"]?>) </h3>
    <div class="sale_order_summary_div">

        <table class="sale_order_full_2">

            <tr>
                <td align="left">
                    <b>
                        Сумма заказа:
                    </b>
                </td>
                <td align="right">
                    <?=CurrencyFormat($arResult["ORDER"]["PRICE"] - $arResult["ORDER"]["PRICE_DELIVERY"] + $discountPrice,'RUB')?> р.
                </td>
            </tr>
            <?
                if (doubleval($discountPrice) > 0) {
                ?>
                <tr style="color: red">
                    <td align="left">
                        <b>
                            Скидка: 
                        </b>
                    </td>
                    <td align="right">
                        -<?=CurrencyFormat($discountPrice, 'RUB')?> р.
                    </td>
                </tr>
                <?
                }

                if (doubleval($arResult["ORDER"]["PRICE_DELIVERY"]) > 0) {
                ?>
                <tr>
                    <td align="left">
                        <b>
                            Стоимость доставки: 
                        </b>
                    </td>
                    <td align="right">
                        <?=CurrencyFormat($arResult["ORDER"]["PRICE_DELIVERY"], 'RUB')?> р.
                    </td>
                </tr>
                <?
                }
                else
                {
                ?>
                <tr>
                    <td align="left">
                        <b>
                            Стоимость доставки: 
                        </b>
                    </td>
                    <td align="right" style="color: red;">
                        БЕСПЛАТНО
                    </td>
                </tr>
                <?
                }
            ?>
            <tr>
                <td colspan="2" class="bortop">
                </td>
            </tr>
            <tr>
                <td align="left">
                    <b>
                        Общая стоимость: 
                    </b>
                </td>
                <td align="right">
                    <b>
                        <?=CurrencyFormat($arResult["ORDER"]["PRICE"], 'RUB')?> р.
                    </b>
                </td>
            </tr>
            <?
                if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0) {
                ?>
                <tr>
                    <td align="right">
                        <b>
                            <?=GetMessage("SOA_TEMPL_SUM_PAYED")?>
                        </b>
                    </td>
                    <td align="right">
                        <?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?>
                    </td>
                </tr>
                <?
                }
            ?>
        </table>
    </div>
    <div class="order_props_id">
    <table class="order_props_table" cellspacing="10">
        <tr>
            <td class="gray">
                ФИО
            </td>
            <td class="razd">
            </td>
            <td class="content_td">
                <?=$arrProp["fam"]." ".$arrProp["name"]." ". $arrProp["otch"]?>
            </td>
        </tr>
        <tr>
            <td class="gray">
                Номер телефона
            </td>
            <td class="razd">
            </td>
            <td class="content_td">
                <?=$arrProp["tel"]?>
            </td>
        </tr>
        <tr>
            <td class="gray">
                Email
            </td>
            <td class="razd">
            </td>
            <td class="content_td">
                <? if ($arrProp["email"] <> "noemail@edamoll.ru") echo $arrProp["email"];?>
            </td>
        </tr>
        <tr>
            <td class="gray">
                Адрес доставки
            </td><td class="razd"></td>
            <td class="content_td">
                <?=$arrProp["adres"]?>
            </td>
        </tr>
        <tr>
            <td class="gray">
                Комментарий к заказу
            </td>
            <td class="razd">
            </td>
            <td class="content_td">
                <?=$arResult["ORDER"]["USER_DESCRIPTION"]?>
            </td>
        </tr>
    </table>
    <div>
        <table class="equipment mycurrentorders" rules="rows" style="width:100%">
            <thead>
                <tr>
                    <td>
                    </td>
                    <td>
                        Название
                    </td>
                    <td>
                        Количество/Вес
                    </td>
                    <td class="cart-item-price">
                        Цена за ед.
                    </td>
                    <?
                        if (doubleval($discountPrice) > 0) {
                        ?>
                        <td class="cart-item-price">
                            Скидка
                        </td>
                        <? 
                        }
                    ?>
                    <td class="cart-item-price">
                        Сумма
                    </td>
                </tr>
            </thead>
            <tbody>
                <? 
                    foreach($arBasketItems as $arItemz) {
                    ?>
                    <tr>
                        <?
                            $big_picture="";
                            if (!CModule::IncludeModule("iblock")) {
                                return;
                            } 
                            $res = CIBlockElement::GetByID($arItemz["PRODUCT_ID"]);
                            if($ar_res = $res->GetNext()) {
                                $big_picture = CFile::GetPath($ar_res["PREVIEW_PICTURE"]);
                            }
                            $base_unit = "шт";
                            $db_props2 = CIBlockElement::GetProperty(
                                11, 
                                $arItemz["PRODUCT_ID"], 
                                array("sort" => "asc"), 
                                array("CODE"=>"CML2_BASE_UNIT")
                            );
                            if ($ar_props2 = $db_props2->Fetch()) {
                                $base_unit = $ar_props2["VALUE"];
                            }
                        ?>
                        <td class="td_cart_image">
                            <?
                                if (strlen($arItemz["DETAIL_PAGE_URL"]) > 0) {
                                ?>
                                <a href="<?=$arItemz["DETAIL_PAGE_URL"]?>">
                                    <?
                                    }
                                    if (!empty($big_picture) ) {
                                    ?>
                                    <img src="<?=$big_picture?>" alt="<?=$arItemz["NAME"] ?>"/>
                                    <?
                                    } else {
                                    ?>
                                    <img src="/bitrix/components/bitrix/eshop.sale.basket.basket/templates/.default/images/no-photo.png" alt="<?=$arItemz["NAME"] ?>"/>
                                    <?
                                    }
                                    if (strlen($arItemz["DETAIL_PAGE_URL"]) > 0) {
                                    ?>
                                </a>
                                <?
                                }
                            ?>
                        </td>
                        <td>
                            <?=$arItemz["NAME"];?>
                        </td>
                        <td>
                            <?=$arItemz["QUANTITY"]?>
                            <?=$base_unit?>
                        </td>
                        <td class="cart-item-price">
                            <?
                                $arItemz["PRICE"] = $arItemz["PRICE"] + $arItemz["DISCOUNT_PRICE"];
                                $g_pv=round(100 * ($arItemz["PRICE"] - floor($arItemz["PRICE"])));
                                if (strlen($g_pv) < 2) {
                                    $g_pv="0".$g_pv;
                                }
                            ?>
                            <span class="price">
                                <?=floor($arItemz["PRICE"])?>
                                <span class="decimal">
                                    <?=$g_pv?>
                                </span>
                            </span>
                        </td>
                        <?   
                            if (doubleval($discountPrice) > 0) {
                            ?>
                            <td class="cart-item-price">
                                <? 
                                    if(intval($arItemz["DISCOUNT_PRICE"]) > 0){
                                        $g_pv=round(100 * ($arItemz["DISCOUNT_PRICE"] * $arItemz["QUANTITY"] - floor($arItemz["DISCOUNT_PRICE"] * $arItemz["QUANTITY"])));
                                        if (strlen($g_pv) < 2) {
                                            $g_pv = "0".$g_pv;
                                        }
                                    ?>
                                    <span class="price" style="color: red">
                                        -<?=floor($arItemz["DISCOUNT_PRICE"] * $arItemz["QUANTITY"])?>
                                        <span class="decimal">
                                            <?=$g_pv?>
                                        </span>
                                    </span>
                                    <? 
                                    } 
                                ?>
                            </td>
                            <? 
                            } 
                        ?>
                        <td class="cart-item-price">
                            <?
                                $summ = $arItemz["QUANTITY"] * ($arItemz["PRICE"] - $arItemz["DISCOUNT_PRICE"]); 
                                $g_pv = round(100 * ($summ - floor($summ)));
                                if (strlen($g_pv) < 2) {
                                    $g_pv="0".$g_pv;
                                }
                            ?>
                            <span class="summ">
                                <?=floor($summ)?>
                                <span class="decimal">
                                    <?=$g_pv?>
                                </span>
                            </span>
                        </td>
                    </tr>
                    <?
                    }
                ?>
            </tbody>
        </table>
        <input class="print_order" value="РАСПЕЧАТАТЬ" onclick="printit()" type="button">
        <?
        } else {
        ?>
        <b>
        <?=GetMessage("SOA_TEMPL_ERROR_ORDER")?>
        </b>
        <br />
        <br />
        <table class="sale_order_full_table">
            <tr>
                <td>
                    <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", array("#ORDER_ID#" => $arResult["ORDER_ID"]))?>
                    <?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
                </td>
            </tr>
        </table>
    </div>
    <?
    }
?>
<div id="footer">
    <div id="socnet" class="sidebar">
        <?
            $APPLICATION->IncludeFile(
                SITE_DIR."include/socnet.php",
                array(),
                array("MODE"=>"html")
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
                    array(),
                    array("MODE"=>"html")
                );
            ?>
        </div>

    </div>
    </div>