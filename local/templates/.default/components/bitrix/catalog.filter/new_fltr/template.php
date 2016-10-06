<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? 
    CModule::IncludeModule("iblock");
    $gel = CIBlockElement::GetList(
        array("PROPERTY_KKAL_VALUE" => "ASC"),
        array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_CODE" => $arParams["gItems"], "INCLUDE_SUBSECTIONS" => "Y", ">CATALOG_QUANTITY" => 0),
        false,
        false,
        array("ID", "PROPERTY_KKAL", "PROPERTY_STRANA", "PROPERTY_MARKA")
    );
    $arKKAL = "";
    $arManufacturer = "";
    $arCountry = "";
    $arAccordance = array();
    while($ob = $gel->GetNextElement()) { 
        $arFieldz = $ob->GetFields();  
        if (trim($arFieldz["PROPERTY_KKAL_VALUE"]) !== "" && $arFieldz["PROPERTY_KKAL_VALUE"] !== "&lt;&gt;") {
            $arKKAL[$arFieldz["PROPERTY_KKAL_ENUM_ID"]] = str_replace ( ",", ".", $arFieldz["PROPERTY_KKAL_VALUE"]);
        }
        if (trim($arFieldz["PROPERTY_MARKA_VALUE"]) !== "" && $arFieldz["PROPERTY_MARKA_VALUE"] !== "&lt;&gt;"){
            $arManufacturer[$arFieldz["PROPERTY_MARKA_ENUM_ID"]] = $arFieldz["PROPERTY_MARKA_VALUE"];
        }
        if (trim($arFieldz["PROPERTY_STRANA_VALUE"]) !== "" && $arFieldz["PROPERTY_STRANA_VALUE"] !== "&lt;&gt;"){
            $arCountry[$arFieldz["PROPERTY_STRANA_ENUM_ID"]] = $arFieldz["PROPERTY_STRANA_VALUE"];
        }
        if (trim($arFieldz["PROPERTY_MARKA_VALUE"]) !== "" && $arFieldz["PROPERTY_MARKA_VALUE"] !== "&lt;&gt;" && trim($arFieldz["PROPERTY_STRANA_VALUE"]) !== "" 
            && $arFieldz["PROPERTY_STRANA_VALUE"] !== "&lt;&gt;") {
            $arAccordance[$arFieldz["PROPERTY_STRANA_ENUM_ID"]][$arFieldz["PROPERTY_MARKA_ENUM_ID"]] = $arFieldz["PROPERTY_MARKA_ENUM_ID"];
        }
    }
?>
<div class="filter_div">
    <form name="<?=$arResult["FILTER_NAME"]."_form"?>" action="<?=$arResult["FORM_ACTION"]?>" method="get"  class="smartfilter">
        <?
            foreach($arResult["ITEMS"] as $arItem) {
                if(array_key_exists("HIDDEN", $arItem)) {
                    echo $arItem["INPUT"];
                }
            }

            foreach($arResult["ITEMS"] as $arItem) {
                if(!array_key_exists("HIDDEN", $arItem)) {
                    if(($arItem["NAME"] == "Розничная")) {
                    ?>
                    <div class="filter_name">
                        <?=($arItem["NAME"] == "Розничная")?"Цена":$arItem["NAME"]?>
                        <br/>
                        <br/>
                    </div>
                    <div class="filter_vals">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <span class="min-price">От</span>
                                </td>
                                <td style="text-align:right;">
                                    <span class="max-price">До</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan= "2">
                                    <?$gitm = str_replace("<input","<input style='padding: 4px;width: 50px;' ", $arItem["INPUT"]);?>
                                    <?=str_replace("&nbsp;по&nbsp;", "&nbsp;&nbsp;", $gitm)?>
                                </td>
                            </tr>
                        </table>

                    </div>


                    <? } elseif ($arItem["INPUT_NAME"] == "arFilter_pf[MARKA]" ) { 
                        if (sizeof($arManufacturer) > 1) {
                        ?>
                        <div  class="filter_name">
                            <?=$arItem["NAME"]?>
                            <br/>
                            <br/>
                        </div>
                        <div class="filter_vals">
                            <?    
                                asort($arItem["LIST"]);
                                //Get already checked values
                                foreach ($_GET["arFilter_pf"]["MARKA"] as $keyChecked) {
                                    $arKeyChecked[$keyChecked] = $keyChecked;
                                }
                                //Forming filter item values
                                foreach ($arItem["LIST"] as $filterValueKey => $filterValue) {  
                                    if (isset($arManufacturer[$filterValueKey])) {
                                        if (!empty($filterValueKey)) {
                                            if (isset($_GET["arFilter_pf"]["STRANA"]) && !isset($_GET["del_filter"])) {
                                                $addFilterValue = false;
                                                foreach($_GET["arFilter_pf"]["STRANA"] as $arCountries) {
                                                    if (isset($arAccordance[$arCountries][$filterValueKey])) {
                                                        $addFilterValue = true; 
                                                    }
                                                }
                                                if ($addFilterValue) {
                                                    $arResult["FILTER_VALUES"]["MANUFACTURER"][$filterValueKey] = $filterValue;
                                                }
                                            } else {
                                                $arResult["FILTER_VALUES"]["MANUFACTURER"][$filterValueKey] = $filterValue;
                                            }

                                        }
                                    }
                                }
                                //Output filter item values
                                foreach ($arResult["FILTER_VALUES"]["MANUFACTURER"] as $filterValueKey => $filterValue) {
                                ?>
                                <input type="checkbox" name="<?=$arItem["INPUT_NAME"]?>[]" value="<?=$filterValueKey?>" onclick="sbmtfrm();" <?
                                        if (!empty($arKeyChecked[$filterValueKey])) {
                                            echo 'checked';    
                                        }
                                    ?>
                                    />
                                <?=$filterValue?>
                                </br>
                                <?
                                }
                            ?>
                        </div>
                        <?
                        }
                    } elseif ($arItem["INPUT_NAME"] == "arFilter_pf[STRANA]" ) { 
                        if (sizeof($arCountry) > 1) {
                        ?>
                        <div  class="filter_name">
                            <?=$arItem["NAME"]?>
                            <br/>
                            <br/>
                        </div>
                        <div class="filter_vals">
                            <? 
                                asort($arItem["LIST"]);
                                //Get already checked values
                                foreach ($_GET["arFilter_pf"]["STRANA"] as $keyChecked) {
                                    $arKeyChecked[$keyChecked] = $keyChecked;
                                }
                                //Forming filter item values
                                foreach ($arItem["LIST"] as $filterValueKey => $filterValue) {
                                    if (isset($arCountry[$filterValueKey])) {
                                        if (!empty($filterValueKey)) {
                                            if (isset($_GET["arFilter_pf"]["MARKA"]) && !isset($_GET["del_filter"])) {
                                                $addFilterValue = false;
                                                foreach($_GET["arFilter_pf"]["MARKA"] as $arCountries) {
                                                    if (isset($arAccordance[$filterValueKey][$arCountries])) {
                                                        $addFilterValue = true; 
                                                    }
                                                }
                                                if ($addFilterValue) {
                                                    $arResult["FILTER_VALUES"]["COUNTRY"][$filterValueKey] = $filterValue;
                                                }
                                            } else {
                                                $arResult["FILTER_VALUES"]["COUNTRY"][$filterValueKey] = $filterValue;
                                            }

                                        }
                                    }
                                }
                                //Output filter item values
                                foreach ($arResult["FILTER_VALUES"]["COUNTRY"] as $filterValueKey => $filterValue) {
                                ?>
                                <input type="checkbox" name="<?=$arItem["INPUT_NAME"]?>[]" value="<?=$filterValueKey?>" onclick="sbmtfrm();" <?
                                        if (!empty($arKeyChecked[$filterValueKey])) {
                                            echo 'checked';    
                                        }
                                    ?>
                                    />
                                <?=$filterValue?>
                                </br>
                                <?
                                }

                                $arM = explode("</input>", $arItem["INPUT"]);
                                $arItog = array();
                                foreach($arM as $val) { 
                                    $pos1= strpos($val, "value");
                                    $pos2=strpos($val, ">", $pos1);
                                    $ind = substr($val, $pos1+7, $pos2-$pos1-8);
                                    if (isset($arCountry[$ind])) {
                                        $sval = substr($val, $pos2+1);
                                        $pos3 = strpos($val, "<input");
                                        $val = substr($val, $pos3);
                                        $val = str_replace("<input", "<input onclick='sbmtfrm();' ", $val);
                                        if (isset($_GET["arFilter_pf"]["MARKA"]) && !isset($_GET["del_filter"]) ) {
                                            $flag = false;
                                            foreach($_GET["arFilter_pf"]["MARKA"] as $V) {
                                                if (isset($arAccordance[$ind][$V])) {
                                                    $flag=true;
                                                }
                                            }
                                            if ($flag) {
                                                $arItog[$sval] = $val;
                                            }
                                        } else {
                                            $arItog[$sval] = $val;
                                        }
                                    }
                                }
                                ksort($arItog);
                                foreach($arItog as $val) { 
                                    echo($val."<br />");
                                }
                            ?>
                        </div>
                        <? 
                        }
                    }
                    elseif ($arItem["INPUT_NAME"] == "arFilter_pf[KKALO]" ) { 
                        if (sizeof($arKKAL) > 1) {
                        ?>
                        <div style="display:none">
                            <? 
                                $arM = explode("</input>", $arItem["INPUT"]);
                                foreach($arM as $val) { 
                                    $pos1= strpos($val, "value");
                                    $pos2=strpos($val, ">", $pos1);
                                    $ind = substr($val, $pos1+7, $pos2-$pos1-8);
                                    if (isset($arKKAL[$ind])) {
                                        //$val=str_replace("<input","<input onclick='sbmtfrm();' ",$val);
                                        echo($val);
                                    }
                                }
                            ?>
                        </div>
                        <?
                            $arFieldsKKAL["MIN"] = min($arKKAL);
                            $arFieldsKKAL["MAX"] = max($arKKAL);
                        ?>
                        <div class="filter_name2">
                            Калории
                            <br/>
                            <br/>
                        </div>
                        <div class="filter_vals2">
                            <script>
                                $(function() {
                                    $( "#slider-range_kkal" ).slider({
                                        range: true,
                                        min: <?=$arFieldsKKAL["MIN"];?>,
                                        max: <?=$arFieldsKKAL["MAX"];?>,
                                        values: [<? 
                                                if ($_GET["arFilter_KKAL_MIN"] != "") { 
                                                    echo $_GET["arFilter_KKAL_MIN"];
                                                } else { 
                                                    echo $arFieldsKKAL["MIN"];
                                                }
                                            ?>,<?
                                                if ($_GET["arFilter_KKAL_MAX"] != "") {
                                                    echo $_GET["arFilter_KKAL_MAX"];
                                                } else { 
                                                    echo $arFieldsKKAL["MAX"];
                                        }?>],

                                        slide: function( event, ui ) {
                                        //alert("slide! "+$( "#arFilter_KKAL_MIN" ).html());
                                        $( "#arFilter_KKAL_MIN" ).val(ui.values[ 0 ]);
                                        $( "#arFilter_KKAL_MAX" ).val(ui.values[ 1 ]);
                                        }
                                    });
                                    $("#slider-range_kkal>a").first().css("background-position","left top");
                                });
                            </script>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <span class="min-price">
                                            <? 
                                                if ($_GET["arFilter_KKAL_MIN"] != "") {
                                                    echo $arFieldsKKAL["MIN"];
                                                }
                                            ?> ккал
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span class="max-price">
                                            <?
                                                if ($_GET["arFilter_KKAL_MAX"] != "") {
                                                    echo $arFieldsKKAL["MAX"];
                                                }
                                            ?> ккал
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="slider-range_kkal">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="min-price">
                                            От
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <span class="max-price">
                                            До
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 10px;">
                                        <input
                                            class="min-price"
                                            type="text"
                                            name="arFilter_KKAL_MIN"
                                            id="arFilter_KKAL_MIN"
                                            value="<? 
                                                if ($_GET["arFilter_KKAL_MIN"]!="") { 
                                                    echo $_GET["arFilter_KKAL_MIN"];
                                                } else {
                                                    echo $arFieldsKKAL["MIN"];
                                                }
                                            ?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
                                            onchange="$(function() {
                                                var value1 = $('#arFilter_KKAL_MIN').val();
                                                var value2 = $('#arFilter_KKAL_MAX').val();
                                                if(parseInt(value1) > parseInt(value2)) {
                                                    value1 = value2;
                                                    $('input#arFilter_KKAL_MAX').val(value1);
                                                }
                                                $('#slider-range_kkal').slider('values', 1, parseFloat(value1));
                                            });"
                                            />
                                    </td>
                                    <td>
                                        <input
                                            class="max-price"
                                            type="text"
                                            name="arFilter_KKAL_MAX"
                                            id="arFilter_KKAL_MAX"
                                            value="<?  if ($_GET["arFilter_KKAL_MAX"] != "") { 
                                                    echo $_GET["arFilter_KKAL_MAX"];
                                                } else { 
                                                    echo $arFieldsKKAL["MAX"];
                                                }
                                            ?>"
                                            size="5"
                                            onkeyup="smartFilter.keyup(this)"
                                            onchange="$(function(){
                                                var value1 = $('#arFilter_KKAL_MIN').val();
                                                var value2 = $('#arFilter_KKAL_MAX').val();

                                                if(parseInt(value1) > parseInt(value2)){
                                                    value2 = value1;
                                                    $('input#arFilter_KKAL_MIN').val(value1);
                                                }
                                                $('#slider-range_kkal').slider('values',0,parseFloat(value2));
                                            });"
                                            />
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <? 
                        }
                    }
                }
            }
        ?>
        <div class="filter_name" style="padding-bottom: 20px;">
            <input  class="filter_btn" type="submit" id="set_filter" name="set_filter" value="ОТФИЛЬРОВАТЬ"/>
            <input type="hidden" name="set_filter" value="Y"/>
            <input  class="filter_btn" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>"/>
        </div>
    </form>
    <script>
        function sbmtfrm(){
            $(".smartfilter" ).submit();
        }
    </script>

</div>