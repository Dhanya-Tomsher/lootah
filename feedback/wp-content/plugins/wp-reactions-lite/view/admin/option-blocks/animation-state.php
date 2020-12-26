<?php

use WP_Reactions\Lite\Helper;
use WP_Reactions\Lite\FieldManager\Radio;

?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e('Emoji Animation', 'wpreactions-lite'); ?></span>
            <?php Helper::tooltip('animation-state'); ?>
        </h4>
    </div>
    <?php
    (new Radio())
        ->setName('animation')
        ->addRadio('animation_false', 'false', __('Static', 'wpreactions-lite' ))
        ->addRadio('animation_true', 'true', __('Animated', 'wpreactions-lite'), '<span class="wpra-pro-badge">PRO</span>')
        ->setChecked('false')
        ->addClasses('form-group-inline')
        ->setDisabled(true)
        ->build();
    ?>
</div>
