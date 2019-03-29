<div id="delete_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="msg"><i class="layui-icon">&#xe645;</i> 请谨慎删除</div>

                <div class="input-field col s12">
                    <input id="delete_box_reason" type="text" class="validate" required>
                    <label for="delete_box_reason">请简单描述删除原因</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#delete_box').hide();adminRequest.deleteImage()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">删除</button>
                </div>
                <input type="hidden" value="" id="delete_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#delete_box').hide()"></div>
</div>