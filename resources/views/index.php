<!-- 左边导航栏 -->
<ul class="layui-nav layui-nav-tree layui-bg-cyan" lay-filter="test"
    style="position:fixed;display:inline-block;vertical-align:top;top:64px;border-radius:0px;left:0px;bottom:0px;width:15vw;overflow:auto">
    <li class="layui-nav-item layui-nav-itemed">
        <a href="#" onclick="<?=$url;?>">全部</a>
    </li>
    <li class="layui-nav-item layui-nav-itemed">
        <a href="">标签</a>
        <dl class="layui-nav-child">
            <?php
                foreach ($tags as $tag) {
                    $on = '';
                    // if ($value == $tag) {
                    //     $on = 'layui-this';
                    // }
                    echo '<dd class="'.$on.'"><a href="#" onclick="">'.$tag['name'].'</a></dd>';
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
                    // if ($value == $tag) {
                    //     $on = 'layui-this';
                    // }
                    echo '<dd class="'.$on.'"><a href="#" onclick="">'.$author['name'].'</a></dd>';
                }
            ?>
        </dl>
    </li>
</ul>
<!-- 左边导航栏END -->

<!-- Gallery -->
<div id="portfolio" class="section gray">
    <div style="float:left;margin-top:0px;margin-left:16vw;width:82vw">

        <!-- 使用 Vue 来进行渲染 -->
        <div class="gallery row" id="index_images">

            <!-- INFO -->
            <div class="col l4 m6 s12 gallery-item gallery-filter all">
                <div class="card brick-red">
                    <div class="card-content white-text">
                        <span class="card-title">关于我们</span>
                        <p>
                            红砖是由20位历届摄影师/4个社团组织共同创立版权联盟，监督图片的使用，保护摄影师利益不被侵害。目的在于防止老照片流失，保护附中摄影师的著作权，方便附中社团为校友和在校生进行文化服务。
                        </p>
                    </div>
                    <div class="card-action">
                        <a href="#">协议</a>
                        <a href="#">公示</a>
                    </div>
                </div>
            </div>
            <!-- INFO END -->

            <div v-for="image in images" class="col l4 m6 s12 gallery-item gallery-expand gallery-filter">
                <div v-bind:id="'img_' + image.id" class="gallery-curve-wrapper">
                    <a class="gallery-cover gray">
                        <img class="responsive-img"
                            v-bind:lay-src="url + '/storage/images/cache/' + image.file_name + '.jpg'">
                    </a>
                    <div class="gallery-header">
                        <span>作者：{{image.author_name}}</span>
                    </div>
                    <div class="gallery-body">
                        <div class="title-wrapper">
                            <h3>红砖编号：{{image.id}}</h3>
                            <span class="price">{{image.author_name}}</span>
                        </div>
                        <p class="description">{{image.description}}</p>
                    </div>
                    <div class="gallery-action">
                        <a class="btn-floating btn-large waves-effect waves-light"><i
                                class="material-icons">file_download</i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- 使用 Vue 来进行渲染 END -->

        <!-- 分页 -->
        <div id="pagination"
            style="float:left;text-align:center;margin-top:15px;margin-bottom:15px;width:82vw;height:60px">
        </div>
        <!-- 分页END -->
    </div>
</div>
<style>

</style>
<script>
var app_images = new Vue({
    el: '#index_images',
    data: {
        url: URL,
        images: <?=json_encode($images);?>
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
    const urlParams = new URLSearchParams(window.location.search);
    layui.laypage.render({
        elem: 'pagination',
        count: <?=$count;?>,
        limit: 40,
        curr: urlParams.get('page'),
        layout: ['prev', 'page', 'next'],
        jump: function(obj, first) {
            if (!first) {
                window.location.href = URL + '?page=' + obj.curr;
            }
        }
    });
});
</script>