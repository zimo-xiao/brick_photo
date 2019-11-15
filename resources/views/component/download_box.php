<div id="download_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="msg"><i class="layui-icon">&#xe645;</i> <?=$intl['alert']?></div>

                <div class="input-field col s12">
                    <input id="download_usage" type="text" class="validate" required>
                    <label for="download_usage"><?=$intl['usage']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#download_box').hide();redRequest.download()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
                <input type="hidden" value="" id="download_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#download_box').hide()"></div>
</div>