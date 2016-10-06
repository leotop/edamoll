<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

function sort_p($a, $b)
{
	return strcmp($a["SECT"], $b["SECT"]);
}

if(!CModule::IncludeModule("sale"))
	$arErrors[] = "Не удалось подключить модуль продаж";
if (!CModule::IncludeModule("statistic"))
	$arErrors[] = "Не удалось подключить модуль статистики";
if (!CModule::IncludeModule("catalog"))
	$arErrors[] = "Не удалось подключить модуль каталога";
if (!CModule::IncludeModule("iblock"))
	$arErrors[] = "Не удалось подключить модуль инфоблоков";

//$query = $_POST["order"];
//print_r($query);
//Тестовый JSON-запрос
$query = '{
	"token":"4F25GGsgdgG45Kjg538sdf2324",
	"name":"",
	"email":"",
	"adress":"",
	"phone":"+77777777777",
	"items":[
		{
			"id":19113,
			"quantity":1,
			"price":"512"
		},
		{
			"id":8457,
			"quantity":1,
			"price":"39"
		},
		{
			"id":11122,
			"quantity":1,
			"price":"101"
		}
	]
}';

/*$file = fopen ($_SERVER['DOCUMENT_ROOT']."/api/v1/order/log.txt","a+");
var_dump($file);
 if ( !$file )
  {
    echo("Ошибка открытия файла");
  }
  else
  {
    fputs ( $file, $query);
  }
  fclose ($file);*/

/*$query2 = Array
(
    [order] => {
    "token":"4F25GGsgdgG45Kjg538sdf2324",
    "name":"test",
    "email":"test@mail.ru",
    "adress":"testttt",
    "phone":"+72342444444",
    "items":[
    {"id":8613,"quantity":1,"price":"63"},
    {"id":19253,"quantity":1,"price":"152"},
    {"id":17704,"quantity":1,"price":"96"},
    {"id":17605,"quantity":1,"price":"101"},
    {"id":3842,"quantity":1,"price":"155"},
    {"id":17546,"quantity":1,"price":"32"}
    ]}
)*/

$query = iconv("cp1251", "UTF-8", $query);

$object = json_decode($query, true);

if(!is_array($object) || empty($object))
	echo "Wrong data";

$object["name"] = iconv("UTF-8", "cp1251", $object["name"]); //Небольшой костыль, т.к. json_decode не работает с чем-либо отличным от UTF-8, а весь сайт в ср1251
$object["adress"] = iconv("UTF-8", "cp1251", $object["adress"]);

$order = new EdamollApiMakeOrder();

try{
	$order->createOrder($object["email"], $object["token"]);
	$order->addAdress($object["adress"]);
	$order->addName($object["name"]);
	$order->addPhone($object["phone"]);
} catch(Exception $e) {
	echo $e->getMessage();
	$order->destroyOrder();
	die();
}

try{
	foreach ($object["items"] as $arItem) {
		$order->addItemToOrder($arItem["id"], $arItem["quantity"], $arItem["price"]);
	}
} catch(Exception $e){
	echo $e->getMessage();
	$order->destroyOrder();
	die();
}

$order->makeEmail();
echo "1";



class EdamollApiMakeOrder{
	private $name, $email, $adress, $phone, $token, $company_name;
	private $orderID;
	private $items;

	public function makeEmail(){
		global $USER;
		global $DB;
		$garray=array();

		$strOrderList='<div>
				<table width="100%" cellspacing="10" style="margin-bottom:60px;">
						<tr>
							<td style="color: rgb(94, 94, 94);">
				ФИО
				</td><td style="width:30px;"></td>
							<td>'.
				$this->name.
							'</td>
				<td rowspan="5" style="text-align:right;font-size:14pt;font-weight:bold;width: 350px;vertical-align: top;">
				<table width="100%">
					<tr>
						<td align="left"><b>СУММА ЗАКАЗА:</b></td>
						<td align="right">'.$this->price.' р.</td>
					</tr>';
					
				$strOrderList.='<tr><td colspan="2" style="border-top:1px solid black;"></td></tr>
					<tr>
						<td align="left"><b>ОБЩАЯ СТОИМОСТЬ: </b></td>
						<td align="right"><b>'.$this->price.' р.</b>
						</td>
					</tr>
				</table>

				</td>
						</tr>

						<tr>
							<td style="color: rgb(94, 94, 94);">
				Номер телефона
							</td><td></td>
							<td>'.
				$this->phone.
							'</td>
						</tr>

						<tr>
							<td style="color: rgb(94, 94, 94);">
				Email
							</td><td></td>
							<td>'.
				$this->email.
							'</td>
						</tr>

						<tr>
							<td style="color: rgb(94, 94, 94);">
				Адрес доставки
							</td><td></td>
							<td>'.
				$this->adress.
							'</td>
						</tr>

						<tr>
							<td style="color: rgb(94, 94, 94);">
				Комментарий к заказу
							</td><td></td>
							<td>Заказ с сайта: '.
				$this->company_name.'
							</td>
						</tr>


					</table>
				<div>';


				$strOrderList .= '<table rules="rows" width="100%" style="border-bottom:1px solid black;margin-bottom:60px;"><thead><tr ><th></th>';
				$strOrderList .= '<th style="text-align: left;">Название</th><th>Количество/Вес</th><th>Цена за ед.</th><th>Сумма</th></tr></thead><tbody>';
				$strOrderList2 = '';

				foreach($this->items as $item){
					$res = CIBlockElement::GetList(
						array("SORT" => "ASC"),
						array("IBLOCK_ID" => "11", "ID" => $item["ID"]),
						false,
						false
						)->GetNextElement();
					$arItem = array_merge($res->GetProperties(), $res->GetFields());

					$big_picture = 'http://edamoll.ru'.CFile::GetPath($arItem["PREVIEW_PICTURE"]);
					$base_unit="шт";

					$strOrderList2 .= '<tr><td style="text-align: center;width:75px;height:75px;">';

					if ($big_picture != 'http://edamoll.ru'){
						$strOrderList2 .='<img style="max-width:75px;max-height:75px;" src="'.$big_picture.'"/>';
					} else {
						$strOrderList2 .='<img src="http://edamoll.ru/include/img/no-photo.png" style="max-width:75px;max-height:75px;"/>';
					}

					$strOrderList2 .= "</td>";
					$strOrderList2 .= "<td>".  $arItem["NAME"]."</td>";
					$strOrderList2 .= "<td style='text-align: center;'>".$arItem["QUANTITY"]." ".$base_unit."</td>";
					$strOrderList2 .= '<td style="text-align: center;">';

					$g_pv=round(100*($item["PRICE"]-floor($item["PRICE"])));

					if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}
					$strOrderList2 .= '<span>'.floor($item["PRICE"]).'<span style="vertical-align: 0.3em;font-size: 70%;margin-left:4px;">'.$g_pv.'</span></span></td>';

					$summm=$item["QUANTITY"]*$item["PRICE"]; $g_pv=round(100*($summm-floor($summm)));
					if (strlen($g_pv)<2) {$g_pv=$g_pv."0";}


					$strOrderList2 .= '<td style="text-align: right;font-weight:bold;font-size:16px;">';
					$strOrderList2 .='<span>'.floor($summm).'<span style="vertical-align: 0.3em;font-size: 70%;margin-left:4px;">'.$g_pv.'</span></span></td>';

					$strOrderList2 .= "</tr>";

					$garray[$arItem["PRODUCT_ID"]]["SECT"]=$arItem["IBLOCK_SECTION_ID"];
					$garray[$arItem["PRODUCT_ID"]]["HTML"]=$strOrderList2;
				}

				uasort($garray, "sort_p");

				foreach($garray as $garr){
					$strOrderList .=$garr["HTML"];
				}

				$strOrderList .= "</tbody></table>";

		$arFields = Array(
			"ORDER_ID" => $this->orderID,
			"ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
			"ORDER_USER" => $this->name,
			"PRICE" => SaleFormatCurrency($this->price, "RUR"),
			"BCC" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
			"EMAIL" => $this->email,
			"ORDER_LIST" => $strOrderList,
			"SALE_EMAIL" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
			"DELIVERY_PRICE" => "0",
			);

		$eventName = "SALE_NEW_ORDER";

		$bSend = true;
		foreach(GetModuleEvents("sale", "OnOrderNewSendEmail", true) as $arEvent)
			if (ExecuteModuleEventEx($arEvent, Array($this->orderID, &$eventName, &$arFields))===false)
				$bSend = false;

			if($bSend)
			{
				$event = new CEvent;
				$event->Send($eventName, SITE_ID, $arFields, "N");
			}

		//echo $strOrderList;
		
	}

	public function createOrder($email, $token)
	{
		if (empty($token))
			throw new Exception("Empty token", 4);
		if(empty($email))
			$email = "noemail@edamoll.ru";
		$this->email = $email;
		$this->token = $token;
		$this->company_name = $this->checkToken();

		if(empty($this->company_name))
			throw new Exception("Illegal token", 1);

		$this->makeOrder();
	}

	public function getOrderByID($orderID)
	{
		$arOrder = CSaleOrder::GetByID($orderID);
		if(!$arOrder)
			throw new Exception("Can't find order with ID ".$orderID, 1);
			
		$this->orderID = $orderID;

		//TODO
	}

	public function __construct()
	{
		$this->price = 0;
		$this->name = "";
		$this->email = "";
		$this->adress = "";
		$this->token = "";
		$this->orderID = "";
	}


	public function addAdress($adress){
		if(empty($adress))
			$adress="Адрес не указан";
		$this->adress = $adress;
		$this->addSaleProps($this->orderID, "6", "Адрес доставки", "adres", $adress);
	}

	public function addName($name){
		if(empty($name))
			$name="Имя не указано";
		$this->name = $name;
		$this->addSaleProps($this->orderID, "7", "Имя", "name", $name);
	}

	public function addPhone($phone){
		if(empty($phone))
			throw new Exception("Empty phone", 5);
		$this->phone = $phone;
		$this->addSaleProps($this->orderID, "5", "Номер телефона", "tel", $phone);
	}

	private function addSaleProps($order, $propID, $propName, $propCode, $value){
		$arFields = array(
			"ORDER_ID" => $order,
			"ORDER_PROPS_ID" => $propID,
			"NAME" => iconv("UTF-8", "cp1251", $propName),
			"CODE" => $propCode,
			"VALUE" => $value
			);
		CSaleOrderPropsValue::Add($arFields);
	}

	private function createTempUser()
	{
		global $USER;
		$arRegisterResult = $USER->SimpleRegister($this->email); //Создаем пользователя по емейлу, т.к. битрикс не поддерживает заказы без привязки к пользователям
		if($arRegisterResult["TYPE"] != "OK")
			throw new Exception("Can't create temp user with this email", 1);
	}

	private function makeOrder()
	{
		GLOBAL $USER;
		$this->createTempUser();

		$arSaleFields = array(
			"LID" => "s1",
			"PERSON_TYPE_ID" => 1,
			"USER_ID" => $USER->GetID(),
			"PAYED" => "N",
			"CURRENCY" => "RUB",
			"CANCELED" => "N",
			"STATUS_ID" => "N",
			"PRICE" => 0,
			"STAT_GID" => CStatistic::GetEventParam(),
			"EMAIL" => $this->email,
			"USER_DESCRIPTION" => $this->company_name
			);
		$orderID = CSaleOrder::Add($arSaleFields);
		if(!$orderID)
			throw new Exception("Can't create order", 1);
			
		$this->orderID = IntVal($orderID);
		$this->addSaleProps($orderID, "1", "Email", "email", $this->email);
	}

	private function checkToken(){
		$arFilter = array(
			"IBLOCK_ID" => "15",
			"SERVICE_TOKEN" => $this->token
			);
		$arSelect = array("ID", "NAME", "SERVICE_TOKEN");
		$res = CIBlockElement::GetList(array(), $arFilter, false, array(), $arSelect);
		if ($ob = $res->GetNextElement()){
			return $ob->fields["NAME"];
		}
		return false;
	}

	public function addItemToOrder($id, $quantity, $price)
	{
		$arItem["ID"] = $id;
		$arItem["QUANTITY"] = $quantity;
		$arItem["PRICE"] = $price;

		$this->items[] = $arItem;
		
		if (!Add2BasketByProductID($id, $quantity, array())) {
			throw new Exception("Can't add item to basket", $id);
		}
		
		$this->price += $quantity*$price;
		$this->updateOrderPrice($this->price);
		CSaleBasket::OrderBasket($this->orderID);
	}

	public function updateOrderPrice($price)
	{
		CSaleOrder::Update($this->orderID, array("PRICE"=>$price));
	}

	public function destroyOrder(){
		CSaleOrder::Delete($this->orderID);
	}
}

?> 
