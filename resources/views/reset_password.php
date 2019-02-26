<div id="reset_password">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662">找回密码 - 欢迎附中人</h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="reset_password_password" type="password" class="validate" required>
                    <label for="reset_password_password">密码</label>
                </div>
                <div class="input-field col s12">
                    <input id="reset_password_reenter_password" type="password" class="validate" required>
                    <label for="reset_password_reenter_password">重复输入密码</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#reset_password').hide();redRequest.resetPassword()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">更新密码</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background"></div>
</div>

<script>
const CODE = "<?=$code;?>";
</script>