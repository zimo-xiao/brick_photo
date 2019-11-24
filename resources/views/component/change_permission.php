<div id="change_permission" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="input-field col s12" style="margin-top:20px">
                    <input id="change_permission_usin" type="text" class="validate" required>
                    <label for="change_permission_usin"><?=$intl['usin']?></label>
                </div>
                <div class="input-field col s12">
                    <input id="change_permission_permission" type="text" class="validate" required>
                    <label for="change_permission_permission"><?=$intl['permission']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#change_permission').hide();adminRequest.changePermission()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#change_permission').hide()"></div>
</div>