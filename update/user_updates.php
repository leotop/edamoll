<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?	CModule::IncludeModule("sale");
	$users = array();
	$user_object = new CUser;
	$user_fields_update = Array( 
		"UF_REGISTERED" => 0, 
	);
	// собираем пользователей из БД
	$filter = Array(
	    "ACTIVE"  => "Y"
	);
	$rsUsers = CUser::GetList(($by="ID"), ($order="desc"), $filter, array("FIELDS" => array("ID", "EMAIL", "PERSONAL_PHONE")));
	while ($data = $rsUsers->Fetch()) {
		// выкидываем пользователей без мейла и телефона, их мы уже не сгруппируем
		if (!($data['EMAIL'] == "noemail@edamoll.ru" && !$data['PERSONAL_PHONE'])) {
			$users[$data['ID']] = $data;
			$phone = $users[$data['ID']]['PERSONAL_PHONE'];
			// очищаем номер от +()-
			$phone = preg_replace("/\D/", "", $phone);
			// обрезаем телефон до первой 9 или 4, с 4 это московские номера
			if ($phone[0] != "9" && $phone[0] != "4") {
				$phone = preg_replace("/.+?(?=9)/", "", $phone, 1);
			}
			$users[$data['ID']]['PERSONAL_PHONE'] = $phone;	
		}
	}
	
	$grouped_users = array();
	foreach ($users as $user) {
		// если есть email, то группируем по нему
		if ($user['EMAIL']) {
			if (!$grouped_users[$user['EMAIL']]) {
				$grouped_users[$user['EMAIL']] = array();
			}
			$grouped_users[$user['EMAIL']][$user['ID']] = $user;
		} else if ($user['PERSONAL_PHONE']) {
			// если нет email, но есть телефон, то групируем по нему
			if (strlen($user['PERSONAL_PHONE']) == 10) {
				if (!$grouped_users[$user['PERSONAL_PHONE']]) {
					$grouped_users[$user['PERSONAL_PHONE']] = array();
				}
				$grouped_users[$user['PERSONAL_PHONE']][$user['ID']] = $user;
			}
		}
	}
	
	// собираем заказы, группируем по ID пользователя
	$grouped_orders = array();
	$arFilter = Array();
	$rsSales = CSaleOrder::GetList(array("ID" => "ASC"), $arFilter, false, false, array("ID", "USER_ID", "DATE_INSERT"));
	while ($arSales = $rsSales->Fetch()) {
		if (!$grouped_orders[$arSales['USER_ID']]) {
			$grouped_orders[$arSales['USER_ID']] = array();
		}
		array_push($grouped_orders[$arSales['USER_ID']], $arSales);
	}

	// прикрепляем заказы к отсортированным по email/телефонам
	foreach ($grouped_users as $mail => $accounts) {
		// если у пользователя несколько аккаунтов, то его нужно сгруппировать
		if (count($accounts) > 1) {
			// записываем id всех его акков, нам понадобится только первый, остальные будут удалены
			$grouped_users[$mail]['ids'] = array_keys($accounts);
			// массив для его заказов
			$grouped_users[$mail]['orders'] = array();
			foreach (array_keys($accounts) as $id) {
				if (is_array($grouped_orders[$id])) {
					$grouped_users[$mail]['orders'] = array_merge($grouped_users[$mail]['orders'], $grouped_orders[$id]);	
				}
			}
			// здесь, когда уже все собрано, начинаем обновлять заказы и удалять пользователей
			if (count($grouped_users[$mail]['orders'])) {
				// если есть прикрепленный заказы
				// основной акк, к которому мы будем привязывать все заказы, остальные удаляем
				$main_user_account = array_shift($grouped_users[$mail]['ids']);
				foreach ($grouped_users[$mail]['ids'] as $id_to_delete) {
					CUser::Delete($id_to_delete);
				}
				// перебираем заказы и обновляем их
				foreach ($grouped_users[$mail]['orders'] as $order) {
					CSaleOrder::Update($order['ID'], array("USER_ID" => $main_user_account));
				}
				// т.к. этот пользователь искуственно создан, то деактивируем поле, что он зарегистрирован
				$user_object->Update($main_user_account, $user_fields_update);
			}
		}
	}
?>