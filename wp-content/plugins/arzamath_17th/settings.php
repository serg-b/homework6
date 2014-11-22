<div class="wrap">
    <h2>Settings</h2>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Slide changing interval</th>
                <td><input type="text" name="interval" style="width:70px" value="<?php echo get_option('interval'); ?>"/>ms</td>
            </tr>
            <tr valign="top">
                <th scope="row">Speed of the scroll animation</th>
                <td>
                    <?php $selected = get_option('fading'); ?>
                    <select name="fading">
                        <option value="slow" <?php echo ($selected == 'slow') ? 'selected' : '' ?>>Slow</option>
                        <option value="fast" <?php echo ($selected == 'fast') ? 'selected' : '' ?>>Fast</option>
                    </select>
                </td>
            </tr>
        </table>
        <input type="hidden" name="action" value="update"/>
        <input type="hidden" name="page_options" value="interval, fading"/>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>"/>
        </p>
    </form>
</div>
