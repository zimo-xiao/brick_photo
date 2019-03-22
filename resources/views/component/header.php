<nav class="nav-extended">
    <div class="nav-background">
        <div class="pattern active"
            style="background-image: url('<?=$url;?>/image/background.gif');background-size:cover;filter: blur(3px)">
        </div>
    </div>
    <div class="nav-wrapper container">
        <a href="<?=$url;?>">
            <img src="<?=$url;?>/image/logo.png" class="brand-logo" style="top:20px;width:80px" />
        </a>
        <ul class="right hide-on-med-and-down">
            <?php
                if ($token != null) {
                    echo "<li><a class='dropdown-trigger' href='#' data-target='feature-dropdown'>".$user->name."</a></li>";
                    echo "<ul id='feature-dropdown' class='dropdown-content'><li><a href='#' onclick='redRequest.logout()'>退出登录</a></li></ul>";
                } else {
                    echo "<li><a onclick='$(\"#login\").show()'>登录</a></li><li><a onclick='$(\"#register\").show()'>注册</a></li><li><a onclick='$(\"#find_password\").show()'>找回密码</a></li>";
                }

                if ($token != null && $user->permission === 3) {
                    echo "<li><a class='dropdown-trigger' href='#' data-target='admin-dropdown'>管理员操作</a></li>";
                    echo "<ul id='admin-dropdown' class='dropdown-content'>
                        <li><a href=\"$url/admin/upload-validation-code\">上传激活码</a></li>
                        <li><a href=\"#\" onclick=\"$(\'#change_permission\').show()\">修改用户权限</a></li>
                        <li><a href=\"$url/validation-code\">下载未激活码</a></li>
                        <li><a href=\"$url/auth/export\">所有用户信息</a></li>
                    </ul>";
                }
            ?>
        </ul>
        <div class="nav-header center">
            <h1>不倒的记忆，附中的宝藏</h1>
            <div class="tagline">北大附中最大的图库，目前共藏<?=$imageCount;?>张摄影作品，共<?=$userCount;?>位附中校友在红砖</div>
        </div>
    </div>

    <!-- Fixed Masonry Filters -->
    <div id="anchor" class="categories-wrapper lighten-1">
        <div class="categories-container">
            <ul class="categories container">
                <?php
                    $indexUnderline = '';
                    $uploadUnderline = '';
                    $adminUploadValidationCode = '';
                    if ($uri == '/') {
                        $indexUnderline = 'active';
                    } elseif ($uri == 'upload') {
                        $uploadUnderline = 'active';
                    }
                ?>
                <li class="<?=$indexUnderline;?>"><a href="<?=$url;?>">首页</a></li>
                <?php 
                if ($token != null && $user->permission != 1) {
                    echo '<li class="'.$uploadUnderline.'"><a href="'.$url.'/upload">上传图片</a></li>';
                }
                ?>
                <li><a href="https://shimo.im/docs/bmH8eGUP7OEKRP1e" target="_black">协议</a></li>
                <li><a href="https://shimo.im/docs/o7R76i5bzDsMDSKm" target="_black">公示</a></li>
            </ul>
        </div>
    </div>
</nav>