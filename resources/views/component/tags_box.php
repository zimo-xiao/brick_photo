<div id="tags_box" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div style="margin-top:20px">
                    <p v-for="tag in tags">
                        <label v-if="selected_image_tags.includes(tag.name)">
                            <input v-bind:value="tag.name" name="tags_box_select" type="checkbox"
                                class="filled-in tags_box_select" checked />
                            <span>{{tag.name}}</span>
                        </label>
                        <label v-else>
                            <input type="checkbox" name="tags_box_select" v-bind:value="tag.name"
                                class="filled-in tags_box_select" />
                            <span>{{tag.name}}</span>
                        </label>
                    </p>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#tags_box').hide();redRequest.addTags()" class="btn waves-effect waves-light"
                        style="background-color: #EA5662" type="button" name="action"><?=$intl['btn']?></button>
                </div>
                <input type="hidden" value="" id="tags_box_image_id">
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#tags_box').hide()"></div>
</div>

<script>
app_tags = new Vue({
    inherit: true,
    el: '#tags_box',
    data: {
        tags: <?=json_encode($tags);?>,
        selected_image_tags: []
    }
});
</script>