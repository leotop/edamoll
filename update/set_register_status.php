<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
// проставляем всем пользователям подтвержденную регистрацию
$user = new CUser;
$fields_update = Array( 
	"UF_REGISTERED" => 1, 
);

$filter = Array(
    "ACTIVE"  => "Y"
);
$users_result = CUser::GetList(($by="ID"), ($order="desc"), $filter, array("FIELDS" => array("ID", "EMAIL")));
while ($data = $users_result->Fetch()) {
	if ($data['EMAIL'] != "noemail@edamoll.ru") {
		$user->Update($data['ID'], $fields_update);
	}
}
echo "done";
?>