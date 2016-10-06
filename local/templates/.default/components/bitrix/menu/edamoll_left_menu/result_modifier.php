<?
    if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
        die();

    //determine if child selected

    $bWasSelected = false;
    $arParents = array();
    $depth = 1;
    foreach($arResult as $i=>$arMenu)
    {
        $depth = $arMenu['DEPTH_LEVEL'];

        if($arMenu['IS_PARENT'] == true)
        {
            $arParents[$arMenu['DEPTH_LEVEL']-1] = $i;
        }
        elseif($arMenu['SELECTED'] == true)
        {
            $bWasSelected = true;
            break;
        }
    }

    if($bWasSelected)
    {
        for($i=0; $i<$depth-1; $i++)
            $arResult[$arParents[$i]]['CHILD_SELECTED'] = true;
    }

    //Check catalog section is empty
    foreach ($arResult as $sectionKey => $sectionValue) {
        if (!empty($sectionValue["PARAMS"])) {
            $sectionCode = str_replace('/', '', $sectionValue["LINK"]);
            $obSection = CIBlockSection::GetList(
                array("SORT" => "asc"), 
                array("CODE" => $sectionCode),
                false, 
                array()
            );
            $arSection = $obSection->Fetch();
            $sectionElementsCount = CIBlockSection::GetSectionElementsCount(
                $arSection["ID"],
                array()
            );
            if (intval($sectionElementsCount) === 0) {
                unset($arResult[$sectionKey]);
            }
        }
    }

    //arshow($arResult);
?>
