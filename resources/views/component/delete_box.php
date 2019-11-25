<div id="delete_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="msg"><i class="layui-icon">&#xe645;</i> <?=$intl['title']?></div>

                <div class="input-field col s12">
                    <input id="delete_box_reason" type="text" class="validate" required>
                    <label for="delete_box_reason"><?=$intl['reason']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#delete_box').hide();adminRequest.deleteImage()"
                        class="btn waves-effect waves-light" style="background-color: var(--color)" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
                <input type="hidden" value="" id="delete_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#delete_box').hide()"></div>
</div>