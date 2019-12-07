<?php
    $expandClass = 'gallery-expand';
    $expand = true;
    $replaceShadow = '';
    if ($token === null) {
        $expandClass = '';
        $expand = false;
        $replaceShadow = 'box-shadow: 0 1px 4px rgba(0,0,0,0.1);';
    } else {
        echo $download_box;
    }
?>

<!-- 左边导航栏 -->
<ul class="layui-nav layui-nav-tree layui-bg-cyan" lay-filter="test"
    style="position:fixed;display:inline-block;vertical-align:top;top:64px;border-radius:0px;left:0px;bottom:0px;width:15vw;overflow:auto">
    <li class="layui-nav-item layui-nav-itemed">
        <a href="<?=$url?>" onclick="<?=$url?>"><?=$intl['left_menu_bar']['all']?></a>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href=""><?=$intl['left_menu_bar']['tags']?></a>
        <dl class="layui-nav-child">
            <?php
                foreach ($tags as $tag) {
                    $on = '';
                    if ($token === null) {
                        echo '<dd class="'.$on.'"><a href="#anchor" onclick="pleaseLoginAlert()">'.$tag['name'].'</a></dd>';
                    } else {
                        if ($query['tag'] == $tag['name']) {
                            $on = 'layui-this';
                        }
                        echo '<dd class="'.$on.'"><a href="'.$url.'/?tag='.$tag['name'].'#anchor">'.$tag['name'].'</a></dd>';
                    }
                }
            ?>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href=""><?=$intl['left_menu_bar']['photographers']?></a>
        <dl class="layui-nav-child">
            <?php
                foreach ($authors as $author) {
                    $on = '';
                    if ($token === null) {
                        echo '<dd class="'.$on.'"><a href="#anchor" onclick="pleaseLoginAlert()">'.$author['name'].'</a></dd>';
                    } else {
                        if ($query['author'] == $author['id']) {
                            $on = 'layui-this';
                        }
                        echo '<dd class="'.$on.'"><a href="'.$url.'/?author='.$author['id'].'#anchor">'.$author['name'].'</a></dd>';
                    }
                }
            ?>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href=""><?=$intl['left_menu_bar']['admins']?></a>
        <dl class="layui-nav-child">
            <?php
                foreach ($admins as $admin) {
                    $on = '';
                    if ($token === null) {
                        echo '<dd class="'.$on.'"><a href="#anchor" onclick="pleaseLoginAlert()">'.$admin['name'].'</a></dd>';
                    } else {
                        if ($query['author'] == $admin['id']) {
                            $on = 'layui-this';
                        }
                        echo '<dd class="'.$on.'"><a href="'.$url.'/?author='.$admin['id'].'#anchor">'.$admin['name'].'</a></dd>';
                    }
                }
            ?>
        </dl>
    </li>
</ul>
<!-- 左边导航栏END -->

<!-- Gallery -->
<div id="portfolio" class="section gray">

    <div style="float:left;margin-top:0px;margin-left:16vw;width:82vw;margin-top:10px;margin-bottom:10px;height:60px">
        <div class="row">
            <div class="col s10"></div>
            <div class="col s2">
                <select class=" input-field" style="height:60px" id="index_select_order">
                    <?php
                        $update_desc = '';
                        $created_desc = '';
                        $created_asc = '';
                        if ($query['order'] == 'update_desc') {
                            $update_desc = 'selected';
                        } elseif ($query['order'] == null || $query['order'] == 'created_desc') {
                            $created_desc = 'selected';
                        } elseif ($query['order'] == 'created_asc') {
                            $created_asc = 'selected';
                        }
                        echo '<option value="update_desc" '.$update_desc.'>'.$intl['order']['update_desc'].'</option><option value="created_desc" '.$created_desc.'>'.$intl['order']['created_desc'].'</option><option value="created_asc" '.$created_asc.'>'.$intl['order']['created_asc'].'</option>';
                        ?>
                </select>
            </div>
        </div>
    </div>

    <div style="float:left;margin-top:0px;margin-left:16vw;width:82vw">

        <!-- 使用 Vue 来进行渲染 -->
        <div class="gallery row" id="index_images">

            <!-- INFO -->
            <div class="col l4 m6 s12 gallery-item gallery-filter all">
                <div class="card brick-red">
                    <div class="card-content white-text">
                        <span class="card-title"><?=$intl['about']['title']?></span>
                        <p><?=$intl['about']['description']?></p>
                    </div>
                    <div class="card-action">
                        <?php
                            foreach ($intl['about']['custom_menu_items'] as $item) {
                                echo '<a href="'.$item['url'].'" class="white-text">'.$item['name'].'</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- INFO END -->

            <?php
                $pleaseLogin = '';
                $imageIntl = $intl['image'];
                if ($token === null) {
                    $pleaseLogin = 'onclick="pleaseLoginAlert()"';
                }
            ?>

            <div v-for="image in images" <?=$pleaseLogin;?>
                class="col l4 m6 s12 gallery-item <?=$expandClass;?> gallery-filter">
                <div v-bind:id="'img_' + image.id" class="gallery-curve-wrapper" style="<?=$replaceShadow;?>">
                    <a class="gallery-cover gray">
                        <img class="responsive-img" v-bind:lay-src="url + '/image/view/cache/' + image.id">
                    </a>
                    <div class="gallery-header">
                        <span># {{image.id}} · {{image.author_name}}</span>
                    </div>
                    <?php if ($expand) {
                ?>
                    <div class="gallery-body">
                        <div class="title-wrapper">
                            <h3># {{image.id}}</h3>
                            <a v-bind:href="'<?=$url; ?>/?author=' + image.author_id"><span
                                    class="price"><?=$imageIntl['author']?>: {{image.author_name}}</span></a>
                        </div>
                        <p class="description" style="line-height:90%;">
                            <span
                                v-bind:onclick='"$(\"#download_box\").show();$(\"#download_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">file_download</i>
                                {{image.download_count}} <?=$imageIntl['download']?>
                            </span>
                            <span v-on:click="app_tags.selected_image_tags = image.tag"
                                v-if="user.permission === 3 || (user.id === image.author_id && user.permission === 2)"
                                v-bind:onclick='"$(\"#tags_box\").show();$(\"#tags_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">turned_in_not</i>
                                <?=$imageIntl['add_tags']?>
                            </span>
                            <span v-on:click="app_description.previous_msg = image.description"
                                v-if="user.permission === 3 || (user.id === image.author_id && user.permission === 2)"
                                v-bind:onclick='"$(\"#description_box\").show();$(\"#description_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">chat_bubble_outline</i>
                                <?=$imageIntl['add_description']?>
                            </span>
                            <span v-if="user.permission === 3"
                                v-bind:onclick='"$(\"#delete_box\").show();$(\"#delete_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">delete_forever</i>
                                <?=$imageIntl['delete']?>
                            </span>
                            <br><br>
                            <div class="msg"><i class="layui-icon">&#xe645;</i>
                                {{ "<?=$imageIntl['alert']?>".replace("[author]", image.author_name) }}</div>
                        </p>
                        <!-- description -->
                        <p v-if="image.description != null" class="description br">{{image.description}}</p>
                        <p v-else class="description">
                            <?=$imageIntl['no_description']?>
                        </p>
                        <p class="description"
                            style="margin-top:35px;border-top-style: solid;border-top-width: 1px;border-top-color: #e0e0e0;">
                            <div v-for="t in image.tag">
                                <a v-bind:href="url+'/?tag='+t+'#anchor'">
                                    <div class="tag">{{t}}</div>
                                </a>
                            </div>
                        </p>
                        <!-- description END -->
                    </div>
                    <div class="gallery-action">
                        <span
                            v-bind:onclick='"$(\"#download_box\").show();$(\"#download_box_image_id\").val(\""+image.id+"\")"'
                            class="btn-floating btn-large waves-effect waves-light"><i
                                class="material-icons">file_download</i></span>
                    </div>
                    <?php
            }?>
                </div>
            </div>
        </div>
        <!-- 使用 Vue 来进行渲染 END -->

        <!-- 分页 -->
        <div id="pagination"
            style="float:left;text-align:center;margin-top:15px;margin-bottom:900px;width:82vw;height:60px">
        </div>
        <!-- 分页END -->
    </div>
</div>
<style>

</style>
<script>
var app_images = new Vue({
    inherit: true,
    el: '#index_images',
    data: {
        url: THIS_URL,
        user: USER,
        images: <?=json_encode($images)?> ,
        app_tags : app_tags,
        app_description: app_description
    }
});

layui.use(['laypage'], function() {
    const urlParams = new URLSearchParams(window.location.search);
    layui.laypage.render({
        elem: 'pagination',
        count: <?=$count?> ,
        limit : 40,
        curr: urlParams.get('page'),
        layout: ['prev', 'page', 'next'],
        jump: (obj, first) => {
            if (!first) {
                var u = new URL(window.location.href);
                u.searchParams.set('page', obj.curr);
                jumpTo(u);
            }
        }
    });
});

$('#index_select_order').change(function() {
    <?php
    if ($token === null) {
        echo 'pleaseLoginAlert()';
    } else {
        echo "var u = new URL(window.location.href);
        u.searchParams.set('order', $(this).val());
        jumpTo(u);
        ";
    }
    ?>
});

// 当 img 加载后重新渲染 grid
$("img")
    .on('load', function() {
        resetMasonry()
    })
    .on('error', function() {
        resetMasonry()
    })
</script>