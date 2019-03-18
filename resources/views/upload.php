<?php 
if ($token != null && $user->permission != 1) {
    ?>

<div class="container">
    <div class="layui-row">
        <div class="layui-col-lg12 layui-col-xs12" id="up-validation-code">
            <!-- 上传图片表单 -->
            <div class="layui-upload-drag up-box" id="upimg">
                <i class="layui-icon">&#xe67c;</i>
                <p>将图片拖拽到此处，或点击选择文件，一次最多可上传40张图片</p>
            </div>
            <button id="submit" onclick="layer.load();$('#submit').hide();$('#nosubmit').show();redRequest.upload(0, 0)"
                class="layui-btn layui-btn-fluid" style="margin-top:0.5em">已选择0张图片</button>
            <button id="nosubmit" class="layui-btn layui-btn-fluid"
                style="display:none;margin-top:0.5em">上传中请稍后...</button>
            <!-- 上传图片表单END -->
        </div>
    </div>
</div>

<?php
}
?>