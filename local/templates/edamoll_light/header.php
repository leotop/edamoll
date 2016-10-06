<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
IncludeTemplateLangFile(__FILE__);
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?$APPLICATION->ShowHead();?>

	<!--[if lte IE 6]>
	<style type="text/css">
		
		#banner-overlay { 
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=SITE_TEMPLATE_PATH?>images/overlay.png', sizingMethod = 'crop'); 
		}
		
		div.product-overlay {
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=SITE_TEMPLATE_PATH?>images/product-overlay.png', sizingMethod = 'crop');
		}
		
	</style>
	<![endif]-->
<link href='http://fonts.googleapis.com/css?family=PT+Sans+Caption&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<script src="/include/js/jquery-1.9.1.min.js"></script>
 
<script src="/include/js/jquery.slides.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/script.js"></script>
	<title><?$APPLICATION->ShowTitle()?></title>
<? if (isset($_GET["ORDER_ID"]) && $_GET["ORDER_ID"]!="") {
if (CModule::IncludeModule("sale") && CModule::IncludeModule("iblock") ) {

$arOrd=CSaleOrder::GetByID($_GET["ORDER_ID"]);

$arBasketItems = array();
$dbBasketItems = CSaleBasket::GetList(
        array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
        array(

                "ORDER_ID" => $_GET["ORDER_ID"]
            ),
        false,
        false,
        array()
    );
while ($arItems = $dbBasketItems->Fetch())
{
    $arBasketItems[] = $arItems;
}
}
  $Date = strtotime($arOrd["DATE_INSERT"]);
  $diff = time() - $Date;

  ?>

<script type="text/javascript">
      var _gaq = window._gaq || [];
      window.onerror = function(msg, url, line) {
          var preventErrorAlert = true;
          _gaq.push(['_trackEvent', 'JS Error', msg, navigator.userAgent + ' -> ' + url + " : " + line, 0, true]);
          return preventErrorAlert;
      };
      jQuery.error = function (message) {
          _gaq.push(['_trackEvent', 'jQuery Error', message, navigator.userAgent]);
      }
</script>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-42065366-1']);

(function() {
  var read_cookie = function(name) {
    var name_eq = name + "=";
    var carr = document.cookie.split(';');
    for(var i=0; i < carr.length; i++) {
      var c = carr[i];
      while (c.charAt(0)==' ') c = c.substring(1, c.length);
      if (c.indexOf(name_eq) == 0) return c.substring(name_eq.length, c.length);
    }
    return null;
  }
  var make_rnd_string = function(name) {
    var text = "";
    var symbols = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
 
    for( var i=0; i < 5; i++ )
        text += symbols.charAt(Math.floor(Math.random() * symbols.length));
    document.cookie = name+"="+text+"; path=/";
    return text;
  }
  var fill_date = function(name) {
    var date = new Date().toString();
    if(name) document.cookie = name+"="+date+"; path=/";
    return date;
  }
  var get_host = function( url ) {
    var a = document.createElement('a');
    a.href = url;
    return a.hostname;
  }
  var user_id    = read_cookie('user_id') || make_rnd_string('user_id');
  var session_id = read_cookie('session_id');
  var click_time = read_cookie('click_time');
  var goal_time  = fill_date();
 
  if(  !session_id
    || !click_time
    || (document.referrer!="" && get_host(document.referrer)!=location.hostname) )
  {
    session_id = make_rnd_string('session_id');
    click_time = fill_date('click_time');
  }
 
  _gaq.push(['_setCustomVar', 1, 'user_id',    user_id, 1 ]);
  _gaq.push(['_setCustomVar', 2, 'click_time', click_time, 2 ]);
  _gaq.push(['_setCustomVar', 3, 'session_id', session_id, 2 ]);
  _gaq.push(['_setCustomVar', 4, 'goal_time',  goal_time, 3 ]);
})();

_gaq.push(['_trackPageview']);
_gaq.push(['_addTrans', '<?=$_GET["ORDER_ID"]?>', '', '<?=$arOrd["PRICE"]?>','','<?=$arOrd["PRICE_DELIVERY"]?>']);
<?
foreach($arBasketItems as $arItemz) {
$db_groups = CIBlockElement::GetElementGroups($arItemz["PRODUCT_ID"], true);
$ar_new_group="";
while ($ar_group = $db_groups->Fetch()){
	$ar_new_group = $ar_group["NAME"];
}
?>
_gaq.push(['_addItem', '<?=$_GET["ORDER_ID"]?>', '<?=$arItemz["PRODUCT_ID"]?>', '<?=$arItemz["NAME"]?>','<?=$ar_new_group?>','<?=$arItemz["PRICE"]?>','<?=round($arItemz["QUANTITY"])?>']);
<?}?>


_gaq.push(['_trackTrans']);

(function() {
   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
   var s = document.getElementsByTagName('script')[0];
   s.parentNode.insertBefore(ga, s);
})();
window.onload = function() {
if(_gaq.I==undefined){
   _gaq.push(['_trackEvent', 'tracking_script', 'loaded', 'ga.js', ,true]);
   ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
   s = document.getElementsByTagName('script')[0];
   gaScript = s.parentNode.insertBefore(ga, s);
} else {
   _gaq.push(['_trackEvent', 'tracking_script', 'loaded', 'dc.js', ,true]);
}
};
</script> 

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-43176163-1', 'edamoll.ru');
ga('require', 'displayfeatures');
ga('send', 'pageview');

</script>

<?
if ($diff < 3){
  ?>
<script type="text/javascript" >
ga('require', 'ecommerce', 'ecommerce.js');
ga('ecommerce:addTransaction', {
'id': '<?=$_GET["ORDER_ID"]?>',
'affiliation': '',
'revenue': '<?=$arOrd["PRICE"]?>',
'shipping': '<?=$arOrd["PRICE_DELIVERY"]?>',
'tax': ''
});
<?
foreach($arBasketItems as $arItemz) {
$db_groups = CIBlockElement::GetElementGroups($arItemz["PRODUCT_ID"], true);
$ar_new_group="";
while ($ar_group = $db_groups->Fetch()){
	$ar_new_group = $ar_group["NAME"];
}
?>
ga('ecommerce:addItem', {
'id': '<?=$_GET["ORDER_ID"]?>',
'name': '<?=$arItemz["NAME"]?>',
'sku': '<?=$arItemz["PRODUCT_ID"]?>',
'category': '<?=$ar_new_group?>',
'price': '<?=$arItemz["PRICE"]?>',
'quantity': '<?=round($arItemz["QUANTITY"])?>'
});
<?}?>

ga('ecommerce:send');


</script> 

<?
}
} else{?>

<script type="text/javascript">
      var _gaq = window._gaq || [];
      window.onerror = function(msg, url, line) {
          var preventErrorAlert = true;
          _gaq.push(['_trackEvent', 'JS Error', msg, navigator.userAgent + ' -> ' + url + " : " + line, 0, true]);
          return preventErrorAlert;
      };
      jQuery.error = function (message) {
          _gaq.push(['_trackEvent', 'jQuery Error', message, navigator.userAgent]);
      }
</script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-42065366-1']);

(function() {
  var read_cookie = function(name) {
    var name_eq = name + "=";
    var carr = document.cookie.split(';');
    for(var i=0; i < carr.length; i++) {
      var c = carr[i];
      while (c.charAt(0)==' ') c = c.substring(1, c.length);
      if (c.indexOf(name_eq) == 0) return c.substring(name_eq.length, c.length);
    }
    return null;
  }
  var make_rnd_string = function(name) {
    var text = "";
    var symbols = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
 
    for( var i=0; i < 5; i++ )
        text += symbols.charAt(Math.floor(Math.random() * symbols.length));
    document.cookie = name+"="+text+"; path=/";
    return text;
  }
  var fill_date = function(name) {
    var date = new Date().toString();
    if(name) document.cookie = name+"="+date+"; path=/";
    return date;
  }
  var get_host = function( url ) {
    var a = document.createElement('a');
    a.href = url;
    return a.hostname;
  }
  var user_id    = read_cookie('user_id') || make_rnd_string('user_id');
  var session_id = read_cookie('session_id');
  var click_time = read_cookie('click_time');
  var goal_time  = fill_date();
 
  if(  !session_id
    || !click_time
    || (document.referrer!="" && get_host(document.referrer)!=location.hostname) )
  {
    session_id = make_rnd_string('session_id');
    click_time = fill_date('click_time');
  }
 
  _gaq.push(['_setCustomVar', 1, 'user_id',    user_id, 1 ]);
  _gaq.push(['_setCustomVar', 2, 'click_time', click_time, 2 ]);
  _gaq.push(['_setCustomVar', 3, 'session_id', session_id, 2 ]);
  _gaq.push(['_setCustomVar', 4, 'goal_time',  goal_time, 3 ]);
})();

  _gaq.push(['_trackPageview']);

(function() {
   var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
   var s = document.getElementsByTagName('script')[0];
   s.parentNode.insertBefore(ga, s);
})();
window.onload = function() {
if(_gaq.I==undefined){
   _gaq.push(['_trackEvent', 'tracking_script', 'loaded', 'ga.js', ,true]);
   ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
   s = document.getElementsByTagName('script')[0];
   gaScript = s.parentNode.insertBefore(ga, s);
} else {
   _gaq.push(['_trackEvent', 'tracking_script', 'loaded', 'dc.js', ,true]);
}
};

</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43176163-1', 'edamoll.ru');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
<?}?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter21772657 = new Ya.Metrika({id:21772657,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript>
</noscript>
<!-- /Yandex.Metrika counter -->

<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '455709454566724']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=455709454566724&amp;ev=NoScript" /></noscript>

</head>
<body>
	<div id="page-wrapper">
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
<div id="header">			
<div class="header_item" style="width: 216px;">
<?
$APPLICATION->IncludeFile(
	SITE_DIR."include/company_name.php",
	Array(),
	Array("MODE"=>"html")
);
?>
</div>
</div>
		

		
		<div id="content">		

			<div id="workarea">