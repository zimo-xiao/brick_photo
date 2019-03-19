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
        <a href="<?=$url;?>" onclick="<?=$url;?>">全部</a>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="">标签</a>
        <dl class="layui-nav-child">
            <?php
                foreach ($tags as $tag) {
                    $on = '';
                    if ($query['tag'] == $tag['name']) {
                        $on = 'layui-this';
                    }
                    echo '<dd class="'.$on.'"><a href="'.$url.'/?tag='.$tag['name'].'#anchor">'.$tag['name'].'</a></dd>';
                }
            ?>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="">摄影师/组织</a>
        <dl class="layui-nav-child">
            <?php
                foreach ($authors as $author) {
                    $on = '';
                    if ($query['author'] == $author['id']) {
                        $on = 'layui-this';
                    }
                    echo '<dd class="'.$on.'"><a href="'.$url.'/?author='.$author['id'].'#anchor">'.$author['name'].'</a></dd>';
                }
            ?>
        </dl>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="">管理员</a>
        <dl class="layui-nav-child">
            <?php
                foreach ($admins as $admin) {
                    $on = '';
                    if ($query['author'] == $admin['id']) {
                        $on = 'layui-this';
                    }
                    echo '<dd class="'.$on.'"><a href="'.$url.'/?author='.$admin['id'].'#anchor">'.$admin['name'].'</a></dd>';
                }
            ?>
        </dl>
    </li>
</ul>
<!-- 左边导航栏END -->

<!-- Gallery -->
<div id="portfolio" class="section gray">

    <div style="float:left;margin-top:0px;margin-left:16vw;width:82vw;margin-top:10px;margin-bottom:10px;">
        <div class="gallery row">
            <select class="input-field" style="float:right;margin-right:0px;margin-top:10px;height:40px">
                <option value="1" selected>最新动态</option>
                <option value="2">最新发布</option>
                <option value="3">最旧发布</option>
            </select>
        </div>
    </div>

    <div style="float:left;margin-top:0px;margin-left:16vw;width:82vw">

        <!-- 使用 Vue 来进行渲染 -->
        <div class="gallery row" id="index_images">

            <!-- INFO -->
            <div class="col l4 m6 s12 gallery-item gallery-filter all">
                <div class="card brick-red">
                    <div class="card-content white-text">
                        <span class="card-title">关于我们</span>
                        <p>
                            红砖是目前北大附中最大的图片库，面向全校同学和附中校友免费开放。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。<br><br>联系/成为摄影师：微信号lrh20021108
                        </p>
                    </div>
                    <div class="card-action">
                        <a href="https://shimo.im/docs/bmH8eGUP7OEKRP1e">协议</a>
                        <a href="#">公示</a>
                    </div>
                </div>
            </div>
            <!-- INFO END -->

            <div v-for="image in images" class="col l4 m6 s12 gallery-item <?=$expandClass;?> gallery-filter">
                <div v-bind:id="'img_' + image.id" class="gallery-curve-wrapper" style="<?=$replaceShadow;?>">
                    <a class="gallery-cover gray">
                        <img class="responsive-img" v-bind:lay-src="url + '/image/view/cache/' + image.id">
                    </a>
                    <div class="gallery-header">
                        <span>作品编号：{{image.id}}</span>
                    </div>
                    <?php if ($expand) {
                ?>
                    <div class="gallery-body">
                        <div class="title-wrapper">
                            <h3>作品编号：{{image.id}}</h3>
                            <a v-bind:href="'<?=$url; ?>/?author=' + image.author_id"><span
                                    class="price">作者：{{image.author_name}}</span></a>
                        </div>
                        <p class="description" style="line-height:90%;">
                            <span
                                v-bind:onclick='"$(\"#download_box\").show();$(\"#download_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">file_download</i>
                                {{image.download_count}}下载
                            </span>
                            <span v-on:click="app_tags.selected_image_tags = image.tag"
                                v-if="user.permission === 3 || (user.id === image.author_id && user.permission === 2)"
                                v-bind:onclick='"$(\"#tags_box\").show();$(\"#tags_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">turned_in_not</i>
                                添加标签
                            </span>
                            <span v-on:click="app_description.previous_msg = image.description"
                                v-if="user.permission === 3 || (user.id === image.author_id && user.permission === 2)"
                                v-bind:onclick='"$(\"#description_box\").show();$(\"#description_box_image_id\").val(\""+image.id+"\")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">chat_bubble_outline</i>
                                添加介绍
                            </span>
                            <span v-if="user.permission === 3"
                                v-bind:onclick='"adminRequest.delete_image("+image.id+")"'
                                class="waves-effect waves-light btn brick-red"><i
                                    class="material-icons left">delete_forever</i>
                                删除
                            </span>
                            <br><br>
                            <div class="msg"><i class="layui-icon">&#xe645;</i>
                                侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者
                                {{image.author_name}}」</div>
                        </p>
                        <!-- description -->
                        <p v-if="image.description != null" class="description br">{{image.description}}</p>
                        <p v-else class="description">
                            暂时没有作品简介哦
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
        url: URL,
        user: USER,
        images: <?=json_encode($images);?>,
        app_tags: app_tags,
        app_description: app_description
    }
});

// 循环重新渲染页面
function renderImages() {
    resetMasonry();
    window.requestAnimationFrame(renderImages);
}
$(document).ready(function() {
    renderImages();
});

layui.use(['laypage'], function() {
    var author = "<?=$query['author'];?>";
    var tag = "<?=$query['tag'];?>";
    const urlParams = new URLSearchParams(window.location.search);
    layui.laypage.render({
        elem: 'pagination',
        count: <?=$count;?>,
        limit: 40,
        curr: urlParams.get('page'),
        layout: ['prev', 'page', 'next'],
        jump: function(obj, first) {
            if (!first) {
                window.location.href = URL + '?page=' + obj.curr + '&author=' + author + '&tag=' +
                    tag + '#anchor';
            }
        }
    });
});
</script>