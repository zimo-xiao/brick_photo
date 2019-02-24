<?php 
if ($token != null && $permission == 3) {
    ?>

<div class="container">
    <div class="layui-row">
        <div class="layui-col-lg12 layui-col-xs12">
            <!-- 上传激活码 Excel 表单 -->
            <div class="layui-upload-drag up-box" id="up-validation-code">
                <i class="layui-icon">&#xe67c;</i>
                <p>将Excel文件拖拽到此处，或点击选择文件，不可多选</p>
            </div>
            <button id="code_submit" class="layui-btn layui-btn-fluid" style="margin-top:0.5em">上传</button>
            <!-- 上传激活码 Excel 表单END -->
        </div>
    </div>
</div>

<?php
}
?>