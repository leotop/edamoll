function addToCart(element, mode, text, type) {                  	
	if (!element && !element.href)
		return;
	
	var href = element.href;		 
	var button = $(element);
	button.unbind('click').removeAttr("href");

//href+="&quantity=10";
	titleItem = button.parents(".R2D2").find(".item_title").attr('title');
	imgItem = button.parents(".R2D2").find(".item_img").attr('src');	
	$('#addItemInCart .item_title').text(titleItem);
	$('#addItemInCart .item_img img').attr('src', imgItem); 

	if (href)
		$.get( href+"&ajax_buy=1", $.proxy(
	  		function(data) {          
				$("#cart_line").html(data);
				/*if (type == "cart")  //picture cart in button
					this.html(text).removeClass("addtoCart").addClass("incart");
				else if (type == "noButton")
					this.html(text);
				else
					this.html(text).removeClass("addtoCart").addClass("incart");	*/
			}, button) 
		);             
	return false;
}

function minus(ID)
	{
  var name_input = document.getElementById(ID);
  if (parseInt(name_input.value)>1)
  {
name_input.value=parseInt(name_input.value)-1;
  }
}

function plus(ID)
	{
  var name_input = document.getElementById(ID);
name_input.value=parseInt(name_input.value)+1;
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


