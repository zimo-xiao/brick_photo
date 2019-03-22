<div id="delete_image_batch" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="input-field col s12" style="margin-top:20px">
                    <input id="delete_image_batch_from" type="text" class="validate" required>
                    <label for="delete_image_batch_from">开始编号（删除时包括此图，要小于结束）</label>
                </div>
                <div class="input-field col s12" style="margin-top:20px">
                    <input id="delete_image_batch_to" type="text" class="validate" required>
                    <label for="delete_image_batch_to">结束编号（删除时包括此图）</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#delete_image_batch').hide();adminRequest.deleteImageBatch()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">删除图片</button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#delete_image_batch').hide()"></div>
</div>