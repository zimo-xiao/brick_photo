<div id="description_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="description_box_input" rows="5" class="materialize-textarea" data-length="420"
                        v-bind:value="previous_msg"></textarea>
                    <label for="description_box_input">请输入图片简介</label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#description_box').hide();redRequest.addDescription()"
                        class="btn waves-effect waves-light" style="background-color: #EA5662" type="button"
                        name="action">添加介绍</button>
                </div>
                <input type="hidden" value="" id="description_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#description_box').hide()"></div>
</div>

<script>
app_description = new Vue({
    inherit: true,
    el: '#description_box',
    data: {
        previous_msg: ''
    }
});
</script>