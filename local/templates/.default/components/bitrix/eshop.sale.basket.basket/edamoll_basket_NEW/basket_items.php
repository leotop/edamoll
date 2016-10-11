<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die(); ?>
<? if (!CModule::IncludeModule("iblock"))
    return; ?>
<script type="text/javascript">
    var arrChanged = [];
    function new_q(ID, qu) {
        refresh_summ(ID, qu);
        if (window.timeoutID !== undefined) {
            clearTimeout(timeoutID);
        }
        ;
        arrChanged[ID] = qu;
        timeoutID = setTimeout(ajaxrenew, 1000);
        refresh_summ(ID, qu);

    }

    function del_from_cart(ID, el) {
        var text = $("#row" + ID + " .cart-item-name a").html();
        var name_input = document.getElementById(el);
        name_input.value = 0;
        refresh_summ(ID, 0);

        $.ajax({
            type: "POST",
            url: '/include/cart_qu.php',
            data: "ajaxaction=delete&ajaxdeleteid=" + ID,
            dataType: "html",
            success: function (fillter) {
            }
        });
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $('#addItemInCart').html("Товар удален<BR />" + text);
        var ModalName = $('#addItemInCart');
        if (typeof(currentTimeout) !== 'undefined') {
            clearTimeout(currentTimeout);
        }
        CentriredModalWindow(ModalName);
        OpenModalWindow(ModalName);
        currentTimeout = setTimeout(function () {
            $(ModalName).css({"display": "none", "opacity": 0})
            }, 2000);
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $("#row" + ID).hide("fade", {}, 500);
        $("#row" + ID).removeClass("cartrow");


        $("#sortbutton1").html("готовые к заказу (" + $(".cartrow").length + ")");
        $("#sortbutton10").html("готовые к заказу (" + $(".cartrow").length + ")");
    }

    function del_from_delay(ID) {
        var text = $("#delrow" + ID + " .delitemname a").html();
        $.ajax({
            type: "POST",
            url: '/include/cart_qu.php',
            data: "ajaxaction=delete&ajaxdeleteid=" + ID,
            dataType: "html",
            success: function (fillter) {
            }
        });
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $('#addItemInCart').html("Товар удален<BR />" + text);
        var ModalName = $('#addItemInCart');
        if (typeof(currentTimeout) !== 'undefined') {
            clearTimeout(currentTimeout);
        }
        CentriredModalWindow(ModalName);
        OpenModalWindow(ModalName);
        currentTimeout = setTimeout(function () {
            $(ModalName).css({"display": "none", "opacity": 0})
            }, 2000);
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $("#delrow" + ID).hide("fade", {}, 500);
        $("#delrow" + ID).removeClass("delrow");
        $("#sortbutton2").html("отложенные (" + $(".delrow").length + ")");
        $("#sortbutton20").html("отложенные (" + $(".delrow").length + ")");

    }

    function delay_from_cart(ID, el) {
        var text = $("#row" + ID + " .cart-item-name a").html();
        var name_input = document.getElementById(el);
        name_input.value = 0;
        refresh_summ(ID, 0);

        $.ajax({
            type: "POST",
            url: '/include/cart_qu.php',
            data: "ajaxaction=delay&ajaxdelayid=" + ID,
            dataType: "html",
            success: function (fillter) {
            }
        });
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $('#addItemInCart').html("Товар отложен<BR />" + text);
        var ModalName = $('#addItemInCart');
        if (typeof(currentTimeout) !== 'undefined') {
            clearTimeout(currentTimeout);
        }
        CentriredModalWindow(ModalName);
        OpenModalWindow(ModalName);
        currentTimeout = setTimeout(function () {
            $(ModalName).css({"display": "none", "opacity": 0})
            }, 2000);
        setTimeout(function () {
            bask_refresh();
            }, 500);
        $("#row" + ID).hide("fade", {}, 500);
        $("#row" + ID).removeClass("cartrow");
        $("#row" + ID).addClass("delrow");
        $("#sortbutton2").html("отложенные (" + $(".delrow").length + ")");
        $("#sortbutton1").html("готовые к заказу (" + $(".cartrow").length + ")");
        $("#sortbutton20").html("отложенные (" + $(".delrow").length + ")");
        $("#sortbutton10").html("готовые к заказу (" + $(".cartrow").length + ")");
    }

    function ajaxrenew() {
        for (var key in arrChanged) {
            var val = arrChanged [key];


            $.ajax({
                type: "POST",
                url: '/include/cart_qu.php',
                data: "ajaxaction=update&ajaxbasketcountid=" + key + "&ajaxbasketcount=" + val,
                dataType: "html",
                success: function (fillter) {
                }
            });


        }
        arrChanged = [];
        setTimeout(function () {
            bask_refresh();
            }, 500);
    }

    function refresh_summ(ID, qu) {
        var sm = (parseInt($("#price" + ID).attr("data-price")) + parseInt($("#prdec" + ID).attr("data-price")) / 100) * parseFloat(qu);

        var sm2 = Math.floor(sm);
        var smdec = Math.round((sm - sm2) * 100) + "";
        if (smdec.length < 2) {
            smdec = "0" + smdec;
        }


        $("#summ" + ID).html(sm2);
        $("#summdec" + ID).html(smdec);

        if($("#priced" + ID).length>0 && $("#prdecd" + ID).length>0){
            var smd = (parseInt($("#priced" + ID).attr("data-price")) + parseInt($("#prdecd" + ID).attr("data-price")) / 100) * parseFloat(qu);

            var sm2d = Math.floor(smd);
            var smdecd = Math.round((smd - sm2d) * 100) + "";
            if (smdecd.length < 2) {
                smdecd = "0" + smdecd;
            }
            $("#priced" + ID).html("-"+sm2d);
            $("#prdecd" + ID).html(smdecd);
        }

        var flsm = 0;
        var flsmd = 0;
        parseInt($(".pric").first().attr("data-price")) + parseInt($(".pric").first().attr("data-price")) / 100;

        $(".pric").each(function () {
            var iddd = ($(this).attr("id").substring(5));
            var iqq = $(".bc" + iddd).first().val();
            flsm = flsm + (parseInt($("#price" + iddd).attr("data-price")) + parseInt($("#prdec" + iddd).attr("data-price")) / 100) * parseFloat(iqq);
        });
        $(".pricd").each(function () {
            var iddd = ($(this).attr("id").substring(6));
            var iqq = $(".bc" + iddd).first().val();
            flsmd = flsmd + (parseInt($("#priced" + iddd).attr("data-price")) + parseInt($("#prdecd" + iddd).attr("data-price")) / 100) * parseFloat(iqq);
        });

        if(flsmd==0)
        {
            $(".cart-item-discount").remove();
        }
        var flsm2 = Math.floor(flsm);
        var flsmdec = Math.round((flsm - flsm2) * 100) + "";
        if (flsmdec.length < 2) {
            flsmdec = "0" + flsmdec;
        }
        var flsm2d = Math.floor(flsmd);
        var flsmdecd = Math.round((flsmd - flsm2d) * 100) + "";
        if (flsmdecd.length < 2) {
            flsmdecd = "0" + flsmdecd;
        }

        if(flsm2d==0)
            $(".discount-tr").hide();
        else
            $(".discount-tr").show();

        $("#flsmd").html("-"+flsm2d);
        $("#flsmdecd").html(flsmdecd);

        var AllsumNotDelivery=flsm+flsmd;
        var AllsumNotDeliveryPer = Math.floor(AllsumNotDelivery);
        var tmp=Math.floor(AllsumNotDelivery - AllsumNotDeliveryPer);
        if(tmp==1)
        {
            AllsumNotDeliveryPer++;
            var AllsumNotDeliveryPercent =0+"";
        }
        else
        {
            var AllsumNotDeliveryPercent = Math.round((AllsumNotDelivery - AllsumNotDeliveryPer) * 100) + "";

        }
        if (AllsumNotDeliveryPercent.length < 2) {
            AllsumNotDeliveryPercent = "0" + AllsumNotDeliveryPercent;
        }

        $("#AllsumNotDelivery").html(AllsumNotDeliveryPer);
        $("#AllsumNotDeliveryPercent").html(AllsumNotDeliveryPercent);
        if(flsm2>=1500) {
            $('#delivery_price_basket').hide();
            $('#delivery_price_basket2').show();
            $('.class_text_delivery').hide();

        }else
        {
            $('.class_text_delivery').show();
            var sum_deliv_null = 1500 - flsm2;
            $('#sum_deliv_null').html(sum_deliv_null+' руб.');
            $('#delivery_price_basket').show();
            $('#delivery_price_basket2').hide();
            flsm2=flsm2+250;
        }
        $("#flsm").html(flsm2);
        $("#flsmdec").html(flsmdec);

    }

</script>

<div id="id-cart-list">
    <div class="sort">
        <? /*<div class="sorttext"><?=GetMessage("SALE_PRD_IN_BASKET")?></div> */ ?>
        <a href="javascript:void(0)" id="sortbutton1" class="sortbutton current"><?= GetMessage("SALE_PRD_IN_BASKET_ACT") ?>
            (<?= count($arResult["ITEMS"]["AnDelCanBuy"]) ?>)</a>
        <? if ($countItemsDelay = count($arResult["ITEMS"]["DelDelCanBuy"])): ?><a id="sortbutton2"
            href="javascript:void(0)"
            onclick="ShowBasketItems(2);"
            class="sortbutton"><?= GetMessage("SALE_PRD_IN_BASKET_SHELVE") ?>
            (<?= $countItemsDelay ?>)</a><? endif ?>

        <? /* if ($countItemsSubscribe=count($arResult["ITEMS"]["ProdSubscribe"])):?><a href="javascript:void(0)" onclick="ShowBasketItems(3);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_SUBSCRIBE")?> (<?=$countItemsSubscribe?>)</a><?endif?>
            <?if ($countItemsNotAvailable=count($arResult["ITEMS"]["nAnCanBuy"])):?><a href="javascript:void(0)" onclick="ShowBasketItems(4);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_NOTA")?> (<?=$countItemsNotAvailable?>)</a><?endif */
        ?>
    </div>
    <? $numCells = 0; ?>
    <?
        $basketdiscount=false;
        foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
        {
            if(intval($arBasketItems["DISCOUNT_PRICE"])>0)
                $basketdiscount=true;
        }
    ?>
    <table class="equipment mycurrentorders" rules="rows" style="width:830px">
        <thead>
            <tr>
                <? if (in_array("NAME", $arParams["COLUMNS_LIST"])): ?>
                    <td></td>
                    <td><?= GetMessage("SALE_NAME") ?></td>
                    <? $numCells += 2; ?>
                    <? endif; ?>
                <? if (in_array("VAT", $arParams["COLUMNS_LIST"])): ?>
                    <td><?= GetMessage("SALE_VAT") ?></td>
                    <? $numCells++; ?>
                    <? endif; ?>
                <? if (in_array("TYPE", $arParams["COLUMNS_LIST"])): ?>
                    <td class="cart-item-type"><?= GetMessage("SALE_PRICE_TYPE") ?></td>
                    <? $numCells++; ?>
                    <? endif; ?>

                <? if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])): ?>
                    <td class="cart-item-weight"><?= GetMessage("SALE_WEIGHT") ?></td>
                    <? $numCells++; ?>
                    <? endif; ?>
                <? if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])): ?>
                    <td class="cart-item-quantity"><?= GetMessage("SALE_QUANTITY") ?></td>
                    <? $numCells++; ?>
                    <? endif; ?>
                <? if (in_array("PRICE", $arParams["COLUMNS_LIST"])): ?>
                    <td class="cart-item-price"><?= GetMessage("SALE_PRICE") ?></td>
                    <? $numCells++; ?>
                    <? if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"]) && $basketdiscount): ?>
                        <td class="cart-item-discount"><?= GetMessage("SALE_DISCOUNT") ?></td>
                        <? $numCells++; ?>
                        <? endif; ?>
                    <td class="cart-item-price">Сумма</td>
                    <? $numCells++; ?>
                    <? endif; ?>
                <? if (in_array("DELAY", $arParams["COLUMNS_LIST"])): ?>
                    <td class="cart-item-delay"></td>
                    <? $numCells++; ?>
                    <? endif; ?>

                <? if (in_array("DELETE", $arParams["COLUMNS_LIST"])): ?>
                    <td class="deleteitem"></td>
                    <? endif; ?>
            </tr>
        </thead>
        <? if (count($arResult["ITEMS"]["AnDelCanBuy"]) > 0): ?>
            <tbody>
                <?
                    $i = 0;
                    $iii = 1;

                    foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
                    {
                    ?>
                    <tr id="row<?= $arBasketItems["ID"] ?>" class="cartrow">
                        <? if (in_array("NAME", $arParams["COLUMNS_LIST"])): ?>
                            <td class="td_cart_image">
                                <? if (strlen($arBasketItems["DETAIL_PAGE_URL"]) > 0): ?>
                                    <a href="<?= $arBasketItems["DETAIL_PAGE_URL"] ?>">
                                        <? endif; ?>
                                    <? if (!empty($arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"])) : ?>
                                        <img src="<?= $arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"] ?>"
                                            alt="<?= $arBasketItems["NAME"] ?>"/>
                                        <? else: ?>
                                        <img src="/bitrix/components/bitrix/eshop.sale.basket.basket/templates/.default/images/no-photo.png"
                                            alt="<?= $arBasketItems["NAME"] ?>"/>
                                        <?endif ?>
                                    <? if (strlen($arBasketItems["DETAIL_PAGE_URL"]) > 0): ?>
                                    </a>
                                    <? endif; ?>
                            </td>
                            <td class="cart-item-name">
                                <? if (strlen($arBasketItems["DETAIL_PAGE_URL"]) > 0): ?>
                                    <a href="<?= $arBasketItems["DETAIL_PAGE_URL"] ?>">
                                        <? endif; ?>
                                    <?= $arBasketItems["NAME"] ?>
                                    <? if (strlen($arBasketItems["DETAIL_PAGE_URL"]) > 0): ?>
                                    </a>
                                    <? endif; ?>
                                <?if (in_array("PROPS", $arParams["COLUMNS_LIST"]))
                                    {
                                        foreach ($arBasketItems["PROPS"] as $val)
                                        {
                                            echo "<br />" . $val["NAME"] . ": " . $val["VALUE"];
                                        }
                                }?>
                            </td>
                            <? endif; ?>
                        <? if (in_array("VAT", $arParams["COLUMNS_LIST"])): ?>
                            <td><?= $arBasketItems["VAT_RATE_FORMATED"] ?></td>
                            <? endif; ?>
                        <? if (in_array("TYPE", $arParams["COLUMNS_LIST"])): ?>
                            <td><?= $arBasketItems["NOTES"] ?></td>
                            <? endif; ?>

                        <? if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])): ?>
                            <td><?= $arBasketItems["WEIGHT_FORMATED"] ?></td>
                            <? endif; ?>
                        <? if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])): ?>
                            <td>
                                <input type="hidden" id="helper" value="1">

                                <div class="count_nav">


                                    <?
                                        $GG_BU = "";
                                        $db_props =
                                        CIBlockElement::GetProperty(11, $arBasketItems["PRODUCT_ID"], array("sort" => "asc"), Array("CODE" => "CML2_BASE_UNIT"));
                                        if ($ar_props = $db_props->Fetch()) {
                                            if(!is_numeric($ar_props["VALUE"])){
                                                $GG_BU = $ar_props["VALUE"];
                                            }
                                        }

                                        if ($GG_BU == "КГ" || $GG_BU == "кг") {
                                            $gg_quant = number_format($arBasketItems["QUANTITY"], 1) . " кг";
                                        } elseif ($GG_BU == "ШТ" || $GG_BU == "шт") {
                                            $gg_quant = number_format($arBasketItems["QUANTITY"], 0) . " шт";
                                        } else {
                                            $gg_quant = number_format($arBasketItems["QUANTITY"], 0);
                                        }
                                        //$(".bc$arBasketItems["ID"]").first().val(bc--);
                                        /*
                                        var bc = $(".bc<?=$arBasketItems["ID"]?>").first().val();ajaxpostshow("/include/cart_big.php", "ajaxaction=update&ajaxbasketcountid=<?=$arBasketItems['ID'];?>"+"&ajaxbasketcount="+bc, ".basket" );
                                        */

                                    ?>

                                    <a href="javascript:void(0)" class="plus"
                                        onclick='plus("ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>","<?= $GG_BU ?>");var bc = $(".bc<?= $arBasketItems["ID"] ?>").first().val();new_q(<?= $arBasketItems["ID"] ?>, bc);'></a>
                                    <input id="ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>"
                                        class="quantity basket-count-update bc<?= $arBasketItems["ID"] ?>"
                                        maxlength="10" type="text" name="QUANTITY_<?= $arBasketItems["ID"] ?>" value="<?= $gg_quant ?>"
                                        size="6"
                                        onChange='edit_q("ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>","<?= $GG_BU ?>");var bc = $(".bc<?= $arBasketItems["ID"] ?>").first().val();new_q(<?= $arBasketItems["ID"] ?>, bc);'>

                                    <a href="javascript:void(0)" class="minus"
                                        onclick='minus("ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>","<?= $GG_BU ?>");var bc = $(".bc<?= $arBasketItems["ID"] ?>").first().val();new_q(<?= $arBasketItems["ID"] ?>, bc);'></a>
                                </div>
                            </td>
                            <? endif; ?>
                        <? if (in_array("PRICE", $arParams["COLUMNS_LIST"])): ?>
                            <td class="cart-item-price">

                                <?   $g_pv = round(100 * ($arBasketItems["FULL_PRICE"] - floor($arBasketItems["FULL_PRICE"])));
                                    if (strlen($g_pv) < 2)
                                    {
                                        $g_pv = "0".$g_pv ;
                                }?>

                                <span class="price">
                                    <span class="pric" id="price<?= $arBasketItems["ID"] ?>" data-price="<?= floor($arBasketItems["PRICE"]) ?>"><?= floor($arBasketItems["FULL_PRICE"]) ?></span>
                                    <span class="decimal" id="prdec<?= $arBasketItems["ID"] ?>"  data-price="<?=  round(100 * ($arBasketItems["PRICE"] - floor($arBasketItems["PRICE"]))); ?>"><?= $g_pv ?></span>
                                </span>


                            </td>
                            <? if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"]) && $basketdiscount): ?>
                                <td style="width: 68px;" class="cart-item-discount">
                                    <? if(intval($arBasketItems["DISCOUNT_PRICE"])>0): ?>
                                        <span class="price" style="color: red">
                                            <?
                                                $discountPrice=$arBasketItems["DISCOUNT_PRICE"]*$arBasketItems["QUANTITY"];
                                                $p=floor($discountPrice);
                                                $d=round(100 * ($discountPrice - floor($discountPrice)));
                                                $ph=floor($arBasketItems["DISCOUNT_PRICE"]);
                                                $dh=round(100 * ($arBasketItems["DISCOUNT_PRICE"] - floor($arBasketItems["DISCOUNT_PRICE"])));
                                                if (strlen($d) < 2)
                                                {
                                                    $d =  "0".$d;
                                                }
                                                if (strlen($dh) < 2)
                                                {
                                                    $dh =  "0".$dh;
                                                }
                                            ?>

                                            <span class="pricd"   id="priced<?= $arBasketItems["ID"] ?>"  data-price="<?=$ph ?>">-<?=$p ?></span>
                                            <span class="decimal" id="prdecd<?= $arBasketItems["ID"] ?>"  data-price="<?=$dh ?>"><?=$d?></span>
                                        </span>
                                        <? endif; ?>

                                </td>
                                <? endif; ?>
                            <td class="cart-item-price"><?$summ = $arBasketItems["QUANTITY"] * $arBasketItems["PRICE"];
                                    $g_pv = floor(100 * ($summ - floor($summ)));
                                    if (strlen($g_pv) < 2)
                                    {
                                        $g_pv = "0".$g_pv ;
                                }?>

                                <span class="summ"><span id="summ<?= $arBasketItems["ID"] ?>"><?= floor($summ) ?></span><span class="decimal"
                                    id="summdec<?= $arBasketItems["ID"] ?>"><?= $g_pv ?></span></span>
                            </td>
                            <? endif; ?>
                        <? if (in_array("DELAY", $arParams["COLUMNS_LIST"])): ?>
                            <td style="width: 90px;">
                                <a class="setaside" href="javascript:void(0)"
                                    onclick="delay_from_cart('<?= $arBasketItems["ID"] ?>','ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>');_gaq.push(['_trackEvent','item','delayfrbasket']);yaCounter21772657.reachGoal('delayfrbasket');ga('send', 'event', 'item', 'delayfrbasket');"
                                    title="<?= GetMessage("SALE_DELETE_PRD") ?>">
                                <img src="/images/time.png" style="padding-top: 0px; padding-bottom: 0px; margin-top: 0px; margin-bottom: -5px; padding-right: 4px;"><?= GetMessage("SALE_OTLOG") ?></a>
                                <br/> <br/>
                                <a class="deleteitem basket-list-delete" href="javascript:void(0)"
                                    id="ajaxaction=delete&ajaxdeleteid=<?= $arBasketItems['ID']; ?>"
                                    onclick="del_from_cart('<?= $arBasketItems["ID"] ?>', 'ajaxaction=update&ajaxbasketcountid=<?= $arBasketItems['ID']; ?>');_gaq.push(['_trackEvent','item','removefrbasket']);yaCounter21772657.reachGoal('removefrbasket');ga('send', 'event', 'item', 'removefrbasket');"
                                    title="<?= GetMessage("SALE_DELETE_PRD") ?>"><img src="/images/krest.png" style="padding: 0px 10px 0px 5px; margin-top: 0px; margin-bottom: -1px;">Удалить</a>
                            </td>
                            <? endif; ?>
                    </tr><?
                        $i++;
                        $iii++;
                    }
                ?>
            </tbody>
        </table>

        <table class="myorders_itog">
            <tbody>
                <tr class="blacktext ">
                    <td class="fullsummlbl" >Стоимость заказа:<br/></td>
                    <td>

                        <?
                            $allSumNotDiscount=$arResult["allSum"]+$arResult["DISCOUNT_PRICE_ALL"];

                        ?>

                        <?

                            $g_pv = floor(100 * ($allSumNotDiscount - floor($allSumNotDiscount)));


                            if (strlen($g_pv) < 2)
                            {
                                $g_pv = "0".$g_pv ;
                        }?>
                        <div style="display: none">
                            <?
                                echo "<pre>" . print_r($g_pv." = ".$allSumNotDiscount."   ".floor($allSumNotDiscount), 1) . "</pre>";
                            ?>
                        </div>
                        <span class="fullsumm" ><span id="AllsumNotDelivery" ><?= floor($allSumNotDiscount) ?></span>
                            <span class="decimal"  id="AllsumNotDeliveryPercent"><?= $g_pv ?>
                            </span>
                        </span>
                    </td>
                </tr>
                <? if(intval($arResult["DISCOUNT_PRICE_ALL"])>0): ?>
                    <tr class="blacktext discount-tr">
                        <td class="fullsummlbl" style="color: red; padding-left: 100px;">Скидка:<br/></td>
                        <td><? $g_pv = round(100 * ($arResult["DISCOUNT_PRICE_ALL"] - floor($arResult["DISCOUNT_PRICE_ALL"])));

                                $g_pv = floor(100 * ($arResult["DISCOUNT_PRICE_ALL"] - floor($arResult["DISCOUNT_PRICE_ALL"])));

                                if (strlen($g_pv) < 2)
                                {
                                    $g_pv = "0".$g_pv ;
                            }?>

                            <span class="fullsumm" style="color: red"><span id="flsmd">-<?= floor($arResult["DISCOUNT_PRICE_ALL"]) ?></span>
                                <span class="decimal"  id="flsmdecd"><?= $g_pv ?>
                                </span>
                            </span>
                        </td>
                    </tr>
                    <? endif ?>
                <? file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/test.txt", print_r($arResult, 1)) ?>

                <?if($arResult["allSum"]<=1499):?>
                    <tr class="blacktext" id="delivery_price_basket">
                        <td class="fullsummlbl">Доставка: </td>
                        <td>
                            <span class="fullsumm"> 250 <span class="decimal">00</span></span>
                        </td>
                    </tr>
                    <tr style="display: none;" class="blacktext" id="delivery_price_basket2">
                        <td class="fullsummlbl">Доставка: </td>
                        <td>
                            <span class="fullsumm" style="color: #ff0000">БЕСПЛАТНО</span>
                        </td>
                    </tr>
                    <? else:?>
                    <tr style="display: none;" class="blacktext" id="delivery_price_basket">
                        <td class="fullsummlbl">Доставка: </td>
                        <td>
                            <span class="fullsumm"> 250 <span class="decimal">00</span></span>

                        </td>
                    </tr>
                    <tr  class="blacktext" id="delivery_price_basket2">
                        <td class="fullsummlbl">Доставка: </td>
                        <td>
                            <span class="fullsumm" style="color: #ff0000">БЕСПЛАТНО</span>
                        </td>
                    </tr>
                    <?endif;?>
                <tr class="blacktext">
                    <td class="fullsummlbl">Общая стоимость:<br/></td>
                    <td>
                        <?
                            if($arResult["allSum"]<=1499)
                                $allSum=$arResult["allSum"]+250;
                            else
                                $allSum=$arResult["allSum"];
                        ?>
                        <? $g_pv = floor(100 * ($allSum - floor($allSum)));
                            if (strlen($g_pv) < 2)
                            {
                                $g_pv = "0".$g_pv ;
                        }?>

                        <span class="fullsumm"><span id="flsm"><?= floor($allSum) ?></span>
                            <span class="decimal"         id="flsmdec"><?= $g_pv ?></span></span>
                    </td>
                </tr>

                <? if ($arParams["HIDE_COUPON"] != "Y"): ?>
                    <tr class="blacktext" colspan="2">
                        <td style="height: 40px;">Купон на скидку:</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="tal">
                            <input class="input_text_style"
                                <?
                                    if (empty($arResult["COUPON"])) {
                                    ?>

                                    style="color:#a9a9a9"
                                    <?
                                    }
                                ?>
                                value="<?
                                    if (!empty($arResult["COUPON"])) {
                                        echo $arResult["COUPON"];
                                    }
                                ?>"
                                name="COUPON"
                                type = "text"
                                placeholder = "Введите код"
                                >
                            <input type="submit" value="использовать" name="BasketRefresh" class="whitetext btuse">
                        </td>
                    </tr>
                    <? endif; ?>
                <? if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])): ?>
                    <tr>
                        <td><? echo GetMessage("SALE_ALL_WEIGHT") ?>:</td>
                        <td><?= $arResult["allWeight_FORMATED"] ?></td>
                    </tr>
                    <? endif; ?>
                <? if (doubleval($arResult["DISCOUNT_PRICE"]) > 0): ?>
                    <tr>
                        <td><?echo GetMessage("SALE_CONTENT_DISCOUNT")?><?
                            if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"]) > 0)
                                echo " (" . $arResult["DISCOUNT_PERCENT_FORMATED"] . ")";?>:
                        </td>
                        <td><?= $arResult["DISCOUNT_PRICE_FORMATED"] ?></td>
                    </tr>
                    <? endif; ?>
                <? if ($arParams['PRICE_VAT_SHOW_VALUE'] == 'Y'): ?>
                    <tr>
                        <td><? echo GetMessage('SALE_VAT_EXCLUDED') ?></td>
                        <td><?= $arResult["allNOVATSum_FORMATED"] ?></td>
                    </tr>
                    <tr>
                        <td><? echo GetMessage('SALE_VAT_INCLUDED') ?></td>
                        <td><?= $arResult["allVATSum_FORMATED"] ?></td>
                    </tr>
                    <? endif; ?>

            </tbody>
        </table>
        <br/>
        <div class="class_text_delivery" <?if (floor($arResult["allSum"])>=1500){?>style="display: none" <?}?>>Закажите еще товаров на сумму <span id="sum_deliv_null"><?=1500 - floor($arResult["allSum"]) ?> руб.</span> и получите бесплатную доставку</div>
        <button type="submit" value="<? echo GetMessage("SALE_ORDER") ?>" name="BasketOrder" id="basketOrderButton2"
            class="bt3"><? echo GetMessage("SALE_ORDER") ?></button>
        <button type="submit" value="<? echo GetMessage("SALE_ORDER") ?>" name="BasketOrder" id="basketOrderButtonTop"
            class="bt3"><? echo GetMessage("SALE_ORDER") ?></button>

        <? else: ?>
        <tbody>
            <tr>
                <td colspan="<?= $numCells ?>" style="text-align:center">
                    <div class="cart-notetext"><?= GetMessage("SALE_NO_ACTIVE_PRD"); ?></div>
                    <a href="<?= SITE_DIR ?>" class="bt3"><?= GetMessage("SALE_NO_ACTIVE_PRD_START") ?></a><br><br>
                </td>
            </tr>
        </tbody>
        </table>
        <?
            endif; ?>
  </div>
<?