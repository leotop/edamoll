<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="cart-items" id="id-shelve-list" style="display:none;">
	<div class="sort">
		<a href="javascript:void(0)" id="sortbutton1" onclick="ShowBasketItems(1);" class="sortbutton"><?=GetMessage("SALE_PRD_IN_BASKET_ACT")?> (<?=count($arResult["ITEMS"]["AnDelCanBuy"])?>)</a>
		<a href="javascript:void(0)" id="sortbutton2" class="sortbutton current"><?=GetMessage("SALE_PRD_IN_BASKET_SHELVE")?> (<?=$countItemsDelay?>)</a>
	</div>
	<?if(count($arResult["ITEMS"]["DelDelCanBuy"]) > 0):?>
	<table class="equipment mycurrentorders" rules="rows" style="width:830px">
	<thead>
		<tr>
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_NAME")?></td>
				<td></td>
			<?endif;?>
			<?if (in_array("VAT", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_VAT")?></td>
			<?endif;?>
			<?if (in_array("TYPE", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_PRICE_TYPE")?></td>
			<?endif;?>
			<?if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_DISCOUNT")?></td>
			<?endif;?>
			<?if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_WEIGHT")?></td>
			<?endif;?>
			<?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_QUANTITY")?></td>
			<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<td><?= GetMessage("SALE_PRICE")?></td>
			<?endif;?>
			<td>
				<?/*if (in_array("DELETE", $arParams["COLUMNS_LIST"]) || in_array("DELAY", $arParams["COLUMNS_LIST"])):?>
					<?= GetMessage("SALE_ACTION")?>
				<?endif;*/?>
			</td>
					<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
			<td class="deleteitem"></td>
					<?endif;?>
		</tr>
	</thead>
	<tbody>
	<?
	foreach($arResult["ITEMS"]["DelDelCanBuy"] as $arBasketItems)
	{
		?>
		<tr>
			<td>
				<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
					<a href="<?=$arBasketItems["DETAIL_PAGE_URL"]?>">
				<?endif;?>
				<?if (!empty($arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"])) :?>
					<img src="<?=$arResult["ITEMS_IMG"][$arBasketItems["ID"]]["SRC"]?>" alt="<?=$arBasketItems["NAME"] ?>"/>
				<?else:?>
					<img src="/bitrix/components/bitrix/eshop.sale.basket.basket/templates/.default/images/no-photo.png" alt="<?=$arBasketItems["NAME"] ?>"/>
				<?endif?>
				<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
					</a>
				<?endif;?>
			</td>
			<?if (in_array("NAME", $arParams["COLUMNS_LIST"])):?>
			<td>
				<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
					<a href="<?=$arBasketItems["DETAIL_PAGE_URL"] ?>">
				<?endif;?>
					<?=$arBasketItems["NAME"] ?>
				<?if (strlen($arBasketItems["DETAIL_PAGE_URL"])>0):?>
					</a>
				<?endif;?>
				<?if (in_array("PROPS", $arParams["COLUMNS_LIST"]))
				{
					foreach($arBasketItems["PROPS"] as $val)
					{
						echo "<br />".$val["NAME"].": ".$val["VALUE"];
					}
				}?>
			</td>
			<?endif;?>

			<?if (in_array("VAT", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-price"><?=$arBasketItems["VAT_RATE_FORMATED"]?></td>
			<?endif;?>
			<?if (in_array("TYPE", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-type"><?=$arBasketItems["NOTES"]?></td>
			<?endif;?>
			<?if (in_array("DISCOUNT", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-discount"><?=$arBasketItems["DISCOUNT_PRICE_PERCENT_FORMATED"]?></td>
			<?endif;?>
			<?if (in_array("WEIGHT", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-weight"><?=$arBasketItems["WEIGHT_FORMATED"]?></td>
			<?endif;?>
			<?if (in_array("QUANTITY", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-quantity"><?=$arBasketItems["QUANTITY"]?></td>
			<?endif;?>
			<?if (in_array("PRICE", $arParams["COLUMNS_LIST"])):?>
				<td class="cart-item-price">
					<?if(doubleval($arBasketItems["FULL_PRICE"]) > 0):?>
						<div class="discount-price"><?=$arBasketItems["PRICE_FORMATED"]?></div>
						<div class="old-price"><?=$arBasketItems["FULL_PRICE_FORMATED"]?></div>
					<?else:?>
						<div class="price"><?=$arBasketItems["PRICE_FORMATED"];?></div>
					<?endif?>
				</td>
			<?endif;?>
			<?/*
			<td class="cart-item-actions">
				<?if (in_array("DELAY", $arParams["COLUMNS_LIST"])):?>
					<a class="setaside" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["add"])?>"><?=GetMessage("SALE_ADD_CART")?></a>
				<?endif;?>
			</td>
					<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
			<td><a class="deleteitem" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["delete"])?>" onclick="//return DeleteFromCart(this);" title="<?=GetMessage("SALE_DELETE_PRD")?>">Удалить</a></td>
					<?endif;?>
*/?>

			<?if (in_array("DELAY", $arParams["COLUMNS_LIST"])):?>
				<td><a class="setaside" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["shelve"])?>"
 onclick='ajaxpostshow("/include/cart_big.php", "ajaxaction=undelay&ajaxundelayid=<?=$arBasketItems["ID"];?>", ".basket" );return false;' title="<?=GetMessage("SALE_ADD_CART")?>"><?=GetMessage("SALE_ADD_CART")?></a></td>
			<?endif;?>

					<?if (in_array("DELETE", $arParams["COLUMNS_LIST"])):?>
			<td><a class="deleteitem basket-list-delete" href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["delete"])?>" id="ajaxaction=delete&ajaxdeleteid=<?=$arBasketItems['ID'];?>"
 onclick='ajaxpostshow("/include/cart_big.php", "ajaxaction=delete&ajaxdeleteid=<?=$arBasketItems["ID"];?>", ".basket" );return false;' title="<?=GetMessage("SALE_DELETE_PRD")?>">Удалить</a></td>
					<?endif;?>


		</tr>
		<?
	}
	?>
	</tbody>
</table>
<?endif;?>
</div>
<?