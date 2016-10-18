<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?	CModule::IncludeModule("sale");
	$users = array();
	$user_object = new CUser;
	$user_fields_update = Array( 
		"UF_REGISTERED" => 0, 
	);
	// �������� ������������� �� ��
	$filter = Array(
	    "ACTIVE"  => "Y"
	);
	$rsUsers = CUser::GetList(($by="ID"), ($order="desc"), $filter, array("FIELDS" => array("ID", "EMAIL", "PERSONAL_PHONE")));
	while ($data = $rsUsers->Fetch()) {
		// ���������� ������������� ��� ����� � ��������, �� �� ��� �� �����������
		if (!($data['EMAIL'] == "noemail@edamoll.ru" && !$data['PERSONAL_PHONE'])) {
			$users[$data['ID']] = $data;
			$phone = $users[$data['ID']]['PERSONAL_PHONE'];
			// ������� ����� �� +()-
			$phone = preg_replace("/\D/", "", $phone);
			// �������� ������� �� ������ 9 ��� 4, � 4 ��� ���������� ������
			if ($phone[0] != "9" && $phone[0] != "4") {
				$phone = preg_replace("/.+?(?=9)/", "", $phone, 1);
			}
			$users[$data['ID']]['PERSONAL_PHONE'] = $phone;	
		}
	}
	
	$grouped_users = array();
	foreach ($users as $user) {
		// ���� ���� email, �� ���������� �� ����
		if ($user['EMAIL']) {
			if (!$grouped_users[$user['EMAIL']]) {
				$grouped_users[$user['EMAIL']] = array();
			}
			$grouped_users[$user['EMAIL']][$user['ID']] = $user;
		} else if ($user['PERSONAL_PHONE']) {
			// ���� ��� email, �� ���� �������, �� ��������� �� ����
			if (strlen($user['PERSONAL_PHONE']) == 10) {
				if (!$grouped_users[$user['PERSONAL_PHONE']]) {
					$grouped_users[$user['PERSONAL_PHONE']] = array();
				}
				$grouped_users[$user['PERSONAL_PHONE']][$user['ID']] = $user;
			}
		}
	}
	
	// �������� ������, ���������� �� ID ������������
	$grouped_orders = array();
	$arFilter = Array();
	$rsSales = CSaleOrder::GetList(array("ID" => "ASC"), $arFilter, false, false, array("ID", "USER_ID", "DATE_INSERT"));
	while ($arSales = $rsSales->Fetch()) {
		if (!$grouped_orders[$arSales['USER_ID']]) {
			$grouped_orders[$arSales['USER_ID']] = array();
		}
		array_push($grouped_orders[$arSales['USER_ID']], $arSales);
	}

	// ����������� ������ � ��������������� �� email/���������
	foreach ($grouped_users as $mail => $accounts) {
		// ���� � ������������ ��������� ���������, �� ��� ����� �������������
		if (count($accounts) > 1) {
			// ���������� id ���� ��� �����, ��� ����������� ������ ������, ��������� ����� �������
			$grouped_users[$mail]['ids'] = array_keys($accounts);
			// ������ ��� ��� �������
			$grouped_users[$mail]['orders'] = array();
			foreach (array_keys($accounts) as $id) {
				if (is_array($grouped_orders[$id])) {
					$grouped_users[$mail]['orders'] = array_merge($grouped_users[$mail]['orders'], $grouped_orders[$id]);	
				}
			}
			// �����, ����� ��� ��� �������, �������� ��������� ������ � ������� �������������
			if (count($grouped_users[$mail]['orders'])) {
				// ���� ���� ������������� ������
				// �������� ���, � �������� �� ����� ����������� ��� ������, ��������� �������
				$main_user_account = array_shift($grouped_users[$mail]['ids']);
				foreach ($grouped_users[$mail]['ids'] as $id_to_delete) {
					CUser::Delete($id_to_delete);
				}
				// ���������� ������ � ��������� ��
				foreach ($grouped_users[$mail]['orders'] as $order) {
					CSaleOrder::Update($order['ID'], array("USER_ID" => $main_user_account));
				}
				// �.�. ���� ������������ ����������� ������, �� ������������ ����, ��� �� ���������������
				$user_object->Update($main_user_account, $user_fields_update);
			}
		}
	}
?>