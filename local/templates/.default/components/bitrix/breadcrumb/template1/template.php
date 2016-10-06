<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<ul class="breadcrumb-navigation">';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	if ($index > 0) {

		if (htmlspecialcharsex($arResult[$index]["TITLE"])<> $title){
		$strReturn .= '<li><span>&nbsp;&gt;&nbsp;</span></li>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> "" && $index<>$itemSize-1)
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	else
		$strReturn .= '<li>'.$title.'</li>';}
	}
else
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> ""  && $index<>$itemSize-1)
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	else
		$strReturn .= '<li>'.$title.'</li>';
}
}

$strReturn .= '</ul>';
return $strReturn;
?>
