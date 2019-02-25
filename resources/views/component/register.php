<div id="register" style="display:none">
    <div class="cover card" style="top:14vh">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662">注册 - 欢迎附中人</h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="register_usin" type="text" class="validate" required>
                    <label for="register_usin">学号</label>
                </div>
                <div class="input-field col s12">
                    <input id="register_code" type="text" class="validate" required>
                    <label for="register_code">激活码</label>
                </div>
                <div class="input-field col s12">
                    <input id="register_password" type="password" class="validate" required>
                    <label for="register_password">密码</label>
                </div>
                <div class="input-field col s12">
                    <input id="register_reenter_password" type="password" class="validate" required>
                    <label for="register_reenter_password">重复输入密码</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#register').hide();redRequest.register()" class="btn waves-effect waves-light"
                        style="background-color: #EA5662" type="button" name="action">注册</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#register').hide()"></div>
</div>