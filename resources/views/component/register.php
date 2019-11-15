<?php
    if ($show) {
        echo '<div id="register">';
    } else {
        echo '<div id="register" style="display:none">';
    }
?>
<div class="cover card" style="top:14vh">
    <div class="inner">
        <div class="row">
            <h5 style="color: #EA5662"><?=$intl['title']?></h5>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="register_usin" type="text" class="validate" required>
                <label for="register_usin"><?=$intl['usin']?></label>
            </div>
            <div class="input-field col s12">
                <input id="register_code" type="text" class="validate" required>
                <label for="register_code"><?=$intl['code']?></label>
            </div>
            <div class="input-field col s12">
                <input id="register_password" type="password" class="validate" required>
                <label for="register_password"><?=$intl['pass']?></label>
            </div>
            <div class="input-field col s12">
                <input id="register_reenter_password" type="password" class="validate" required>
                <label for="register_reenter_password"><?=$intl['reenter_pass']?></label>
            </div>
            <div class="input-field col s12">
                <input id="register_agree" type="checkbox" class="validate" required checked>
                <span><?=$intl['contract']?></span>
            </div>
            <div class="input-field col s12">
                <button onclick="$('#register').hide();redRequest.register()" class="btn waves-effect waves-light"
                    style="background-color: #EA5662" type="button" name="action"><?=$intl['btn']?></button>
            </div>
        </div>
    </div>
</div>
<div class="cover-background" onclick="$('#register').hide()"></div>
</div>