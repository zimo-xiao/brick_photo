<?php
if ($token != null && $user->permission != 1) {
    ?>

<div class="container">
    <div class="layui-row">
        <div class="layui-col-lg12 layui-col-xs12" id="up-validation-code">
            <!-- 上传图片表单 -->
            <div class="layui-upload-drag up-box" id="upimg">
                <i class="layui-icon">&#xe67c;</i>
                <p><?=$intl['instruction']?></p>
            </div>
            <button id="submit" onclick="layer.load();$('#submit').hide();$('#nosubmit').show();redRequest.upload(0, 0)"
                class="layui-btn layui-btn-fluid" style="margin-top:0.5em"><?=$intl['selected']?></button>
            <button id="nosubmit" class="layui-btn layui-btn-fluid"
                style="display:none;margin-top:0.5em"><?=$intl['btn']?></button>
            <!-- 上传图片表单END -->
        </div>
    </div>
</div>

<?php
}
?>