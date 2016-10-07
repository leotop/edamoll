window.onscroll = function() {
  var scrolled = window.pageYOffset || document.documentElement.scrollTop;
if (scrolled>200) {
document.getElementById('scroll_menu').style.display = 'block';
}
else{
document.getElementById('scroll_menu').style.display = 'none';
}

}


function CentriredModalWindow(ModalName){
	$(ModalName).css({"display":"block","opacity":0});
var scrolled = window.pageYOffset || document.documentElement.scrollTop;
	$(ModalName).css({"left":"726px","top":(scrolled-160)+"px"})

}

function OpenModalWindow(ModalName){

	$(ModalName).animate({"opacity":1},300);

}


function addToCart(element, text, qq, base) {

	//if (!element)		return;

	//var href = element.href;
	//var button = $(element);
var q;
_gaq.push(['_trackEvent','item','add2basket']);
yaCounter21772657.reachGoal('add2basket');
ga('send', 'event', 'item', 'add2basket');


if (base=="кг" || base=="КГ"){
  q=parseFloat($("#"+qq).val());
}else{q=parseInt($("#"+qq).val());}

	$('#addItemInCart').html("Товар добавлен в корзину<BR />"+text + " - "+q+ base);
	var ModalName = $('#addItemInCart');
	if (typeof(currentTimeout)!=='undefined') {clearTimeout(currentTimeout);}
q="ajaxaction=add&ajaxaddid="+qq.substr(2)+"&ajaxaddq="+q;

	CentriredModalWindow(ModalName);
	OpenModalWindow(ModalName);

       $.ajax({
           type: "POST",
           url: "/include/ajax_add.php",
           data: q,
           dataType: "html",
      });

currentTimeout = setTimeout(function()  {$(ModalName).css({"display":"none","opacity":0}) }, 2000);
	setTimeout(function()  {bask_refresh();}, 500);
	return false;
}


function addToCartDelay(qq, base) {

var q;
_gaq.push(['_trackEvent','item','add2basketdelay']);
yaCounter21772657.reachGoal('add2basketdelay');
ga('send', 'event', 'item', 'add2basketdelay');
if (base=="кг" || base=="КГ"){

  q=parseFloat($("#"+qq).val());
}else{q=parseInt($("#"+qq).val());}
var text=$("h3.catalog-element-name").html();
	$('#addItemInCart').html("Товар отложен<BR />"+text + " - "+q+ base);
q="ajaxaction=adddel&ajaxadddelid="+qq.substr(2)+"&ajaxadddelq="+q;
       $.ajax({
           type: "POST",
           url: "/include/ajax_add.php",
           data: q,
           dataType: "html",

      });

	var ModalName = $('#addItemInCart');
	if (typeof(currentTimeout)!=='undefined') {clearTimeout(currentTimeout);}

	CentriredModalWindow(ModalName);
	OpenModalWindow(ModalName);
currentTimeout = setTimeout(function()  {$(ModalName).css({"display":"none","opacity":0}) }, 2000);

	setTimeout(function()  {bask_refresh();}, 500);
	return false;
}


function bask_refresh()
{
$.ajax({
  url: "/include/cart_line_top.php",
  cache: false,
async: false,
  success: function(html){
    $("#cart_line").html(html);
  }
});

$.ajax({
  url: "/include/cart_line_scroll.php",
  cache: false,
async: false,
  success: function(html){
    $("#cart_line_scroll").html(html);
  }
});
}

function minus(ID,base) {
  var name_input = document.getElementById(ID);
    if (base=="кг" || base=="КГ"){
      if (parseFloat(name_input.value)>0.1) {
        var g_numb=parseFloat(name_input.value)-0.1;
        g_numb=g_numb.toFixed(1);
        name_input.value=g_numb+" "+base;
      }
    } else {
      if (parseInt(name_input.value) >= 2) {
        name_input.value = parseInt(name_input.value)-1+' '+base;
      } else if(parseInt(name_input.value) == 1) {
        name_input.value = parseInt(name_input.value)+' '+base;
      }
    }
}

function plus(ID,base) {
    var name_input = document.getElementById(ID);
    if (base=="кг" || base=="КГ") {
        var g_numb=parseFloat(name_input.value)+0.1;
        g_numb=g_numb.toFixed(1);
        name_input.value=g_numb+" "+base;
    } else {
        if (parseInt(name_input.value) >= 1) {
            name_input.value = parseInt(name_input.value)+1+' '+base;
      }
    }
}

function edit_q(ID,base)
	{
var name_input = document.getElementById(ID);
		if (base=="кг" || base=="КГ"){
var g_numb=parseFloat(name_input.value);
g_numb=g_numb.toFixed(1);
			if (g_numb==NaN) {g_numb=0;}
name_input.value=g_numb+" "+base;
}
		else{
var g_numb=parseInt(name_input.value);
			if (g_numb==NaN) {g_numb=0;}
name_input.value=g_numb+" "+base;
		}
}

function leftar(ID)
	{
//if ()
$(".leftar").removeClass("leftact");
$(".rightar").removeClass("rightnoact") ;
$("#"+ID).removeClass("foo_moved") ;
}
function rightar(ID)
	{
$(".leftar").addClass("leftact");
$(".rightar").addClass("rightnoact") ;
$("#"+ID).addClass("foo_moved") ;
}


/* Function for ours ajax inquiry  */
function ajaxpostshow(urlres, datares, wherecontent ){
       $.ajax({
           type: "POST",
           url: urlres,
           data: datares,
           dataType: "html",
           beforeSend: function(){
                var elementheight = $(wherecontent).height();
                $(wherecontent).prepend('<div class="ajaxloader"></div>');
                $('.ajaxloader').css('height', elementheight);
                $('.ajaxloader').prepend('<img id="bxid_12335" class="imgcode" src="/include/js/ajax-loader.gif"  />');
            },
           success: function(fillter){
                $(wherecontent).html(fillter);
           }
      });
	setTimeout(function()  {bask_refresh();}, 500);
}

function addToIzbrannoe(id)
{
    ///alert(id);
    $.get("/include/setIz.php", { id: id} ,function(){
        $('#addItemInCart').html("Товар добавлен в избранное<BR />");
        var ModalName = $('#addItemInCart');
        CentriredModalWindow(ModalName);
        OpenModalWindow(ModalName);
        $("#Favorites").html('<a href="#" class="pinktext" onclick="return DelToIzbrannoeElement('+id+')" ><div class="img_activ_izb img_activ_izb_posi">В избранном</div></a>');
        currentTimeout = setTimeout(function()  {$(ModalName).css({"display":"none","opacity":0}) }, 2000);
    });
    return false;
}
function DelToIzbrannoeElement(id){
    $.get("/include/delIz.php", { id: id} ,function(data){
        $('#addItemInCart').html("Товар удален из избранного<BR />");
        var ModalName = $('#addItemInCart');
        CentriredModalWindow(ModalName);
        OpenModalWindow(ModalName);
        currentTimeout = setTimeout(function()  {$(ModalName).css({"display":"none","opacity":0}) }, 2000);
        $("#Favorites").html('<a href="#" class="pinktext" onclick="return addToIzbrannoe('+id+');"><div class="img_activ_izb">В избранное</div></a>');
    });
    return false;
}
function DelToIzbrannoe(id)
{
    ///alert(id);
    $.get("/include/delIz.php", { id: id} ,function(data){
        $("#idiz"+id).remove();
        var child = '';
        child = $("#foo_").children().attr('id');
        if(!child)
        {
            $("#LK5").html("<h2>У вас нет избранных товаров</h2>")
        }
    });

    return false;
}