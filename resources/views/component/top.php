<div id="login" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: #EA5662">登录 - 欢迎附中人</h5>
            </div>
            <div class="row">
                <form action="<?=$url;?>/auth/login" method="post" enctype="multipart/form-data">
                    <div class="input-field col s12">
                        <input id="usin" name="usin" type="text" class="validate" required>
                        <label for="usin">学号</label>
                    </div>
                    <input id="direct_back" value="<?=$url;?>" type="hidden">
                    <div class="input-field col s12">
                        <input id="password" name="password" type="password" class="validate" required>
                        <label for="password">密码</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" style="background-color: #EA5662" type="submit"
                            name="action">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#login').hide()"></div>
</div>