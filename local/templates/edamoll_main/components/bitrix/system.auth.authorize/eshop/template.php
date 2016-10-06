<?
    if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="modal login_window" id="login">
    <div class="log_cont">
        <?
            ShowMessage($arParams["~AUTH_RESULT"]);
            ShowMessage($arResult['ERROR_MESSAGE']);
        ?>

        <?if($arResult["AUTH_SERVICES"]): /*?>
            <p class="tal"><strong><?echo GetMessage("AUTH_TITLE")?></strong></p>
            <? */ endif?>
        <?if($arResult["AUTH_SERVICES"]):?>
            <div class="soc_net_div">
                <?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "soc_auth",
                        array(
                            "AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
                            "CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
                            "AUTH_URL"=>$arResult["AUTH_URL"],
                            "POST"=>$arResult["POST"],
                            "SUFFIX"=>"log"
                        ),
                        $component,
                        array("HIDE_ICONS"=>"Y")
                    );?>
            </div>
            <?endif?>
        <div class="form_auth_div">
            <div class="textl" style="margin-top: 20px;">
                <span class="h_text">Войдите, используя свой аккаунт</span>
            </div>
            <form name="form_auth" method="post" target="_top" action="<?=SITE_DIR?>auth/<?//=$arResult["AUTH_URL"]?>">
                <p class="tal">
                    <input type="hidden" name="AUTH_FORM" value="Y" />
                    <input type="hidden" name="TYPE" value="AUTH" />
                    <?if (strlen($arResult["BACKURL"]) > 0):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                        <?endif?>
                    <?foreach ($arResult["POST"] as $key => $value):?>
                        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                        <?endforeach?>
                    <div class="textl">
                        <strong><?=GetMessage("AUTH_LOGIN")?>:</strong>
                    </div><br>
                    <input class="input_text_style" type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" /><br><br>
                    <div class="textl">
                        <strong><?=GetMessage("AUTH_PASSWORD")?>:</strong>
                    </div><br>
                    <input class="input_text_style" type="password" name="USER_PASSWORD" maxlength="255" /><br>
                    <?if($arResult["SECURE_AUTH"]):?>
                        <span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
                            <div class="bx-auth-secure-icon"></div>
                        </span>
                        <noscript>
                            <span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
                                <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                            </span>
                        </noscript>
                        <script type="text/javascript">
                            document.getElementById('bx_auth_secure').style.display = 'inline-block';
                        </script>
                        <?endif?>


                    <?if ($arResult["STORE_PASSWORD"] == "Y"):?>
                        <span class="rememberme"><input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" checked /><?=GetMessage("AUTH_REMEMBER_ME")?></span>
                        <?endif?>
                    <br />
                    <div class="textl">
                        <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>

                            <span class="forgotpassword"><a href="<?=SITE_DIR?>auth/?forgot_password=yes<?//=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?>?</a></span>

                            <?endif?>
                        <input id="auth_submit" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
                    </div>
                </p>

            </form>
            <br />
        </div>
        <script type="text/javascript">
            <?if (strlen($arResult["LAST_LOGIN"])>0):?>
                try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
                <?else:?>
                try{document.form_auth.USER_LOGIN.focus();}catch(e){}
                <?endif?>
        </script>
        <div class="close_button" onclick="$('.modal').css('display','none');$('#dark').css('display','none');"></div>
    </div>
</div>
