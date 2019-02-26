<div id="find_password" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662">找回密码 - 欢迎附中人</h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="find_password_usin" type="text" class="validate" required>
                    <label for="find_password_usin">学号</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#find_password').hide();redRequest.findPassword()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">向学号所绑定的邮箱发送邮件</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#find_password').hide()"></div>
</div>