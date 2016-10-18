<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?	
	$user_object = new CUser;

	$filter = Array(
	    "ACTIVE"         => "Y",
	    "PERSONAL_PHONE" => "_"
	);
	// �������� �������������
	$users = CUser::GetList(
		($by = "ID"),
		($order = "desc"),
		$filter,
		array (
			"FIELDS" => array("ID", "PERSONAL_PHONE")
		)
	);
	while ($data = $users->Fetch()) {
		$phone = preg_replace("/\D/", "", $data['PERSONAL_PHONE']);
		// �������� ������� �� ������ 9 ��� 4, � 4 ��� ���������� ������
		if ($phone[0] != "9" && $phone[0] != "4") {
			$phone = preg_replace("/.+?(?=9|4)/", "", $phone, 1);
		}
		if (strlen($phone) != 10) {
			$phone = "";
		}
		$fields = Array( 
			"PERSONAL_PHONE" => $phone 
		);
		$user_object->Update($data['ID'], $fields);
	}
?>