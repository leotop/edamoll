$(document).ready(function() {
    $("#search_field2").keyup(function() {
        $.get("/include/ajax_form.php?q="+$(this).val(),function(data){
              $("#search_form_message2").html(data);
              $("#search_form_message2").show();
        })

    });
    $("body").on("click",".searclinl",function(data){
           $(".form_search_text input[name=q]").val($(this).attr("rel"));
           $(".form_search_text").submit();
    })
    $(document).click( function(event){
        if( $(event.target).closest("#search_form_message2").length )
            return;
        $("#search_form_message2").hide();
        event.stopPropagation();
    });


});