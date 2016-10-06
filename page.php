<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Page");
?>

<?
CModule::IncludeModule("iblock");
function GetPathSection($arAvailGroups, $id)
  {
    if (isset($arAvailGroups[$id]))
      {
        if ($arAvailGroups[$id]["IBLOCK_SECTION_ID"])
          return GetPathSection($arAvailGroups, $arAvailGroups[$id]["IBLOCK_SECTION_ID"]) . " > " . $arAvailGroups[$id]["NAME"];
        else
          return $arAvailGroups[$id]["NAME"];
      }
  }

$arAvailGroups = unserialize(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/TestUtmYandex.txt"));
echo "<pre>" . print_r(GetPathSection($arAvailGroups, 594), 1) . "</pre>";
//echo "<pre>" . print_r($arAvailGroups, 1) . "</pre>";


/*
$CIblockSection=new CIBlockSection();
$CIblockSection->Update(119,array("UF_GOOGLE_PRODUCT"=>"SSSSSSSSS"));
if (($handle = fopen("google_productcat.csv", "r")) !== FALSE)
  {
    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE)
      {
        if(intval($data[1])>0 && $data[2]!="")
          $CIblockSection->Update($data[1],array("UF_GOOGLE_PRODUCT"=>$data[2]));
      }
  }*/
function SendTest($ID)
  {
    $arResult["ORDER_ID"] = $ID;
    $arOrder["ACCOUNT_NUMBER"] = $ID;
    $totalOrderPrice = 5000;
    $SERVER_NAME = "";
    $arUserResult["ORDER_DESCRIPTION"] = "";
    if ($arOrder2 =
       CSaleOrderPropsValue::GetList(array(), array("ORDER_ID" => $arResult["ORDER_ID"]), false, false, array())
    )
      {
        $arrProp = array();
        while ($arVals = $arOrder2->Fetch())
          {
            $arrProp[$arVals["CODE"]] = $arVals["VALUE"];

          }


      }
    CModule::IncludeModule("iblock");
    $dbBasketItems =
       CSaleBasket::GetList(array("NAME" => "ASC"), array("ORDER_ID" => $arResult["ORDER_ID"]), false, false, array());


    $garray = array();
    $Elements = array();
    $discountPrice = 0;

    while ($arBasketItems = $dbBasketItems->Fetch())
      {
        $Elements[] = $arBasketItems;
        $discountPrice += $arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"];

      }

    $strOrderList = '<div>
<table width="100%" cellspacing="10" style="margin-bottom:60px;">
		<tr>
			<td style="color:rgb(94, 94, 94);">
ФИО
</td><td style="width:30px;"></td>
			<td>' . $arrProp["fam"] . " " . $arrProp["name"] . " " . $arrProp["otch"] . '</td>
    <td rowspan="5" style="text-align:right;font-size:14pt;font-weight:bold;width:350px;vertical-align:top;">
    <table width="100%">';
    if (doubleval($discountPrice) > 0)
      {
        $strOrderList .= '
    <tr style="color:red">
      <td align="left">
        <b>СКИДКА:</b>
      </td>
      <td align="right">-' . CurrencyFormat($discountPrice, "RUB") . ' р.</td>
    </tr>';

      }

    $strOrderList .= '<tr>
 <td align="left"><b>СУММА ЗАКАЗА:</b></td>
 <td align="right">' . CurrencyFormat($totalOrderPrice - $arResult["DELIVERY_PRICE"], "RUB") . ' р.</td>
	</tr>';
    if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
      {
        $strOrderList .= '<tr>
			<td align="left">
				<b>СТОИМОСТЬ ДОСТАВКИ:</b>
			</td>
			<td align="right">' . CurrencyFormat($arResult["DELIVERY_PRICE"], "RUB") . ' р.</td>
		</tr>';
      }

    if ($arrProp["card_payment"] == "N")
      {
        $cardPaymentAgreepmentText = 'Нет';
      }
    else
      {
        $cardPaymentAgreepmentText = 'Да';
      }

    $strOrderList .= '<tr><td colspan="2" style="border-top:1px solid black;"></td></tr>
	<tr>
		<td align="left"><b>ОБЩАЯ СТОИМОСТЬ:</b></td>
		<td align="right"><b>' . CurrencyFormat($totalOrderPrice, "RUB") . ' р.</b>
		</td>
	</tr>
</table>

</td>
		</tr>

		<tr>
			<td style="color:rgb(94, 94, 94);">
Номер телефона
			</td><td></td>
			<td>' . $arrProp["tel"] . '</td>
     </tr>

     <tr>
       <td style="color:rgb(94, 94, 94);">
    Email
       </td><td></td>
       <td>' . $arrProp["email"] . '</td>
     </tr>

     <tr>
       <td style="color:rgb(94, 94, 94);">
    Адрес доставки
       </td><td></td>
       <td>' . $arrProp["adres"] . '</td>
     </tr>

     <tr>
       <td style="color:rgb(94, 94, 94);">
    Дата доставки
       </td><td></td>
       <td>' . $arrProp["delivery_date"] . '</td>
     </tr>

     <tr>
       <td style="color:rgb(94, 94, 94);">
    Оплата банковской картой во время доставки
       </td><td></td>
       <td>' . $cardPaymentAgreepmentText . '</td>
     </tr>

     <tr>
       <td style="color:rgb(94, 94, 94);">
    Комментарий к заказу
       </td><td></td>
       <td>' . $arUserResult["ORDER_DESCRIPTION"] . '
			</td>
		</tr>


	</table>
<div>';

//

    CModule::IncludeModule("iblock");

    $strOrderList .= '<table rules="rows" width="100%" style="border-bottom:1px solid black;margin-bottom:60px;"><thead><tr><th></th>';
    $strOrderList .= '<th style="text-align:left;">Название</th><th>Количество/Вес</th><th>Цена за ед.</th>';
    if (doubleval($discountPrice) > 0)
      $strOrderList .= '<th>Скидка</th>';
    $strOrderList .= '<th>Сумма</th></tr></thead><tbody>';

    global $USER;
    $garray = array();
    foreach ($Elements as $arBasketItems)
      {
        $big_picture = "";
        $res2 = CIBlockElement::GetByID($arBasketItems["PRODUCT_ID"]);
        if ($ar_res2 = $res2->GetNext())
          {
            if (!empty($ar_res2["PREVIEW_PICTURE"]))
              $big_picture = 'http://edamoll.ru' . CFile::GetPath($ar_res2["PREVIEW_PICTURE"]);
          }
        $strOrderList2 = "";
        $gsect = "";
        $base_unit = "шт";
        $db_props2 =
           CIBlockElement::GetProperty(11, $arBasketItems["PRODUCT_ID"], array("sort" => "asc"), Array("CODE" => "CML2_BASE_UNIT"));
        if ($ar_props2 = $db_props2->Fetch())
          if ($ar_props2["VALUE"])
            $base_unit = $ar_props2["VALUE"];

        $url = "http://edamoll.ru" . $ar_res2["DETAIL_PAGE_URL"];
        $strOrderList2 .= '<tr>';
        if (!empty($big_picture))
          {
            $strOrderList2 .= "<td style='text-align:center;'><a href='" . $url . "'><img style='max-width:75px;max-height:75px;' src='" . $big_picture . "'/></a></td>";
          }
        else
          {
            $strOrderList2 .= "<td><a href='" . $url . "'><img src='http://edamoll.ru/include/img/no-photo2.png' style='max-width:75px;max-height:75px;'/></a></td>";
          }
        $strOrderList2 .= "<td><a style='width:50px' href='" . $url . "'>" . $arBasketItems["NAME"] . "</a></td>";
        $strOrderList2 .= "<td style='text-align:center;'>" . $arBasketItems["QUANTITY"] . " " . $base_unit . "</td>";

        $strOrderList2 .= '<td style="text-align:center;">';
        $p = $arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"];
        $g_pv = round(100 * ($p - floor($p)));
        if (strlen($g_pv) < 2)
          {
            $g_pv = "0" . $g_pv;
          }
        $strOrderList2 .= '<span>' . floor($p) . '<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">' . $g_pv . '</span></span>';
        $strOrderList2 .= "</td>";
        if (doubleval($discountPrice) > 0)
          {
            $strOrderList2 .= '<td style="text-align:center;color:red">';
            if (intval($arBasketItems["DISCOUNT_PRICE"]) > 0)
              {
                $g_pv =
                   round(100 * ($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"] - floor($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"])));
                if (strlen($g_pv) < 2)
                  {
                    $g_pv = "0" . $g_pv;
                  }
                $strOrderList2 .= '<span>-' . floor($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"]) . '<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">' . $g_pv . '</span></span>';

              }
            $strOrderList2 .= '</td>';
          }

        $summm = $arBasketItems["QUANTITY"] * $arBasketItems["PRICE"];
        $g_pv = round(100 * ($summm - floor($summm)));
        if (strlen($g_pv) < 2)
          {
            $g_pv = "0" . $g_pv;
          }


        $strOrderList2 .= '<td style="text-align:right;font-weight:bold;font-size:16px;">';
        $strOrderList2 .= '<span>' . floor($summm) . '<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">' . $g_pv . '</span></span></td>';

        $strOrderList2 .= "</tr>";

        $garray[$arBasketItems["PRODUCT_ID"]]["SECT"] = $arBasketItems["IBLOCK_SECTION_ID"];
        $garray[$arBasketItems["PRODUCT_ID"]]["HTML"] = $strOrderList2;
      }
    uasort($garray, "sort_p");

    foreach ($garray as $garr)
      {
        $strOrderList .= $garr["HTML"];
      }

    $strOrderList .= "</tbody></table>";
    global $DB;
    //$strOrderList=htmlspecialchars($strOrderList, ENT_QUOTES);
    $arFields = Array(
       "ORDER_ID" => $arOrder["ACCOUNT_NUMBER"],
       "ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
       "ORDER_USER" => ((strlen($arUserResult["PAYER_NAME"]) > 0) ? $arUserResult["PAYER_NAME"] :
             $USER->GetFormattedName(false)),
       "PRICE" => SaleFormatCurrency($totalOrderPrice, $arResult["BASE_LANG_CURRENCY"]),
       //"BCC" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
       "EMAIL" => (strlen($arUserResult["USER_EMAIL"]) > 0 ? $arUserResult["USER_EMAIL"] : $USER->GetEmail()),
       "ORDER_LIST" => $strOrderList,
       "SALE_EMAIL" => COption::GetOptionString("sale", "order_email", "order@" . $SERVER_NAME),
       "DELIVERY_PRICE" => $arResult["DELIVERY_PRICE"],
    );


// To send HTML mail, the Content-type header must be set
    $headersG = 'MIME-Version:1.0' . "\r\n";
    $headersG .= 'Content-type:text/html; charset=cp1251' . "\r\n";

// Additional headers
    $headersG .= 'From:Интернет супермаркет Edamoll <order@edamoll.ru>' . "\r\n";


// Mail it
    custom_mail("proflance@yandex.ru", "Интернет супермаркет Edamoll Новый заказ № " . $arOrder["ACCOUNT_NUMBER"], $strOrderList, $headersG);


  }

//echo COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME);
//SendTest(2745);
//AddSitemapGenerate();
//AddSitemapGenerateSection();
//UpdateExports();
//echo "<pre>" . print_r(exec('php /var/www/edamoll.ru/bitrix/php_interface/include/catalog_export/cron_frame.php 8'), 1) . "</pre>";
//UpdateExports(1);
//UpdateExports(0);
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>