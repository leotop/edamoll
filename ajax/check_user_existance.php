<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?	global $USER;

	$user_mail = $_POST['mail'];
	$user_phone = $_POST['phone'];
	$user_name = trim(iconv('utf-8', 'windows-1251', $_POST['name']));
	
	if (strlen($user_phone) >= 10) {
		$user_phone = preg_replace("/\D/", "", $user_phone);
		// обрезаем телефон до первой 9 или 4, с 4 это московские номера
		if ($user_phone[0] != "9" && $user_phone[0] != "4") {
			$user_phone = preg_replace("/.+?(?=9)/", "", $user_phone, 1);
		}
	}
	
	if (($user_mail || $user_phone) && !$USER->IsAuthorized()) {
		if ($user_mail && $user_mail != "noemail@edamoll.ru") {
			$filter = Array(
			    "ACTIVE" => "Y",
			    "EMAIL"  => $user_mail
			);
		} else if (strlen($user_phone) == 9) {
			$filter = Array(
			    "ACTIVE"         => "Y",
			    "PERSONAL_PHONE" => "%" . $user_phone . "%"
			);
		}
		// выбираем пользователей
		$users = CUser::GetList(
			($by = "ID"),
			($order = "desc"),
			$filter,
			array (
				"FIELDS" => array("ID"),
				"SELECT" => array("UF_REGISTERED")
			)
		);
		if ($data = $users->Fetch()) {
			$user_confirmed_registration = $data['UF_REGISTERED'];
		}
		
		if (!$user_confirmed_registration) {
			// если он не подтвержден, то обновляем его данные и авторизуем
			$user_object = new CUser;
			$user_fields_update = Array(
				"NAME" => $user_name,
				"UF_REGISTERED" => 1, 
			);
			$user_fields_update = strlen($user_phone) == 9 ? array_merge($user_fields_update, array("PERSONAL_PHONE" => $user_phone)) : $user_fields_update;
			$user_fields_update = $user_mail ? array_merge($user_fields_update, array("EMAIL" => $user_mail)) : $user_fields_update;
			$user_object->Update($data['ID'], $user_fields_update);
		}
		$USER->Authorize($data['ID']);
	}
?>