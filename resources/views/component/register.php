<?php
    if ($show) {
        echo '<div id="register">';
    } else {
        echo '<div id="register" style="display:none">';
    }
?>
<div class="cover card">
    <div class="inner">
        <div class="row">
            <h5 style="color: var(--color)"><?=$intl['title']?></h5>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="register_email" type="text" class="validate" required>
                <label for="register_email"><?=$intl['email']?></label>
            </div>
            <div class="input-field col s12">
                <div class="input-field col s9" style="margin: 0px; padding-left: 0px">
                    <input id="register_code" type="text" class="validate" required>
                    <label for="register_code" style="left:0px"><?=$intl['code']?></label>
                </div>
                <button class="btn waves-effect waves-light col s3"
                    onclick="redRequest.code()"><?=$intl['request_code']?></button>
            </div>
            <div class="input-field col s12">
                <input id="register_name" type="text" class="validate" required>
                <label for="register_name"><?=$intl['name']?></label>
            </div>
            <div class="input-field col s12">
                <input id="register_usin" type="text" class="validate" required>
                <label for="register_usin"><?=$intl['usin']?></label>
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
                <button onclick="redRequest.register()" class="btn waves-effect waves-light"
                    style="background-color: var(--color)" type="button" name="action"><?=$intl['btn']?></button>
            </div>
        </div>
    </div>
</div>
<div class="cover-background" onclick="$('#register').hide()"></div>
</div>