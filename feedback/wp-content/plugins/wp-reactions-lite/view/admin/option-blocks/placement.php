<?php
use WP_Reactions\Lite\Helper;
use WP_Reactions\Lite\FieldManager\Radio;
?>

<div class="option-wrap">
    <div class="option-header">
        <h4 class="mb-3">
            <span><?php _e( 'On-Page Placement Options', 'wpreactions' ); ?></span>
			<?php Helper::tooltip( 'placement' ); ?>
        </h4>
    </div>
    <div class="row">
        <div class="col-md-4">
            <p class="d-inline-block m-0 mb-3"><?php _e( 'Insert on:', 'wpreactions' ); ?></p>
			<?php
			( new Radio() )
				->setName( 'display_where' )
				->addRadio( 'display_post', 'post', __( 'Posts', 'wpreactions' ) )
				->addRadio( 'display_page', 'page', __( 'Pages', 'wpreactions' ) )
				->addRadio( 'display_both', 'both', __( 'Both', 'wpreactions' ) )
				->addRadio( 'display_manual', 'manual', __( 'Manual Mode', 'wpreactions' ), '', 'placement-opt-manual' )
				->setChecked( $options['display_where'] )
				->addClasses( 'form-group' )
				->build();
			?>
        </div>
        <div class="col-md-4">
            <p class="d-inline-block m-0 mb-3"><?php _e( 'Display:', 'wpreactions' ); ?></p>
			<?php
			( new Radio() )
				->setName( 'content_position' )
				->addRadio( 'before_content', 'before', __( 'Before content', 'wpreactions' ) )
				->addRadio( 'after_content', 'after', __( 'After content', 'wpreactions' ) )
				->addRadio( 'both_content', 'both', __( 'Before & After content', 'wpreactions' ) )
				->setChecked( $options['content_position'] )
				->addClasses( 'form-group' )
				->build();
			?>
        </div>
        <div class="col-md-4">
            <p class="d-inline-block m-0 mb-3"><?php _e( 'Align:', 'wpreactions' ); ?></p>
			<?php
			( new Radio() )
				->setName( 'align' )
				->addRadio( 'align_left', 'left', __( 'Left', 'wpreactions' ) )
				->addRadio( 'align_center', 'center', __( 'Center', 'wpreactions' ) )
				->addRadio( 'align_right', 'right', __( 'Right', 'wpreactions' ) )
				->setChecked( $options['align'] )
				->addClasses( 'form-group' )
				->build();
			?>
        </div>
    </div>
</div>
