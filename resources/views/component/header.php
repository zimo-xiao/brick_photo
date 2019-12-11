<nav class="nav-extended">
    <div class="nav-background">
        <div class="pattern active"
            style="background-image: url('<?=$intl['bg_img']?>');background-size:cover;filter: blur(3px)">
        </div>
    </div>
    <div class="nav-wrapper container">
        <a href="<?=$url;?>">
            <img src="<?=$intl['logo']?>" class="brand-logo" style="top:20px;width:<?=$intl['logoWidth']?>px" />
        </a>
        <ul class="right hide-on-med-and-down">
            <?php
                if ($token != null) {
                    echo "<li><a class='dropdown-trigger' href='#' data-target='feature-dropdown'>".$user->name."</a></li>";
                    echo "<ul id='feature-dropdown' class='dropdown-content'><li><a href='#' onclick='redRequest.logout()'>{$intl['logout']}</a></li></ul>";
                } else {
                    echo "<li><a onclick='$(\"#login\").show()'>{$intl['login']}</a></li><li><a onclick='$(\"#register\").show()'>{$intl['register']}</a></li><li><a href='{$intl['requestAccountForm']}' target='_blank'>{$intl['requestAccount']}</a></li><li><a onclick='$(\"#find_password\").show()'>{$intl['find_password']}</a></li>";
                }

                if ($token != null && $user->permission === 3) {
                    $adminDropdownIntl = $intl['admin_dropdown'];
                    echo "<li><a class='dropdown-trigger' href='#' data-target='admin-dropdown'>{$adminDropdownIntl['name']}</a></li>";
                    echo "<ul id='admin-dropdown' class='dropdown-content'>
                        <li><a href=\"$url/admin/upload-validation-code\">{$adminDropdownIntl['upload_code']}</a></li>
                        <li><a href=\"#\" onclick=\"$('#change_permission').show()\">{$adminDropdownIntl['change_user_permission']}</a></li>
                        <li><a href=\"#\" onclick=\"$('#delete_image_batch').show()\">{$adminDropdownIntl['delete_image_batch']}</a></li>
                        <li><a href=\"$url/validation-code\">{$adminDropdownIntl['download_non_activated_codes']}</a></li>
                        <li><a href=\"$url/auth/export\">{$adminDropdownIntl['all_user_info']}</a></li>
                        <li><a href=\"$url/download/export\">{$adminDropdownIntl['image_download_activities']}</a></li>
                    </ul>";
                }
            ?>
        </ul>
        <div class="nav-header center">
            <h1><?=$intl['title']?></h1>
            <div class="tagline" style="-2rem 0 40px 0"><?=$intl['tagline']?></div>
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
                <li class="<?=$indexUnderline;?>"><a href="<?=$url;?>"><?=$intl['index']?></a></li>
                <?php
                if ($token != null && $user->permission != 1) {
                    echo '<li class="'.$uploadUnderline.'"><a href="'.$url.'/upload">'.$intl['upload'].'</a></li>';
                }

                foreach ($intl['custom_menu_items'] as $item) {
                    echo "<li><a href='{$item['url']}' target='_black'>{$item['name']}</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>