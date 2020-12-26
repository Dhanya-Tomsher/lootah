<?php
/**
 * MetaBox class for plugin
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

use WP_Post;

/**
 * Class MetaBox
 *
 * Creates meta box for all registered post types in order to view statistics and save settings
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */
class MetaBox {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param Loader $loader
	 *
	 * @since    1.0.0
	 *
	 */
	public function __construct( $plugin_name, $loader ) {
		$this->loader      = $loader;
		$this->plugin_name = $plugin_name;

	}

	/**
	 * Add metabox to every post type
	 *
	 * @param string $post_type
	 *
	 * since 1.0.0
	 */
	public function addReactionsMetaBox( $post_type ) {

		add_meta_box(
			"reactions_meta_box",
			__( 'Reactions', 'da-reactions' ),
			array( $this, 'buildMetaBox' ),
			$post_type,
			'side',
			'low'
		);
	}

	/**
	 * Render HTML for matebox
	 *
	 * @param WP_Post $post
	 *
	 * @since 1.0.0
	 */
	public function buildMetaBox( $post ) {

		$data            = Data::getReactionsForContent( $post->ID, $post->post_type );
		$general_options = Options::getInstance( 'general' );

		$globally_enabled_for_post     = $general_options->getOption( 'post_type_' . $post->post_type, '' ) === 'on';
		$globally_enabled_for_comments = $general_options->getOption( 'post_type_' . $post->post_type . '_comments', '' ) === 'on';
		$color_generator               = $general_options->getOption( "chart_colors" );

		$chart_data = array(
			'labels'   => array(),
			'datasets' => array(
				array(
					'data'            => array(),
					'backgroundColor' => array()
				)
			)
		);

		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$chart_data['labels'][]              = $data[ $i ]->label;
			$chart_data['datasets'][0]['data'][] = $data[ $i ]->total;
			switch ( $color_generator ) {
				case 'random':
					$chart_data['datasets'][0]['backgroundColor'][] = Utils::generateColorFromString( $data[ $i ]->label );
					break;
				case 'default':
					$chart_data['datasets'][0]['backgroundColor'][] = Utils::getDefaultColorByIndex( $i );
					break;
				default:
					$chart_data['datasets'][0]['backgroundColor'][] = $data[ $i ]->color;
					break;
			}
		}

		?>
        <h3><?php _e( 'Global settings', 'da-reactions' ) ?></h3>
        <p><?php _e( 'Modify global settings for all contents of the same type', 'da-reactions' ); ?></p>
		<?php
		$field_name  = $general_options->getFieldName( "post_type_$post->post_type" );
		$saved_value = $general_options->getOption( "post_type_$post->post_type" );
		$checked     = isset( $saved_value ) && $saved_value == 'on';
		?>
        <p>
            <input type="hidden" name="<?= $field_name ?>" value="off" />
            <input id="id_<?= $field_name ?>" type="checkbox" name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?>
                   value="on"/>
            <label for="id_<?= $field_name ?>">
				<?php _e( 'Enable reactions for all contents of this type globally?', 'da-reactions' ); ?>
            </label>
        </p>
		<?php

		if ( post_type_supports( $post->post_type, 'comments' ) ) {
			$post_type_name = $post->post_type;
			$field_name     = $general_options->getFieldName( "post_type_${post_type_name}_comments" );
			$saved_value    = $general_options->getOption( "post_type_${post_type_name}_comments" );
			$checked        = isset( $saved_value ) && $saved_value == 'on';
			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off" />
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>">
					<?php _e( 'Enable reactions for all comments under contents of this type globally?', 'da-reactions' ); ?>
                </label>
            </p>
			<?php
		}
		?>
        <hr/>


        <h3><?php _e( 'Statistics for this content', 'da-reactions' ) ?></h3>
        <canvas
                class="graph-canvas"
                id="da_reactions_graph_canvas"
                width="400"
                height="400"
                data-chart_data="<?= esc_attr( json_encode( $chart_data ) ); ?>"
        >
            Your browser does not support canvas.
        </canvas>
        <hr/>


        <h3><?php _e( 'Local settings', 'da-reactions' ) ?></h3>
		<?php
		$option_name    = $globally_enabled_for_post ? 'post_type_' . $post->post_type . '_disable_' . $post->ID : 'post_type_' . $post->post_type . '_enable_' . $post->ID;
		$fieldset_title = $globally_enabled_for_post ? __( 'Reactions are enabled globally for this type of content', 'da-reactions' ) : __( 'Reactions are <strong>disabled</strong> globally for this type of content', 'da-reactions' );
		$field_label    = $globally_enabled_for_post ? __( 'Disable reactions for this specific content?', 'da-reactions' ) : __( 'Enable reactions for this specific content?', 'da-reactions' );
		$field_icon     = $globally_enabled_for_post ? '<span class="dashicons dashicons-no color-warning"></span>' : '<span class="dashicons dashicons-yes color-primary"></span>';
		$field_name     = $general_options->getFieldName( $option_name );
		$saved_value    = $general_options->getOption( $option_name );
		$checked        = isset( $saved_value ) && $saved_value == 'on';
		?>
        <p><?= $fieldset_title ?></p>
        <p>
            <input type="hidden" name="<?= $field_name ?>" value="off" />
            <input id="id_<?= $field_name ?>" type="checkbox" name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?>
                   value="on"/>
            <label for="id_<?= $field_name ?>">
				<?= $field_icon ?>
				<?= $field_label ?>
            </label>
        </p>
		<?php

		if ( post_type_supports( $post->post_type, 'comments' ) ) {
			$option_name    = $globally_enabled_for_comments ? 'post_type_' . $post->post_type . '_disable_comments_' . $post->ID : 'post_type_' . $post->post_type . '_enable_comments_' . $post->ID;
			$fieldset_title = $globally_enabled_for_comments ? __( 'Reactions are enabled globally for comments on this type of content', 'da-reactions' ) : __( 'Reactions are <strong>disabled</strong> globally for comments on this type of content', 'da-reactions' );
			$field_label    = $globally_enabled_for_comments ? __( 'Disable reactions for comments on this specific content?', 'da-reactions' ) : __( 'Enable reactions for comments on this specific content?', 'da-reactions' );
			$field_icon     = $globally_enabled_for_comments ? '<span class="dashicons dashicons-no color-warning"></span>' : '<span class="dashicons dashicons-yes color-primary"></span>';
			$field_name     = $general_options->getFieldName( $option_name );
			$saved_value    = $general_options->getOption( $option_name );
			$checked        = isset( $saved_value ) && $saved_value == 'on';
			?>
            <p><?= $fieldset_title ?></p>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off" />
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>">
					<?= $field_icon ?>
					<?= $field_label ?>
                </label>
            </p>
			<?php
		}

		// Security field
		// This validates that submission came from the
		// actual dashboard and not the front end or
		// a remote server.
		wp_nonce_field( '_da_reactions_form_metabox_nonce', '_da_reactions_form_metabox_process' );
	}

	/**
	 * Save data from meta box on post save
	 *
	 * @param integer $post_id
	 *
	 * @return int
	 * @since 1.0.0
	 *
	 */
	public function saveReactionsData( $post_id ) {

		if ( wp_is_post_revision( $post_id ) ) {
			return $post_id;
		}

		if ( ! isset( $_POST['_da_reactions_form_metabox_process'] ) ) {
			return $post_id;
		}

		if ( ! wp_verify_nonce( $_POST['_da_reactions_form_metabox_process'], '_da_reactions_form_metabox_nonce' ) ) {
			return $post_id;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$general_options = Options::getInstance( 'general' );
		$options_id      = $general_options->getOptionsGroupName();

		if ( ! isset( $_POST[ $options_id ] ) ) {
			return $post_id;
		}

		$post = get_post( $post_id );

		$general_options = Options::getInstance( 'general' );

		$general_options->removeOption( 'post_type_' . $post->post_type );
		$general_options->removeOption( 'post_type_' . $post->post_type . '_comments' );
		$general_options->removeOption( 'post_type_' . $post->post_type . '_disable_' . $post->ID );
		$general_options->removeOption( 'post_type_' . $post->post_type . '_enable_' . $post->ID );
		$general_options->removeOption( 'post_type_' . $post->post_type . '_disable_comments_' . $post->ID );
		$general_options->removeOption( 'post_type_' . $post->post_type . '_enable_comments_' . $post->ID );

		foreach ( $_POST[ $options_id ] as $key => $detail ) {
			$general_options->saveOption( filter_var( $key, FILTER_SANITIZE_STRING ), $detail );
		}

		return $post_id;

	}

}
