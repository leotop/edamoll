<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
<?
$head = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';

$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","DETAIL_PAGE_URL","timestamp_x");
$arFilter = Array("IBLOCK_ID"=>11,);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
  {
    $arFields = $ob->GetFields();
   // echo '<pre>'.print_r($arFields).'</pre>';
  $text .='<url>
<loc>http://edamoll.ru'.$arFields["DETAIL_PAGE_URL"].'</loc>
</url>';
  }
$footer = '</urlset>';
file_put_contents($_SERVER["DOCUMENT_ROOT"]."/sitemap_112.xml",$head.$text.$footer);

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>