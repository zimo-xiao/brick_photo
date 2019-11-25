<div id="delete_image_batch" style="display:none">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <div class="input-field col s12" style="margin-top:20px">
                    <input id="delete_image_batch_from" type="text" class="validate" required>
                    <label for="delete_image_batch_from"><?=$intl['end']?></label>
                </div>
                <div class="input-field col s12" style="margin-top:20px">
                    <input id="delete_image_batch_to" type="text" class="validate" required>
                    <label for="delete_image_batch_to"><?=$intl['end']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#delete_image_batch').hide();adminRequest.deleteImageBatch()"
                        class="btn waves-effect waves-light" style="background-color: var(--color)" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background" onclick="$('#delete_image_batch').hide()"></div>
</div>