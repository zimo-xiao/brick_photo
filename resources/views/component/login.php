<div id="login" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662">登录 - 欢迎附中人</h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="login_usin" type="text" class="validate" required>
                    <label for="login_usin">学号</label>
                </div>
                <div class="input-field col s12">
                    <input id="login_password" type="password" class="validate" required>
                    <label for="login_password">密码</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="redRequest.login()" class="btn waves-effect waves-light"
                        style="background-color: #EA5662" type="button" name="action">登录</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#login').hide()"></div>
</div>