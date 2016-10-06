<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
//CHTTP::SetStatus("404 Not Found");
IncludeTemplateLangFile(__FILE__);
?> 
<?
if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"],"utmcsr=(direct)|utmccn=(direct)")===false  && strpos($_COOKIE["__utmz"],"admitad")===false && strpos($_COOKIE["__utmz"],"organic")===false && isset($_COOKIE["uid"]) && isset($_GET["uid"])===false) 
{
setcookie("uid","", time()-3600,"/");
}

if  (isset($_COOKIE["__utmz"]) && strpos($_COOKIE["__utmz"],"direct")===false && strpos($_COOKIE["__utmz"],"organic")===false && isset($_COOKIE["from"]) && isset($_GET["from"])===false) 
{
setcookie("from","", time()-3600,"/");
}


$gdays=30;
CModule::IncludeModule('iblock');
$rs = CIBlockElement::GetList(
   array(), 
   array(
   "IBLOCK_ID" => 12,
   "CODE"=>"ttl",
   ),
   false, 
   false,
   array("ID","CODE","PROPERTY_LAST","PROPERTY_VALZ")
);
$arr=array();
while($ar = $rs->GetNext()) {
$gdays=$ar["PROPERTY_VALZ_VALUE"];
}

if (isset($_GET["uid"])) {
setcookie("uid",$_GET["uid"], time()+60*60*24*$gdays,"/");
setcookie("from","", time()-3600,"/");
}

if (isset($_GET["from"])) {
setcookie("from",$_GET["from"], time()+60*60*24*$gdays,"/");
setcookie("uid","", time()-3600,"/");
setcookie("__utmz","", time()-3600,"/");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

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
<link href="/include/js/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
<?
if (strpos($_SERVER['HTTP_USER_AGENT'],"iPhone") || strpos($_SERVER['HTTP_USER_AGENT'],"iPad")){
?>

<link rel="stylesheet" href="/include/iphone.css" type="text/css" media="all" />
<?}?>
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="/include/js/jquery.slides.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/script.js"></script>
	<title><?$APPLICATION->ShowTitle()?></title>

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

<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43176163-1', 'edamoll.ru');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>

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

<script>
(function() {
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

<script type="text/javascript" src="//vk.com/js/api/openapi.js?97"></script>


</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=646937708658706";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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
<div class="header_item" style="margin-left:38px;width: 513px;">
<div style="height:40px;width: 493px;">
<?$APPLICATION->IncludeComponent("bitrix:search.form", "edamoll_search_form", array(
	"PAGE" => "#SITE_DIR#search/index.php",
	"USE_SUGGEST" => "N"
	),
	false
);?> 
</div>
<div class="header_item_s" style="width: 195px;">
<?
$APPLICATION->IncludeFile(
	SITE_DIR."include/phone.php",
	Array(),
	Array("MODE"=>"html")
);
?>
</div>
<div class="header_item_s" style="margin-left:20px;width: 78px;">
<?
$APPLICATION->IncludeFile(
	SITE_DIR."include/dostavka.php",
	Array(),
	Array("MODE"=>"html")
);
?>
</div>
<div class="header_item_s" style="margin-left:20px;width: 60px;">
<?
$APPLICATION->IncludeFile(
	SITE_DIR."include/oplata.php",
	Array(),
	Array("MODE"=>"html")
);
?>
</div><noindex>
<div class="header_item_s" style="margin-left:20px;width: 100px;">
<?
$APPLICATION->IncludeFile(
	SITE_DIR."include/login.php",
	Array(),
	Array("MODE"=>"html")
);
?>
</div></noindex>
</div>

<div class="header_item" style="width: 226px;"  id="cart_line">
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.small",
	"edamoll_small_basket",
	Array(
		"PATH_TO_BASKET" => "/personal/basket.php",
		"PATH_TO_ORDER" => "/personal/order.php"
	)
);?>
</div>
  <div id="search_form_message" ></div>

</div>
		
		
		<div id="content">		

			<div id="workarea">
<?
/*
$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"edamoll_breadcrumb",
	Array(
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "-"
	)
);
*/
?>