<?
$arSelect = Array("ID");
$arFilter =
   Array(
     "IBLOCK_ID" => 11,
     ">PROPERTY_DISCOUNTS" => "0",
   );
$resultProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
if ($DbProduct = $resultProduct->Fetch())
{
?> <a href="/discount/" ><button style="background-image: none; background-attachment: scroll; background-color: rgb(255, 0, 57); height: 38px; width: 150px; border: medium none; background-position: 0% 0%; background-repeat: repeat repeat;" class="whitetext">скидки %</button></a> <br ><br ><?
}
/*
<a href="/happy_new_year/" ><button style="background-image: none; background-attachment: scroll; background-color: rgb(255, 0, 57); height: 38px; width: 150px; border: medium none; background-position: 0% 0%; background-repeat: repeat repeat;" class="whitetext">НОВЫЙ ГОД</button></a>
*/ 
?>  

