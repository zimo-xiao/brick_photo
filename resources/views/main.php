<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>红砖图库 - 附中的宝藏</title>

    <script>
    const URL = "<?=$url;?>";
    const TOKEN = "<?=$token;?>";
    const URI = "<?=$uri;?>";
    const USER = <?=json_encode($user);?>;
    var userInfo = [];

    // Vue placeholder
    var app_description = null;
    var app_tags = null;
    </script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="<?=$url;?>/js/over-write.js"></script>
    <script src="<?=$url;?>/layui/main/layui.js"></script>
    <script src="<?=$url;?>/layui/index.js"></script>
    <script src="<?=$url;?>/js/request.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?=$url;?>/layui/main/css/layui.css">
    <link href="<?=$url;?>/css/gallery-materialize.min.css" rel="stylesheet">
    <link href="<?=$url;?>/css/over-write.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
</head>

<body>

    <!-- Login/Register Box -->
    <?=$login.$register;?>

    <!-- Tags -->
    <?=$add_tags.$add_description;?>

    <!-- Navbar and Header -->
    <?=$header;?>

    <!-- Custom Content -->
    <?=$custom;?>

    <!-- Core Javascript -->
    <?php
    if ($user->permission === 3) {
        echo $change_permission;
        echo '<script src="'.$url.'/js/request.admin.js"></script>';
    }
    ?>
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
    </script>

</body>

</html>