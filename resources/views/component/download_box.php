<div id="download_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="msg"><i class="layui-icon">&#xe645;</i> 如要下载去水印图片，请微信联系：YangynAcpovaurox</div>

                <div class="input-field col s12">
                    <input id="download_usage" type="text" class="validate" required>
                    <label for="download_usage">请简单描述一下图片用途</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#download_box').hide();redRequest.download()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">下载图片</button>
                </div>
                <input type="hidden" value="" id="download_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#download_box').hide()"></div>
</div>