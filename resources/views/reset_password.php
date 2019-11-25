<div id="reset_password">
    <div class="cover card">
        <div class="inner">
            <div class="row">
                <h5 style="color: var(--color)"><?=$intl['title']?></h5>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="reset_password_password" type="password" class="validate" required>
                    <label for="reset_password_password"><?=$intl['pass']?></label>
                </div>
                <div class="input-field col s12">
                    <input id="reset_password_reenter_password" type="password" class="validate" required>
                    <label for="reset_password_reenter_password"><?=$intl['reenter_pass']?></label>
                </div>
                <div class="input-field col s12">
                    <button onclick="$('#reset_password').hide();redRequest.resetPassword()"
                        class="btn waves-effect waves-light" style="background-color: var(--color)" type="button"
                        name="action"><?=$intl['btn']?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="cover-background"></div>
</div>

<script>
const CODE = "<?=$code;?>";
</script>