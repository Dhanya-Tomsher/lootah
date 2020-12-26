<?php
/**
 * Class GraphicSettings
 * @package DaReactions\Pages
 *
 * Admin settings page for graphic features
 *
 * @since 1.0.0
 */

namespace DaReactions\Pages;

use DaReactions\Data;
use DaReactions\FileSystem;
use DaReactions\Options;

/**
 * Class GraphicSettings
 * @package DaReactions\Pages
 *
 * Admin settings page for graphic features
 *
 * @since 1.0.0
 */
class GraphicSettings {

	/**
	 * @var string $options_group
	 * The name of the group for saved options
	 *
	 * @since 1.0.0
	 */
	private $options_group;

	/**
	 * @var string $options_page
	 * The slug of the settings page in wich the options are managed
	 *
	 * @since 1.0.0
	 */
	private $options_page;

	/**
	 * @var Options $options
	 * The Options instance to manage page settings
	 *
	 * @since 1.0.0
	 */
	private $options;

	/**
	 * GraphicSettings constructor.
	 *
	 * @param string $options_group
	 *
	 * @since 1.0.0
	 */
	public function __construct( $options_group ) {
		$this->options_group = $options_group;
		$this->options_page  = $options_group . '_page';
		$this->options       = Options::getInstance( 'graphic' );
	}

	/**
	 * Render settings page
	 *
	 * @since 1.0.0
	 */
	public function displayPage() {
		?>
        <form action="<?= 'options.php' ?>" method='post'>
			<?php
			settings_fields( $this->options_group );
			do_settings_sections( $this->options_page );
			submit_button();
			?>
        </form>
		<?php
	}

	/**
	 * Register all settings for this page
	 *
	 * @since 1.0.0
	 */
	public function initSettings() {

		register_setting(
			$this->options_group,
			$this->options_group,
			array( $this, 'sanitizeData' )
		);

		$section = 'graphic_section';
		$title   = __( 'Graphic Preferences', 'da-reactions' );
		$intro   = __( 'These are the graphics settings of reactions on your site, use these settings to determine the appearance, size, and text to be displayed.', 'da-reactions' );

		add_settings_section(
			$section,
			$title,
			$this->makeSectionRenderer( $intro ),
			$this->options_page
		);

		add_settings_field(
			'da_r_reactions_size_selector',
			__( 'Select size for reaction buttons', 'da-reactions' ),
			$this->makeTextfieldRenderer( 'button_size', '64', array(
				'min'   => '10',
				'type'  => 'number',
				'class' => 'refresh-preview'
			) ),
			$this->options_page,
			$section
		);

		$fade_methods = array(
			'none'         => __( 'None', 'da-reactions' ),
			'transparence' => __( 'Transparence', 'da-reactions' ),
			'desaturate'   => __( 'Desaturate', 'da-reactions' ),
			'blur'         => __( 'Blur', 'da-reactions' )
		);
		add_settings_field(
			'da_r_reactions_fade_method',
			__( 'Select fade method for inactive buttons', 'da-reactions' ),
			$this->makeSelectRenderer( 'fade_method', 'none', $fade_methods, array(
				'class' => 'refresh-preview'
			) ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_reactions_fade_amount',
			__( 'Fade effect value (0 - 100)', 'da-reactions' ),
			$this->makeTextfieldRenderer( 'fade_value', '50', array(
				'min'   => '0',
				'max'   => '100',
				'type'  => 'number',
				'class' => 'refresh-preview'
			) ),
			$this->options_page,
			$section
		);

		$templates = array(
			'exposed' => __( 'Exposed: all buttons are immediately visible', 'da-reactions' ),
			'reveal'  => __( ' Reveal: only the most used reaction is visible, other icons are revealed on click', 'da-reactions' ),
		);
		add_settings_field(
			'da_r_reactions_buttons_template_radio',
			__( 'Select a template for reactions', 'da-reactions' ),
			$this->makeSelectRenderer( 'use_template', 'exposed', $templates, array(
				'class' => 'refresh-preview'
			) ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_show_count',
			__( 'Show reactions count', 'da-reactions' ),
			array( $this, 'renderShowCountSelector' ),
			$this->options_page,
			$section
		);

		$alignments = array(
			'left'   => __( ' Align left', 'da-reactions' ),
			'center' => __( ' Center', 'da-reactions' ),
			'right'  => __( ' Align right', 'da-reactions' ),
		);
		add_settings_field(
			'da_r_reactions_buttons_alignment_radio',
			__( 'Select widget alignment', 'da-reactions' ),
			$this->makeSelectRenderer( 'buttons_alignment', 'center', $alignments, array(
				'class' => 'refresh-preview'
			) ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_reactions_description_text',
			__( 'Text do display before reaction buttons', 'da-reactions' ),
			array( $this, 'renderDescriptionTextEditor' ),
			$this->options_page,
			$section
		);
	}

	/**
	 * Return generic section render function
	 *
	 * @param $message
	 *
	 * @return \Closure
	 *
	 * @since 3.1.1
	 */
	public function makeSectionRenderer( $message ) {
		return function () use ( $message ) {

			echo "<p>$message</p>";

			echo '<hr>';
		};
	}

	/**
     * Return generic select field render function
     *
	 * @param $field_id
	 * @param $default
	 * @param $options
	 * @param array $attributes
	 *
	 * @return \Closure
	 */
	public function makeSelectRenderer( $field_id, $default, $options, $attributes = array() ) {
		return function () use ( $field_id, $default, $options, $attributes ) {
			$field_name  = $this->options->getFieldName( $field_id );
			$saved_value = $this->options->getOption( $field_id, $default );

			$additional_attributes = '';
			foreach ( $attributes as $key => $value ) {
				$additional_attributes .= ' ' . $key . '="' . $value . '"';
			}
			?>
            <p>
            <select
                    name="<?= $field_name; ?>"
				<?= $additional_attributes; ?>>
				<?php foreach ( $options as $key => $value ) { ?>
                    <option
                            value="<?= $key ?>" <?= ( $saved_value === $key ? 'selected' : '' ); ?>>
						<?= $value; ?>
                    </option>
				<?php } ?>
            </select>
			<?php
		};
	}

	/**
	 * Return generic input field render function
	 *
	 * @param $field_id
	 * @param $default
	 * @param array $attributes
	 *
	 * @return \Closure
	 */
	public function makeTextfieldRenderer( $field_id, $default, $attributes = array() ) {
		return function () use ( $field_id, $default, $attributes ) {
			$field_name  = $this->options->getFieldName( $field_id );
			$saved_value = absint( $this->options->getOption( $field_id, $default ) );

			$additional_attributes = '';
			foreach ( $attributes as $key => $value ) {
				$additional_attributes .= ' ' . $key . '="' . $value . '"';
			}
			?>
            <p>
                <input
                        id="id_<?= $field_name ?>"
					<?= $additional_attributes ?>
                        name="<?= $field_name ?>"
                        value="<?= $saved_value ?>"/>
            </p>
			<?php
		};
	}

	/**
	 * Render input field for text before Reaction Buttons
	 *
	 * @since 1.0.0
	 */
	public function renderDescriptionTextEditor() {

		$field_id    = 'wysiwyg_description_text';
		$saved_value = html_entity_decode( esc_html( $this->options->getOption( 'description_text', '' ) ) );

		$settings = array(
			'teeny'         => true,
			'textarea_rows' => 15,
			'tabindex'      => 1,
			'textarea_name' => $this->options->getFieldName( 'description_text' ),
			'media_buttons' => false
		);
		wp_editor( $saved_value, $field_id, $settings );
	}

	/**
	 * Render function for show count option selector
	 *
	 * @since 3.5.0
	 */
	public function renderShowCountSelector() {
		$field_name  = $this->options->getFieldName( 'show_count' );
		$saved_value = $this->options->getOption( 'show_count', 'always' );
		?>
        <p>
            <select id="id_<?= $field_name; ?>" name="<?= $field_name; ?>">
                <option value="always" <?= ( empty( $saved_value ) || $saved_value === 'always' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Always', 'da-reactions' ); ?></option>
                <option value="non-zero" <?= ( $saved_value === 'non-zero' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Only if greater than zero', 'da-reactions' ); ?></option>
                <option value="never" <?= ( $saved_value === 'never' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Never', 'da-reactions' ); ?></option>
            </select>
        </p>
		<?php
	}
}
