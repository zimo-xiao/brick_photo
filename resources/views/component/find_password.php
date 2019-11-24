<div id="find_password" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662"><?=$intl['title']?></h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="find_password_usin" type="text" class="validate" required>
                    <label for="find_password_usin"><?=$intl['usin']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#find_password').hide();redRequest.findPassword()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#find_password').hide()"></div>
</div>