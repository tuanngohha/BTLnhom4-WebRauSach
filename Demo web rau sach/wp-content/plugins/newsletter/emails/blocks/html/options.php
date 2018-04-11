<?php
/* 
 * @var $options array contains all the options the current block we're ediging contains
 * @var $controls NewsletterControls 
 */
?>

<table class="form-table">
    <tr>
        <th><?php _e('HTML code', 'newsletter') ?></th>
        <td>
            <?php $controls->textarea('html') ?>
        </td>
    </tr>
</table>
