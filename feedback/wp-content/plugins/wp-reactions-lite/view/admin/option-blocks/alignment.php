<?php
use WP_Reactions\Lite\Helper;
use WP_Reactions\Lite\FieldManager\Radio;
?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e( 'Shortcode Alignment', 'wpreactions-lite' ); ?></span>
            <?php Helper::tooltip('alignment'); ?>
        </h4>
        <small><?php _e('Set your emoji reactions to align with your content.', 'wpreactions-lite'); ?></small>
    </div>
	<?php
	( new Radio() )
		->setName( 'align' )
		->addRadio( 'align_left', 'left', __( 'Left-Aligned', 'wpreactions-lite' ) )
		->addRadio( 'align_center', 'center', __( 'Center-Aligned', 'wpreactions-lite' ) )
		->addRadio( 'align_right', 'right', __( 'Right-Aligned', 'wpreactions-lite' ) )
		->setChecked( $options['align'] )
		->addClasses( 'form-group-inline' )
		->build();
	?>
</div>
