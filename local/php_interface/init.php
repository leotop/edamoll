<?
    CModule::IncludeModule("iblock");

    function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            } 
        }
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }


    AddEventHandler("catalog", "OnBeforeProductUpdate", array( "ProductEvent", "OnBeforeProductUpdate"));
    AddEventHandler("catalog", "OnBeforeProductAdd", array( "ProductEvent", "OnBeforeProductAdd"));
    AddEventHandler("catalog", "OnSuccessCatalogImport1C", "AddDiscountFor1CImport");
    class ProductEvent {
        function OnBeforeProductAdd(&$arFields) {
            $arFields["QUANTITY_TRACE"] = "N";
        }

        function OnBeforeProductUpdate($ID, &$arFields) {
            $arFields["QUANTITY_TRACE"] = "N";
        }
    }

    AddEventHandler("main", "OnAfterUserLogin", Array( "LogInOut", "OnAfterUserLoginHandler"));
    AddEventHandler("main", "OnAfterUserLogout", Array( "LogInOut", "OnAfterUserLogoutHandler"));
    AddEventHandler('main', 'OnBuildGlobalMenu', 'ASDFavoriteOnBuildGlobalMenu');
    AddEventHandler("sale", "OnOrderNewSendEmail", "OnOrderNewSendEmailHendler");

    function OnOrderNewSendEmailHendler($id, &$eventName, &$arFields)
    {
        ProductRating(intval($arFields["ORDER_ID"]));
        if (CModule::IncludeModule("sale"))
        {
            $id = $arFields["ORDER_ID"];
            $arOrder = CSaleOrder::GetByID($id);
            $arFieldsAdd = array(
                "ORDER_ID" => $id,
                "ORDER_PROPS_ID" => 13,
                "NAME" => "Комментарий покупателя",
                "CODE" => "COMMENTUSER",
                "VALUE" => $arOrder["USER_DESCRIPTION"]
            );
            CSaleOrderPropsValue::Add($arFieldsAdd);
        } 


        $strOrderList .= '<table rules="rows" width="100%" style="border-bottom:1px solid black;margin-bottom:60px;"><thead><tr><th></th>';
        $strOrderList .= '<th style="text-align:left;">Название</th><th>Количество/Вес</th><th>Цена за ед.</th>';
        if (doubleval($discountPrice) > 0)  {
            $strOrderList .= '<th>Скидка</th>';   
        }
        $strOrderList .= '<th>Сумма</th></tr></thead><tbody>';
        global $USER;
        $elementsArrayList = array();

        $dbBasket = CSaleBasket::GetList(
            array("ID" => "ASC"), 
            array("ORDER_ID" => $id)
        );

        while ($arBasketItems = $dbBasket->Fetch()){
            $bigPicture = "";
            $obItemIblock = CIBlockElement::GetByID($arBasketItems["PRODUCT_ID"]);
            if($arItemIblock = $obItemIblock->GetNext()) {
                if(!empty($arItemIblock["PREVIEW_PICTURE"])) {
                    $bigPicture = "http://".$_SERVER['SERVER_NAME'].CFile::GetPath($arItemIblock["PREVIEW_PICTURE"]);
                }
            }
            $strOrderItems = "";
            $baseUnit = "шт";
            $obProperty = CIBlockElement::GetProperty(
                11, 
                $arBasketItems["PRODUCT_ID"], 
                array("sort" => "asc"), 
                array("CODE" => "CML2_BASE_UNIT")
            );
            if($arProperty = $obProperty->Fetch()) {
                if($arProperty["VALUE"]) {
                    $baseUnit = $arProperty["VALUE"]; 
                }
            }

            $url = "http://".$_SERVER['SERVER_NAME'].$arItemIblock["DETAIL_PAGE_URL"];
            $strOrderItems .= '<tr>';
            if (!empty($bigPicture)) {
                $strOrderItems .= "<td style='text-align:center;'><a href='".$url."'><img style='max-width:75px;max-height:75px;' src='".$bigPicture."'/></a></td>";
            } else {
                $strOrderItems .= "<td><a href='".$url."'><img src='http://edamoll.ru/include/img/no-photo2.png' style='max-width:75px;max-height:75px;'/></a></td>";
            }
            $strOrderItems .= "<td><a style='width:50px' href='".$url."'>".$arBasketItems["NAME"]."</a></td>";
            $strOrderItems .= "<td style='text-align:center;'>".$arBasketItems["QUANTITY"]." ".$baseUnit."</td>";
            $strOrderItems .= '<td style="text-align:center;">';
            $fullPrice = $arBasketItems["PRICE"] + $arBasketItems["DISCOUNT_PRICE"];
            $formatedPrice = round(100 * ($fullPrice - floor($fullPrice)));
            if (strlen($formatedPrice) < 2) {
                $formatedPrice = "0".$formatedPrice;
            }
            $strOrderItems .= '<span>'.floor($fullPrice).'<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">'.$formatedPrice.'</span></span>';
            $strOrderItems .= "</td>";
            if (doubleval($discountPrice) > 0){
                $strOrderItems .='<td style="text-align:center;color:red">';
                if (intval($arBasketItems["DISCOUNT_PRICE"]) > 0)
                {
                    $formatedPrice = round(100 * ($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"] - floor($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"])));
                    if (strlen($formatedPrice) < 2) {
                        $formatedPrice = "0".$formatedPrice;
                    }
                    $strOrderItems .= '<span>-'.floor($arBasketItems["QUANTITY"] * $arBasketItems["DISCOUNT_PRICE"]).'<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">'.
                    $formatedPrice.'</span></span>';
                }
                $strOrderItems .='</td>';
            }

            $summm = $arBasketItems["QUANTITY"] * $arBasketItems["PRICE"]; 
            $formatedPrice = round(100 * ($summm - floor($summm)));
            if (strlen($formatedPrice) < 2) {
                $formatedPrice = "0".$formatedPrice;
            }

            $strOrderItems .= '<td style="text-align:right;font-weight:bold;font-size:16px;">';
            $strOrderItems .= '<span>'.floor($summm).'<span style="vertical-align:0.3em;font-size:70%;margin-left:4px;">'.$formatedPrice.'</span></span></td>';
            $strOrderItems .= "</tr>";

            $elementsArrayList[$arBasketItems["PRODUCT_ID"]]["SECT"] = $arBasketItems["IBLOCK_SECTION_ID"];
            $elementsArrayList[$arBasketItems["PRODUCT_ID"]]["HTML"] = $strOrderItems;
        }
        uasort($elementsArrayList, "sort_p");

        foreach($elementsArrayList as $elementArray) {
            $strOrderList .= $elementArray["HTML"];
        }
        $strOrderList .= "</tbody></table>";
        $arFields["ORDER_LIST"] = $strOrderList;
        return $arFields;
    }

    function ASDFavoriteOnBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
    {
        foreach ($aModuleMenu as $k => $v)
        {
            if ($v['parent_menu'] == 'global_menu_store' && $v['icon'] == 'sale_menu_icon_orders')
            {
                if (!strlen($aModuleMenu[$k]['items_id']))
                    $aModuleMenu[$k]['items_id'] = 'asd_fav_menu_icon';
                if (empty($aModuleMenu[$k]['items']))
                {
                    $aModuleMenu[$k]['items'] = array();
                    $aModuleMenu[$k]['items'][] = Array(
                        'text' => $aModuleMenu[$k]['text'],
                        'title' => $aModuleMenu[$k]['title'],
                        'url' => $aModuleMenu[$k]['url'],
                        'more_url' => $aModuleMenu[$k]['more_url'],
                    );
                    unset($aModuleMenu[$k]['more_url']);
                }
                $aModuleMenu[$k]['items'][] = Array(
                    'text' => GetMessage('iblock_element_rating'),
                    'title' => GetMessage('iblock_element_rating'),
                    'url' => 'iblock_element_rating.php?IBLOCK_ID=11&type=1c_catalog&lang=ru&find_el_y=Y&by=PROPERTY_183&order=desc',
                    'more_url' => array('iblock_element_rating.php?IBLOCK_ID=11&type=1c_catalog&lang=ru&find_el_y=Y&by=PROPERTY_183&order=desc'),
                );
                break;
            }
        }
    }

    global $SorPagePararms, $SorPagePararmsOrder;
    $SorPagePararms = "SORT";
    if (isset($_GET["BY"]))
    {
        $SorPagePararmsOrder = "desc";
    }
    else $SorPagePararmsOrder = "asc";
    if (isset($_GET["SORT"]))
    {
        switch ($_REQUEST["SORT"])
        {
            case "PRICE":
                $SorPagePararms = "CATALOG_PRICE_2";
                break;
            case "RATING":
                $SorPagePararms = "PROPERTY_RATING";
                break;
            case "DISCOUNT":
                $SorPagePararms = "PROPERTY_DISCOUNTS";
                break;

        }
    }
    /*
    class LogInOut
    {
        // ??????? ?????????? ??????? "OnAfterUserLogin"
        function OnAfterUserLoginHandler(&$fields)
        {
            // ???? ????? ?? ??????? ??
            if ($fields['USER_ID'] > 0 && $fields['USER_ID'] <> 1 && $fields['USER_ID'] <> 205)
            {
                LocalRedirect("/");
            }
        }

        function OnAfterUserLogoutHandler($arParams)
        {
            LocalRedirect("/");
        }

    }
             */
    AddEventHandler("main", "OnBeforeUserRegister", Array(
        "NewUserReg",
        "OnAfterUserRegisterHandler"
    ));
    class NewUserReg
    {
        function OnAfterUserRegisterHandler(&$arFields)
        {
            $arEventFields = array(
                "LOGIN" => $arFields["LOGIN"],
                "NAME" => $arFields["NAME"],
                "EMAIL" => $arFields["EMAIL"],
            );
            CEvent::Send("USER_INFO", SITE_ID, $arEventFields, "N", 68);
        }
    }

    function AddDiscountFor1CImport()
    {
        CModule::IncludeModule("iblock");
        CModule::IncludeModule("catalog");

        global $APPLICATION;
        $arElements = array();
        $file = $_SERVER["DOCUMENT_ROOT"] . "/upload/1c_catalog/offers.xml";

        if (file_exists($file))
        {

            $xml = simplexml_load_file($file);
            $count = 0;
            foreach ($xml->xpath('/КоммерческаяИнформация/ПакетПредложений/Предложения/Предложение') as $producs)
            {

                $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array(
                    "XML_ID" => $producs->Ид,
                    ), false, false, array(
                        "ID"
                ));
                while ($arProductDiscounts = $dbProductDiscounts->Fetch())
                {
                    CCatalogDiscount::Delete($arProductDiscounts["ID"]);
                }

                if (isset($producs->СкидкиНаценки))
                {
                    $response_array = json_decode(json_encode($producs), true);

                    foreach ($response_array["СкидкиНаценки"] as $discount)
                    {

                        $arElements[] = $response_array['Ид'];
                        $arFields = Array(
                            "SITE_ID" => "s1",
                            "ACTIVE" => "Y",
                            "XML_ID" => $response_array['Ид'],
                            "NAME" => utf8win1251($response_array['Наименование']),
                            "MAX_USES" => 0,
                            "COUNT_USES" => 0,
                            "COUPON" => "",
                            "SORT" => 100,
                            "MAX_DISCOUNT" => 0.0000,
                            "VALUE_TYPE" => "P",
                            "VALUE" => $discount['Процент'],
                            "CURRENCY" => "RUB",
                            "MIN_ORDER_SUM" => 0.0000,
                            "NOTES" => "",
                            "RENEWAL" => "N",
                            "ACTIVE_FROM" => date("d.m.Y H:i:s", strtotime("-7 hours")),
                            "ACTIVE_TO" => $discount['ДатаОкончания'],
                            "LAST_DISCOUNT" => "Y",
                            "VERSION" => 2,
                            "CONDITIONS" => Array(
                                "CLASS_ID" => "CondGroup",
                                "DATA" => Array(
                                    "All" => "AND",
                                    "True" => "True",
                                ),

                                "CHILDREN" => Array(
                                    "0" => Array(
                                        "CLASS_ID" => "CondIBXmlID",
                                        "DATA" => Array(
                                            "logic" => "Equal",
                                            "value" => $response_array['Ид']
                                        )
                                    )
                                )

                            ),

                            "UNPACK" => '(($arProduct["XML_ID"] == "' . $response_array['Ид'] . '"))'
                        );
                        if ( /*$count == 0*/
                            true
                        )
                        {
                            // echo "<pre>" . print_r($arFields, 1) . "</pre>";
                            $ID = CCatalogDiscount::Add($arFields);
                            $res = $ID > 0;

                        }
                        $count++;
                    }
                }


            }
        }
        // echo "<pre>" . print_r($count, 1) . "</pre>";
        AddDiscontsForSort();
        AddSitemapGenerate();
        AddSitemapGenerateSection();
        // UpdateExports();
    }

    function UpdateExports($true)
    {

        if (CModule::IncludeModule("catalog") && CModule::IncludeModule("iblock"))
        {
            $arFilter = Array(
                "IBLOCK_ID" => 18,
                "ACTIVE" => "Y",
            );
            $res =
            CIBlockElement::GetList(Array(
                "SORT" => "ASC",
                "PROPERTY_PRIORITY" => "ASC"
                ), $arFilter, Array("NAME"));
            $count = $res->SelectedRowsCount();
            $key = 0;
            $block = intval($count / 2);
            while ($ar_fields = $res->GetNext())
            {
                $key++;
                if ($true)
                {
                    if ($key > $block)
                    {
                        break;
                    }
                }
                else
                {
                    if ($key <= $block)
                    {
                        continue;
                    }
                }


                echo($ar_fields["NAME"]);
                $export_db = CCatalogExport::GetList(array("ID" => "ASC"), array("NAME" => $ar_fields["NAME"]));
                if ($export = $export_db->GetNext())
                {
                    echo($export["ID"] . "\n");

                    exec('php ' . $_SERVER["DOCUMENT_ROOT"] . '/bitrix/php_interface/include/catalog_export/cron_frame.php ' . $export["ID"]);
                    // echo "<pre>" . print_r('php '.$_SERVER["DOCUMENT_ROOT"].'/bitrix/php_interface/include/catalog_export/cron_frame.php '.$export["ID"], 1) . "</pre>";
                    // echo "<pre>" . print_r($export, 1) . "</pre>";

                }
            }
        }

    }

    function AddSitemapGenerateSection()
    {
        CModule::IncludeModule("iblock");
        $text = '';
        $head = '<?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        ';
        $arFilter =
        array(
            'IBLOCK_ID' => 11,
            ACTIVE => "Y"
        ); // выберет потомков без учета активности
        $rsSect = CIBlockSection::GetList(array(), $arFilter);
        while ($arSect = $rsSect->GetNext())
        {

            // получаем подразделы
            $text .= '<url>
            <loc>http://edamoll.ru' . $arSect["SECTION_PAGE_URL"] . '</loc>
            </url>';
            //  echo '<pre>'.print_r($arSect).'</pre>';
        }

        $footer = '</urlset>';
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sitemap_111.xml", $head . $text . $footer);
    }

    function AddSitemapGenerate()
    {
        CModule::IncludeModule("iblock");
        $text = '';
        $head =
        '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $arSelect = Array(
            "ID",
            "NAME",
            "DATE_ACTIVE_FROM",
            "DETAIL_PAGE_URL",
            "timestamp_x"
        );
        $arFilter = Array("IBLOCK_ID" => 11,);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            // echo '<pre>'.print_r($arFields).'</pre>';
            $text .= '<url>
            <loc>http://edamoll.ru' . $arFields["DETAIL_PAGE_URL"] . '</loc>
            </url>';
        }
        $footer = '</urlset>';
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/sitemap_112.xml", $head . $text . $footer);
    }

    function AddDiscontsForSort()
    {
        CModule::IncludeModule("catalog");
        CModule::IncludeModule("iblock");
        global $DB;
        $arSelect = Array("ID");
        $arFilter = Array(
            "IBLOCK_ID" => 11,

        );
        $resultProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($DbProduct = $resultProduct->Fetch())
        {
            CIBlockElement::SetPropertyValuesEx($DbProduct["ID"], false, array("DISCOUNTS" => "0"));
        }
        $arID = array();

        $dbProductDiscounts = CCatalogDiscount::GetList(array("SORT" => "ASC"), array(
            "ACTIVE" => "Y",
            "!>ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
            "!<ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
            "COUPON" => ""
            ), false, false, array(
                "ID",
                "SITE_ID",
                "ACTIVE",
                "ACTIVE_FROM",
                "ACTIVE_TO",
                "RENEWAL",
                "NAME",
                "SORT",
                "MAX_DISCOUNT",
                "VALUE_TYPE",
                "VALUE",
                "CURRENCY",
                "PRODUCT_ID",
                "XML_ID"
        ));
        while ($arProductDiscounts = $dbProductDiscounts->Fetch())
        {

            $res =
            CCatalogDiscount::GetDiscountProductsList(array(), array("DISCOUNT_ID" => $arProductDiscounts["ID"]), false, false, array());
            while ($ob = $res->Fetch())
            {
                $arID[] = array(
                    "v" => $ob["PRODUCT_ID"],
                    "p" => $arProductDiscounts["VALUE"]
                );
                //  $test[]=$ob;
            }

            $res =
            CCatalogDiscount::GetDiscountSectionsList(array(), array("DISCOUNT_ID" => $arProductDiscounts["ID"]), false, false, array());
            while ($ob = $res->Fetch())
            {

                $arSelect = Array("ID");
                $arFilter = Array(
                    "IBLOCK_ID" => 11,
                    "SECTION_ID" => $ob["SECTION_ID"],
                    "INCLUDE_SUBSECTIONS" => "Y"
                );
                $resultProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($DbProduct = $resultProduct->Fetch())
                {
                    $arID[] = array(
                        "v" => $DbProduct["ID"],
                        "p" => $arProductDiscounts["VALUE"]
                    );
                }

            }

            if ($arProductDiscounts["XML_ID"] != "")
            {
                $arSelect = Array("ID");
                $arFilter = Array(
                    "IBLOCK_ID" => 11,
                    "XML_ID" => $arProductDiscounts["XML_ID"]
                );
                $resultProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                while ($DbProduct = $resultProduct->Fetch())
                {
                    $arID[] = array(
                        "v" => $DbProduct["ID"],
                        "p" => $arProductDiscounts["VALUE"]
                    );
                }
            }


        }
        if (count($arID) > 0)
        {
            foreach ($arID as $key => $id)
            {
                CIBlockElement::SetPropertyValuesEx($id["v"], false, array("DISCOUNTS" => intval($id["p"])));

            }
        }
        //file_put_contents($_SERVER["DOCUMENT_ROOT"]."/agenttest.txt",date("d.m.Y H:i:s"));
        return "AddDiscontsForSort();";
    }
    function SendMail($to, $subject, $message, $additionalHeaders = '',$login,$password,$copy=false)
    {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/smtp/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->CharSet = 'cp1251';
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host = "smtp.yandex.ru"; // SMTP server
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->SMTPSecure = "ssl"; // set the SMTP port for the GMAIL server
        $mail->Username = $login; // SMTP account username
        $mail->Password = $password; // SMTP account password
        $mail->SetFrom($login, 'Edamoll.ru');
        $mail->Subject = $subject;
        if (strpos($additionalHeaders, "text/html") !== false)
        {
            $mail->MsgHTML($message);
        }
        else
        {
            $mail->Body = $message;
        }
        $address = $to;
        $mail->AddAddress($address);
        $SERVER_NAME="edamoll.ru";

        if($copy)
        {
            $mail->AddBCC(COption::GetOptionString("sale", "order_email", "order@" . $SERVER_NAME));
        }
        $mail->Send();
    }
    function custom_mail($to, $subject, $message, $additionalHeaders = '')
    {
        $order=false;
        include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/smtp/class.phpmailer.php');

        $mail = new PHPMailer();

        CModule::IncludeModule("iblock");
        $utf=iconv("UTF-8","WINDOWS-1251",$subject);
        if(strpos($additionalHeaders, "text/html") !== false)
        {
            $arIBlockElement = GetIBlockElement(22014);
            $login = $arIBlockElement["PROPERTIES"]["LOGIN"]["VALUE"];
            $password = $arIBlockElement["PROPERTIES"]["PASSWORD"]["VALUE"];
            // file_put_contents($_SERVER["DOCUMENT_ROOT"]."/test1.txt",print_r(base64_decode($subject),1).print_r("ЫЫЫЫЫЫЫЫЫ",1));
            SendMail($to, $subject, $message, $additionalHeaders,$login,$password,true);
        }
        else
        {
            $arIBlockElement = GetIBlockElement(22271);
            $login = $arIBlockElement["PROPERTIES"]["LOGIN"]["VALUE"];
            $password = $arIBlockElement["PROPERTIES"]["PASSWORD"]["VALUE"];
            SendMail($to, $subject, $message, $additionalHeaders,$login,$password,false);
            //   file_put_contents($_SERVER["DOCUMENT_ROOT"]."/test1.txt",print_r($mail->EncodeHeader($subject),1).print_r("BBBBBBBBBBB",1).print_r($subject,1));
        }

        /*CModule::IncludeModule("iblock");
        $arIBlockElement = GetIBlockElement(22014);
        $LOGIN = $arIBlockElement["PROPERTIES"]["LOGIN"]["VALUE"];
        $PASSWORD = $arIBlockElement["PROPERTIES"]["PASSWORD"]["VALUE"];
        include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include/smtp/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->CharSet = 'cp1251';
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host = "smtp.yandex.ru"; // SMTP server
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->SMTPSecure = "ssl"; // set the SMTP port for the GMAIL server
        $mail->Username = $LOGIN; // SMTP account username
        $mail->Password = $PASSWORD; // SMTP account password
        $mail->SetFrom($LOGIN, 'Edamoll.ru');
        $mail->Subject = $subject;
        if (strpos($additionalHeaders, "text/html") !== false)
        {
        $mail->MsgHTML($message);
        }
        else
        {
        $mail->Body = $message;
        }
        $address = $to;
        $mail->AddAddress($address);
        $mail->AddBCC(COption::GetOptionString("sale", "order_email", "order@" . $SERVER_NAME));
        $mail->Send();*/
    }

    function ProductRating($ID = false)
    {
        if (CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog"))
        {
            $arSelectedFields = Array(
                "ID",
                "ORDER_ID",
                "PRODUCT_ID",
                "PRICE",
                "CURRENCY",
                "DATE_INSERT",
                "QUANTITY",
                "DELAY",
                "NAME",
                "CAN_BUY",
                "MODULE",
                "CATALOG_XML_ID",
                "PRODUCT_XML_ID",
                "ORDER_PAYED",
                "ORDER_ALLOW_DELIVERY",
                "FUSER_ID",
                "LID",
                "ORDER_PRICE"
            );
            $time = date('d.m.Y', strtotime("+1 day"));
            $time_m = date("d.m.Y", strtotime("-2 year"));

            $arFilter = Array(
                ">=DATE_INSERT" => $time_m,
                "<=DATE_INSERT" => $time
            );
            if ($ID)
            {
                $arFilter["ORDER_ID"] = $ID;
            }
            else
            {
                $arFilter["!ORDER_ID"] = "";
            }
            // file_put_contents($_SERVER["DOCUMENT_ROOT"]."/test.txt",print_r($ID,1)."\n\n".print_r($arFilter,1));

            $dbBasket = CSaleBasket::GetList(Array(), $arFilter, false, false, $arSelectedFields);
            $arrResult = "";
            while ($arBasket = $dbBasket->Fetch())
            {
                // file_put_contents($_SERVER["DOCUMENT_ROOT"]."/test.txt",print_r($ID,1)."\n\n".print_r($arBasket,1),FILE_APPEND);


                $db_props =
                CIBlockElement::GetProperty(11, $arBasket["PRODUCT_ID"], array("sort" => "asc"), Array("CODE" => "RATING_NONE"));
                if ($ar_props = $db_props->Fetch())
                {
                    if ($ar_props["VALUE"] != "Y")
                    {
                        $db_props =
                        CIBlockElement::GetProperty(11, $arBasket["PRODUCT_ID"], array("sort" => "asc"), Array("CODE" => "RATING"));
                        if ($ar_props = $db_props->Fetch())
                        {
                            $rating = intval($ar_props["VALUE"]) + 1;
                            CIBlockElement::SetPropertyValuesEx($arBasket["PRODUCT_ID"], false, array("RATING" => $rating));
                        }

                    }
                }
            }

        }
        return "ProductRating();";
    }

?>
