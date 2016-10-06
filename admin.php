<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("ROBOTS", "noindex, nofollow");
$APPLICATION->SetPageProperty("title", "Edamoll Администрирование");
$APPLICATION->SetTitle("Адинистрирование");
?> <?
 if($USER->IsAdmin()){
CModule::IncludeModule('iblock');

if (isset($_GET["ttl_btn"])) {
	 $PROP = array("LAST" => date('d-m-Y H:i:s'),"VALZ" => $_GET["ttl_val"]);

CIBlockElement::SetPropertyValues(
 12958,
 12,
 $PROP,
 false
);
}

$rs = CIBlockElement::GetList(
   array(), 
   array(
   "IBLOCK_ID" => 12,
	   //   "CODE"=>"sect_prop",
   ),
   false, 
   false,
   array("ID","CODE","PROPERTY_LAST","PROPERTY_VALZ")
);
$arr=array();
while($ar = $rs->GetNext()) {
	$arr[$ar["CODE"]]=$ar["PROPERTY_LAST_VALUE"];
	$arrVal[$ar["CODE"]]=$ar["PROPERTY_VALZ_VALUE"];
}
?>

 <form id="admin_page_form" method="get" action="admin.php"> 
<input type="submit" value="Изменения свойств разделов" name="sect_prop" />
<?	echo('Последний запуск: '); echo($arr["sect_prop"]); ?>
<br />
<input type="submit" value="Просмотр форума" name="forum" />
<?	echo('Последний запуск: '); echo($arr["forum"]); ?>
	 <br />
	 <span>Время жизни куки (дней)</span><br />
<input class="w150" type="text" value="<?=$arrVal["ttl"]?>" name="ttl_val" />
<input class="w150" type="submit" value="Изменить" name="ttl_btn" />
	 <?	echo('Изменен: '); echo($arr["ttl"]); ?><br />
	 <span>Изменение индекса сортировки</span><br />
<input class="w150" type="submit" value="Случайно" name="sort_rnd" />
<input class="w150" type="submit" value="По умолчанию" name="sort_500" />
<?	echo('Изменен: '); echo($arr["sorting"]); ?>
<br />
<input type="submit" value="Создание элементов ИБ бренды" name="brand" />
<?	echo('Последний запуск: '); echo($arr["brand"]); ?>
<br />
<input type="submit" value="Установка соответствий стран и брендов" name="COBR" />
<?	echo('Последний запуск: '); echo($arr["COBR"]); ?>


 </form> 
<br />

 
<br />
 <?
if (isset($_GET["sort_rnd"]) || isset($_GET["sort_500"])) {
	 $PROP = array("LAST" => date('d-m-Y H:i:s'));

$arSelect = Array("ID");
$arFilter = Array("IBLOCK_ID"=> 11);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
$iii=0;
	if (isset($_GET["sort_rnd"])) {echo("Заполнение индексов сортировки случайными значениями");}else{echo("Заполнение индексов сортировки значением 500");}
while($ob = $res->GetNextElement())
{
$iii++;
  $arFields = $ob->GetFields();
	$el=new CIBlockElement;
$gsort=500;
	if (isset($_GET["sort_rnd"])) {$gsort=round(rand(1,500));}
   $newel=array(
      'IBLOCK_ID' => 11,
      'SORT' => $gsort,
   );
 
	if($el->Update($arFields["ID"],$newel)) {}

}
													   echo("<br /> Изменено элементов: ".$iii);


CIBlockElement::SetPropertyValues(
 13373,
 12,
 $PROP,
 false
);
}

if (isset($_GET["brand"])) {
	 $PROP = array("LAST" => date('d-m-Y H:i:s'));


	echo("Создание элементов брендов <br />");

$property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"DESC", "SORT"=>"ASC"), Array("IBLOCK_ID"=>11, "CODE"=>"MARKA"));
$iii=0;
while($enum_fields = $property_enums->GetNext())
{
	if ($enum_fields["VALUE"]<>"" && $enum_fields["VALUE"]<>"&lt;&gt;"){
$arSelect = Array("ID","NAME");
$arFilter = Array("IBLOCK_ID"=> 13,"NAME"=>$enum_fields["VALUE"]);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

if($ob = $res->GetNextElement())
{
	//echo $enum_fields["ID"]." - ".$enum_fields["VALUE"]."<br />";
}
else
				  {
$iii++;
        $arParams = array("replace_space"=>"-","replace_other"=>"-");
        $trans = Cutil::translit($enum_fields["VALUE"],"ru",$arParams);
$el = new CIBlockElement;


$arLoadProductArray = Array(
  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 13,
  "NAME"           => $enum_fields["VALUE"],
  "ACTIVE"         => "Y",            // активен
"CODE"=>$trans
  );

if($PRODUCT_ID = $el->Add($arLoadProductArray))
		echo("Создан бренд: ". $enum_fields["VALUE"]."<br />");
else
  echo "Создание бренда: ". $enum_fields["VALUE"]." Ошибка: ".$el->LAST_ERROR;

				  }
	}


}
	echo("Создано брендов: ".$iii."<br />");
	//echo("<br /> Изменено элементов: ".$iii);


CIBlockElement::SetPropertyValues(
 13682,
 12,
 $PROP,
 false
);
}



if (isset($_GET["sect_prop"])) {
?>
<div>
	Начинаем изменение свойств<br />
<?
CModule::IncludeModule("iblock");
$db_list=CIBlockSection::GetList(
    Array("SORT"=>"ASC"),
    Array("IBLOCK_ID"=>11),
    false,
    Array("ID","NAME","CODE"),
    false
);

  while($ar_result = $db_list->GetNext())
  {
    echo 'Изменены свойства раздела '. $ar_result['ID'].' '.$ar_result['NAME'].' '.$ar_result['CODE'].'<br>';

$arFieldsKKAL=array();
$arFieldsMARKA=array();
$arFieldsSTRANA=array();

$arFieldsSTRANA="";
$gel=CIBlockElement::GetList(
 Array("PROPERTY_MARKA_VALUE"=>"ASC"),
 Array("IBLOCK_ID"=>"11","SECTION_CODE"=>$ar_result['CODE'],"INCLUDE_SUBSECTIONS"=>"Y",">CATALOG_QUANTITY"=>0),
 false,
 false,
 Array("ID","PROPERTY_KKAL","PROPERTY_MARKA","PROPERTY_STRANA")
);
while($ob = $gel->GetNextElement()){ 
 $arFieldz = $ob->GetFields();  
 $arFieldsMARKA[$arFieldz["PROPERTY_MARKA_ENUM_ID"]]=$arFieldz;
 $arFieldsSTRANA[$arFieldz["PROPERTY_STRANA_ENUM_ID"]]=$arFieldz;
		if (trim($arFieldz["PROPERTY_KKAL_VALUE"])!== "" && $arFieldz["PROPERTY_KKAL_VALUE"]!== "&lt;&gt;"){
			//$arFieldsKKAL[$arFieldz["PROPERTY_KKAL_ENUM_ID"]]=$arFieldz;
 $arFieldsKKAL[]=(double)str_replace ( ",", ".", $arFieldz["PROPERTY_KKAL_VALUE"]);};
}
$s="";
?>
	<?foreach($arFieldsMARKA as $val2 => $ar2):?>
	<? if(trim($ar2["PROPERTY_MARKA_VALUE"])!== "" && $ar2["PROPERTY_MARKA_VALUE"]!== "&lt;&gt;") {

	$s.=$val2."|".$ar2["PROPERTY_MARKA_VALUE"]."}";

	}?>
	<?endforeach;?>
<?






	  $s2="";
?>
	<?foreach($arFieldsSTRANA as $val2 => $ar2):?>
	<? if(trim($ar2["PROPERTY_STRANA_VALUE"])!== "" && $ar2["PROPERTY_STRANA_VALUE"]!== "&lt;&gt;") {

	$s2.=$val2."|".$ar2["PROPERTY_STRANA_VALUE"]."}";

	}?>
	<?endforeach;?>
<?
global $USER_FIELD_MANAGER;
$USER_FIELD_MANAGER->Update( 'IBLOCK_11_SECTION', $ar_result['ID'], array(
    'UF_KKAL_MIN'  => min($arFieldsKKAL),'UF_KKAL_MAX'  => max($arFieldsKKAL),'UF_BRANDS'=>$s,'UF_COUNTRY'=>$s2
) ); // boolean

  }

echo("Завершено успешно<br />");
	 $PROP = array("LAST" => date('d-m-Y H:i:s'));
	// "ID" => 12956,
CIBlockElement::SetPropertyValues(
 12956,
 12,
 $PROP,
 false
);
?>
</div>
<?
}

	 if (isset($_GET["forum"])) {
$APPLICATION->IncludeComponent(
	"bitrix:forum",
	"",
	Array(
		"THEME" => "red",
		"SHOW_TAGS" => "Y",
		"SEO_USER" => "Y",
		"SHOW_FORUM_USERS" => "Y",
		"SHOW_SUBSCRIBE_LINK" => "N",
		"SHOW_AUTH_FORM" => "Y",
		"SHOW_NAVIGATION" => "Y",
		"SHOW_LEGEND" => "Y",
		"SHOW_STATISTIC_BLOCK" => array("STATISTIC","BIRTHDAY","USERS_ONLINE"),
		"SHOW_FORUMS" => "Y",
		"SHOW_FIRST_POST" => "N",
		"SHOW_AUTHOR_COLUMN" => "N",
		"TMPLT_SHOW_ADDITIONAL_MARKER" => "",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"PAGE_NAVIGATION_TEMPLATE" => "forum",
		"PAGE_NAVIGATION_WINDOW" => "5",
		"AJAX_POST" => "N",
		"WORD_WRAP_CUT" => "23",
		"WORD_LENGTH" => "50",
		"USE_LIGHT_VIEW" => "Y",
		"SEF_MODE" => "N",
		"CHECK_CORRECT_TEMPLATES" => "Y",
		"FID" => array("1"),
		"USER_PROPERTY" => array(),
		"FORUMS_PER_PAGE" => "10",
		"TOPICS_PER_PAGE" => "10",
		"MESSAGES_PER_PAGE" => "10",
		"TIME_INTERVAL_FOR_USER_STAT" => "10",
		"DATE_FORMAT" => "d.m.Y",
		"DATE_TIME_FORMAT" => "d.m.Y H:i:s",
		"USE_NAME_TEMPLATE" => "N",
		"IMAGE_SIZE" => "500",
		"ATTACH_MODE" => array("NAME"),
		"ATTACH_SIZE" => "90",
		"EDITOR_CODE_DEFAULT" => "N",
		"SEND_MAIL" => "E",
		"SEND_ICQ" => "A",
		"SET_NAVIGATION" => "Y",
		"SET_TITLE" => "N",
		"SET_DESCRIPTION" => "Y",
		"SET_PAGE_PROPERTY" => "Y",
		"USE_RSS" => "N",
		"SHOW_FORUM_ANOTHER_SITE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_TIME_USER_STAT" => "60",
		"CACHE_TIME_FOR_FORUM_STAT" => "3600",
		"SHOW_VOTE" => "N",
		"RATING_ID" => array(),
		"VARIABLE_ALIASES" => Array(
			"FID" => "FID",
			"TID" => "TID",
			"MID" => "MID",
			"UID" => "UID"
		)
	),
false
);

	 $PROP = array("LAST" => date('d-m-Y H:i:s'));
	// "ID" => 12956,

CIBlockElement::SetPropertyValues(
 12957,
 12,
 $PROP,
 false
);

				}

if (isset($_GET["COBR"])) {
CModule::IncludeModule("iblock");
$rsCB = CIBlockElement::GetList(
   array(), 
   array(
   "IBLOCK_ID" => 11,
	   //   "CODE"=>"sect_prop",
   ),
   false, 
   false,
   array("ID","CODE","PROPERTY_MARKA","PROPERTY_STRANA")
);
$arrCB=array();
while($arCB = $rsCB->GetNext()) {
$arrCB[$arCB["PROPERTY_STRANA_ENUM_ID"]][$arCB["PROPERTY_MARKA_ENUM_ID"]]=$arCB["PROPERTY_MARKA_ENUM_ID"];

	//$arr[$ar["CODE"]]=$ar["PROPERTY_LAST_VALUE"];
	//$arrVal[$ar["CODE"]]=$ar["PROPERTY_VALZ_VALUE"];
}
foreach ($arrCB as $key => $val)
{
	//print_r($key);print_r($val);

$arFilter = Array("IBLOCK_ID"=> 14,"NAME"=>$key);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID"));



if($ob = $res->GetNextElement())
{
	$gggg=$ob->GetFields();
	///echo ($gggg["ID"]);
	CIBlockElement::SetPropertyValues($gggg["ID"], 14, $val, "BRANDSID");
}
else
				  {

$el = new CIBlockElement;

$PROP = array();
$PROP[177] = $val;

$arLoadProductArray = Array(
  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 14,
  "PROPERTY_VALUES"=> $PROP,
  "NAME"           => $key,
  "ACTIVE"         => "Y",            // активен
  );

					  $PRODUCT_ID = $el->Add($arLoadProductArray);
				  }

}
		/*


}*/
echo("Установка соответствий стран и брендов УСПЕШНО ЗАВЕРШЕНА");
	 $PROP = array("LAST" => date('d-m-Y H:i:s'));
	// "ID" => 12956,

CIBlockElement::SetPropertyValues(
 18983,
 12,
 $PROP,
 false
);

}

}
else
{
LocalRedirect("/");
}
?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>