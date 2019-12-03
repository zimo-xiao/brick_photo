<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$intl['title']?></title>

    <script>
    const THIS_URL = "<?=$url;?>";
    const TOKEN = "<?=$token;?>";
    const URI = "<?=$uri;?>";
    const USER = <?=json_encode($user)?> ;
    var userInfo = [];

    // Vue placeholder
    var app_description = null;
    var app_tags = null;
    </script>

    <style>
    body {
        --color: <?=$intl['color']?>;
        --secondary-color: <?=$intl['secondaryColor']?>
    }
    </style>

    <script>
    var intl = <?=json_encode($intl['js'])?>
    </script>

    <script src="<?=$intl['dns']['axios']?>"></script>
    <script src="<?=$intl['dns']['jquery']?>"></script>
    <script src="<?=$intl['dns']['vue']?>"></script>
    <script src="<?=$url;?>/js/over-write.js"></script>
    <script src="<?=$url;?>/layui/main/layui.js"></script>
    <script src="<?=$url;?>/layui/index.js"></script>
    <script src="<?=$url;?>/js/request.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?=$url;?>/layui/main/css/layui.css">
    <link href="<?=$url;?>/css/gallery-materialize.min.css" rel="stylesheet">
    <link href="<?=$url;?>/css/over-write.css" rel="stylesheet">
</head>

<body>

    <!-- Login/Register Box -->
    <?=$login.$register.$find_password;?>

    <!-- Tags -->
    <?=$add_tags.$add_description;?>

    <!-- Navbar and Header -->
    <?=$header;?>

    <!-- Custom Content -->
    <?=$custom;?>

    <!-- Core Javascript -->
    <?php
    if ($user->permission === 3) {
        echo $change_permission.$delete_image.$delete_box;
        echo '<script src="'.$url.'/js/request.admin.js"></script>';
    }

    if ($token == null) {
        echo '<img class="main_qr z-depth-1" src="'.$intl['register_form'].'">';
    } else {
        echo '<img class="main_qr z-depth-1" src="'.$intl['social_media'].'">';
    }
    ?>

    <form action="" method="get" id="jump"></form>
    <script src="<?=$url;?>/js/exif.min.js"></script>
    <script src="<?=$url;?>/js/spark-md5.min.js"></script>
    <script src="<?=$url;?>/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?=$url;?>/js/masonry.pkgd.min.js"></script>
    <script src="<?=$url;?>/js/materialize.min.js"></script>
    <script src="<?=$url;?>/js/color-thief.min.js"></script>
    <script src="<?=$url;?>/js/galleryExpand.js"></script>
    <script src="<?=$url;?>/js/init.js"></script>

    <script>
    layui.use(['flow'], function() {
        var flow = layui.flow;
        flow.lazyimg({
            elem: '#index_images img'
        });
    });

    $(() => {
        var u = new URL(window.location.href);
        if (u.searchParams.get('anchor') == 1) {
            document.getElementById("anchor").scrollIntoView();
        }
    });

    var pleaseLoginAlert = () => {
        layer.msg("<?=$intl['pls_login']?>", {
            time: 5000
        })
    }
    </script>

</body>

</html>