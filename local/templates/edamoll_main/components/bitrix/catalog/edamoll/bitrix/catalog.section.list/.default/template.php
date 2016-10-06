<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="edamoll_menu_left">
    <?
        $pictline="";
        $TOP_DEPTH = $arResult["SECTION"]["DEPTH_LEVEL"];
        $TOP_DEPTH=1;
        $CURRENT_DEPTH = $TOP_DEPTH;
        $flag="";
        foreach ($arResult["SECTIONS"] as $arSection) {
            $sectionElementsCount = CIBlockSection::GetSectionElementsCount(
                $arSection["ID"],
                array()
            );
            if (intval($sectionElementsCount) != 0) {
                if ($arSection["DEPTH_LEVEL"] < 3 || $flag == "Y") {
                    if ( $arSection["DEPTH_LEVEL"] == 2 ){
                        $flag = "";
                    }
                    $this->AddEditAction(
                        $arSection['ID'], 
                        $arSection['EDIT_LINK'], 
                        CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT")
                    );
                    $this->AddDeleteAction(
                        $arSection['ID'], 
                        $arSection['DELETE_LINK'], 
                        CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), 
                        array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'))
                    );
                    if ($CURRENT_DEPTH < $arSection["DEPTH_LEVEL"]) {
                        echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH),"<ul>";
                    } elseif ($CURRENT_DEPTH == $arSection["DEPTH_LEVEL"]) {
                        echo "</li>";
                    } else {
                        while($CURRENT_DEPTH > $arSection["DEPTH_LEVEL"]) {
                            echo "</li>";
                            echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
                            $CURRENT_DEPTH--;
                        }
                        echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</li>";
                    }
                    echo "\n",str_repeat("\t", $arSection["DEPTH_LEVEL"]-$TOP_DEPTH);
                ?>
                <li class="item-text <?
                        if ($arSection["DEPTH_LEVEL"] == 1) { 
                            echo('blacktext'); 
                        }
                    ?>" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                <a class="<?
                        if ($arParams["G_SECTION_CODE"] == $arSection["CODE"]) {
                            echo("active");
                        }
                    ?>" href="<?=$arSection["SECTION_PAGE_URL"]?>">
                    <?
                        if ($arSection["DEPTH_LEVEL"] == 3) {
                            echo(' - ');
                        }
                    ?>
                    <?=$arSection["NAME"]?>
                    <?
                        if($arParams["COUNT_ELEMENTS"]) {
                        ?>
                        &nbsp;(<?=$arSection["ELEMENT_CNT"]?>)
                        <?
                        }
                    ?>
                </a>
                <?
                    $big_picture = $arSection["PICTURE"]["SRC"];
                    $gact="";
                    if ($arParams["G_SECTION_CODE"] == $arSection["CODE"]) {
                        $gact=" pictact";
                    }
                    if ($big_picture <> "") {
                        $pictline.='<div class="pict_cont"><a href="'.$arSection['SECTION_PAGE_URL'].'"><div class="picto'.$gact.'" style="background-image:url('.
                        $big_picture.')"> </div><div class="pict_name">'.$arSection['NAME'].'</div></a></div>';
                    }
                    $CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];
                    if ($arParams["G_SECTION_CODE"] == $arSection["CODE"] || $arParams["G_SECTION_CODE2"] == $arSection["CODE"]) {
                        $flag="Y";
                    }
                }
            }
        }

        while($CURRENT_DEPTH > $TOP_DEPTH)
        {
            echo "</li>";
            echo "\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH),"</ul>","\n",str_repeat("\t", $CURRENT_DEPTH-$TOP_DEPTH-1);
            $CURRENT_DEPTH--;
        }
    ?>
</div>



