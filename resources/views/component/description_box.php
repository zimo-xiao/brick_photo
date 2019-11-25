<div id="description_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="description_box_input" rows="5" class="materialize-textarea" data-length="420"
                        v-bind:value="previous_msg"></textarea>
                    <label for="description_box_input"><?=$intl['enter']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#description_box').hide();redRequest.addDescription()"
                        class="btn waves-effect waves-light" style="background-color: var(--color)" type="button"
                        name="action"><?=$intl['btn']?></button>
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