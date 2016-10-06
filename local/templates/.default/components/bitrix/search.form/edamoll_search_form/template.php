<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
  die(); ?>
<div class="edamoll_search-form" style="position: relative;top: 10px;">
  <form class="form_search_text" action="<?= $arResult["FORM_ACTION"] ?>">
    <table border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>
          <input type="text" name="q" value="" autocomplete="off" size="15" maxlength="50" id="search_field"/>
        </td>
        <td>
          <button id="search_button" name="s" type="submit"></button>
        </td>
      </tr>
    </table>
  </form>

</div>