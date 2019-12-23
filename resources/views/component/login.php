<div id="login" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: var(--color)"><?=$intl['title']?></h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="login_usin" type="text" class="validate" required>
                    <label for="login_usin"><?=$intl['usin']?></label>
                </div>
                <div class="input-field col s12">
                    <input id="login_password" type="password" class="validate" required>
                    <label for="login_password"><?=$intl['pass']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="redRequest.login()" class="btn waves-effect waves-light"
                        style="background-color: var(--color)" type="button" name="action"><?=$intl['btn']?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#login').hide()"></div>
</div>