<?
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
?>