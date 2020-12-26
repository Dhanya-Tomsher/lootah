<?php
use WP_Reactions\Lite\FieldManager\Radio;
use WP_Reactions\Lite\Helper;
?>
<div class="option-wrap">
    <div class="option-header">
        <h4>
            <span><?php _e( 'Emoji Sizes', 'wpreactions' ); ?></span>
            <?php Helper::tooltip('emoji-size'); ?>
        </h4>
    </div>
	<?php
	( new Radio() )
		->setName( 'size' )
		->addRadio( 'small', 'small', __( 'Small', 'wpreactions' ) )
		->addRadio( 'medium', 'medium', __( 'Medium', 'wpreactions' ) )
		->addRadio( 'large', 'large', __( 'Large', 'wpreactions' ) )
		->addRadio( 'xlarge', 'xlarge', __( 'X-Large', 'wpreactions' ) )
		->setChecked( $options['size'] )
		->addClasses( 'form-group-inline' )
		->build();
	?>
</div>
