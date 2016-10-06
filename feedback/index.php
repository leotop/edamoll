<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Edamoll - Обратная связь");
?>

<div class="sidebar">			 
  <div id="left-menu"> <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"edamoll_left_menu",
	Array(
		"ROOT_MENU_TYPE" => "left",
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array()
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'Y'
)
);?> 			</div>
 			</div>
			<?
				//Т.к. bitrix не поддерживает валидаторы для проверки на заполненность одного из двух полей, было решено добавить валидацию в компонент формы.
				//Соответственно, код находится в компоненте custom:form.result.new на строках 168-174
			?>
<?$APPLICATION->IncludeComponent("custom:form","feedback",Array(
		"AJAX_MODE" => "N", 
		"SEF_MODE" => "Y", 
		"WEB_FORM_ID" => "1", 
		"RESULT_ID" => $_REQUEST["RESULT_ID"], 
		"START_PAGE" => "new", 
		"SHOW_LIST_PAGE" => "&#210;", 
		"SHOW_EDIT_PAGE" => "&#210;", 
		"SHOW_VIEW_PAGE" => "Y", 
		"SUCCESS_URL" => "success.php?id=#RESULT_ID#", 
		"SHOW_ANSWER_VALUE" => "Y", 
		"SHOW_ADDITIONAL" => "Y", 
		"SHOW_STATUS" => "Y", 
		"EDIT_ADDITIONAL" => "Y", 
		"EDIT_STATUS" => "Y", 
		"NOT_SHOW_FILTER" => Array(), 
		"NOT_SHOW_TABLE" => Array(), 
		"CHAIN_ITEM_TEXT" => "", 
		"CHAIN_ITEM_LINK" => "", 
		"IGNORE_CUSTOM_TEMPLATE" => "Y", 
		"USE_EXTENDED_ERRORS" => "Y", 
		"CACHE_TYPE" => "A", 
		"CACHE_TIME" => "3600", 
		"AJAX_OPTION_JUMP" => "N", 
		"AJAX_OPTION_STYLE" => "Y", 
		"AJAX_OPTION_HISTORY" => "N", 
		"SEF_FOLDER" => "/feedback/", 
		"SEF_URL_TEMPLATES" => Array(
			"new" => "",
			"list" => "list/",
			"edit" => "edit/#RESULT_ID#/",
			"view" => "view/#RESULT_ID#/"
		),
		"VARIABLE_ALIASES" => Array(
			"new" => Array(),
			"list" => Array(),
			"edit" => Array(),
			"view" => Array(),
		)
	)
);?>

 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>