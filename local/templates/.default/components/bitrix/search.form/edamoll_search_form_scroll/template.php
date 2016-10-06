<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="edamoll_search-form" style="position: relative;left: -1px;">
  <form class="form_search_text" action="<?=$arResult["FORM_ACTION"]?>">
    <table border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td>
          <input onblur="$('#search_field2').css('width','130px');" onfocus="$('#search_field2').css('width','448px');" type="text" name="q" value="" size="15" maxlength="50" id="search_field2" autocomplete="off"/>
        </td><td>
          <button id="search_button2" name="s" type="submit"></button>
        </td>
      </tr>
    </table>
  </form>
  <div id="search_form_message2"></div>
</div>