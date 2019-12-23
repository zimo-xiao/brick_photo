<nav class="nav-extended">
    <div class="nav-background">
        <div class="pattern active"
            style="background-image: url('<?=$intl['bg_img']?>');background-size:cover;filter: blur(3px)">
        </div>
    </div>
    <div class="nav-wrapper container">
        <a href="<?=$url;?>">
            <img class="brand-logo" src="<?=$intl['logo']?>" class="brand-logo"
                style="top:20px;width:<?=$intl['logoWidth']?>px" />
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
            <h1 class="header_title"><?=$intl['title']?></h1>
            <div class="tagline" style="margin: -1em 0px 40px 0px"><?=$intl['tagline']?></div>
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

<!-- mobile menu -->
<ul class="sidenav" id="nav-mobile">
    <?php
        if (!$token) {
            ?>
    <li class="active">
        <a onclick='$(".sidenav-overlay").click();$("#login").show()'>
            <i class="material-icons">person_outline</i>
            <?=$intl['login']?>
        </a>
    </li>
    <li>
        <a onclick='$(".sidenav-overlay").click();$("#register").show()'>
            <i class="material-icons">control_point_duplicate</i>
            <?=$intl['register']?>
        </a>
    </li>
    <?php
        } else {
            ?>
    <li>
        <a onclick='$(".sidenav-overlay").click()'>
            <i class="material-icons">account_circle</i>
            <?=$user->name?>
        </a>
    </li>
    <li>
        <a onclick='redRequest.logout()'>
            <i class="material-icons">exit_to_app</i>
            <?=$intl['logout']?>
        </a>
    </li>
    <?php
        }
        ?>
</ul>

<a href="#" data-target="nav-mobile" class="sidenav-trigger">
    <div class="mobile-menu-btn z-depth-2 waves-effect waves-light">
        <i class="material-icons" style="font-size: 6vh;float: left; margin: 2vh">menu</i>
    </div>
</a>
<!-- mobile menu end -->

<a href="#" data-target="nav-mobile" class="sidenav-trigger">
    <div class="mobile-menu-btn z-depth-2 waves-effect waves-light">
        <i class="material-icons" style="font-size: 6vh;float: left; margin: 2vh">menu</i>
    </div>
</a>