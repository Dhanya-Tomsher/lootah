<?php
/**
 * Class GeneralSettings
 * @package DaReactions\Pages
 *
 * Admin general settings page
 *
 * @since 1.0.0
 */

namespace DaReactions\Pages;

use DaReactions\Main;
use DaReactions\Options;
use DaReactions\Plugins\BuddyPress;
use Closure;

/**
 * Class GeneralSettings
 * @package DaReactions\Pages
 *
 * Admin general settings page
 *
 * @since 1.0.0
 */
class GeneralSettings {

	/**
	 * @var string $current_tab
	 * Current tab identifier
	 *
	 * @since 3.1.1
	 */
	private $current_tab;

	/**
	 * @var Main $main
	 * A reference to Main instance
	 *
	 * @since 2.0.3
	 */
	private $main;

	/**
	 * @var array $navigation
	 * List of tabs
	 */
	private $navigation;

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
	 * GeneralSettings constructor.
	 *
	 * @param string $options_group
	 * @param Main $main
	 *
	 * @since 1.0.0
	 */
	public function __construct( $options_group, Main $main ) {
		$this->options_group = $options_group;
		$this->options_page  = $options_group . '_page';
		$this->options       = Options::getInstance( 'general' );
		$this->main          = $main;

		$this->navigation            = array();
		$this->navigation['general'] = array(
			'title'   => __( 'General', 'da-reactions' ),
			'visible' => true
		);
		$this->navigation['user']    = array(
			'title'   => __( 'User', 'da-reactions' ),
			'visible' => true
		);
		$this->navigation['performance'] = array(
			'title'   => __( 'Performance', 'da-reactions' ),
			'visible' => true
		);
		$this->navigation['preferences'] = array(
			'title'   => __( 'Preferences', 'da-reactions' ),
			'visible' => true
		);

		if ( isset( $_GET['tab'] ) ) {
			$this->current_tab = filter_var( $_GET['tab'], FILTER_SANITIZE_STRING );
		}
		if (
		! (
			array_key_exists( $this->current_tab, $this->navigation )
			&&
			$this->navigation[ $this->current_tab ]['visible'] === true
		)
		) {
			$this->current_tab = 'general';
		}
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
	 * Getter for this instace options
	 *
	 * @return Options
	 */
	public function getOptions() {
		return $this->options;
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

		if ( $this->current_tab === 'general' ) {
			$this->registerGeneralSettings();
		} else if ( $this->current_tab === 'user' ) {
			$this->registerUserSettings();
		} else if ( $this->current_tab === 'performance' ) {
			$this->registerPerformanceSettings();
		} else if ( $this->current_tab === 'preferences' ) {
			$this->registerPreferencesSettings();
		} else {
			wp_die( 'May I help you?' );
		}
	}

	/**
	 * Return generic checkbox render function
	 *
	 * @param $field_id
	 * @param $message
	 * @param array $attributes
	 *
	 * @return Closure
	 */
	public function makeCheckboxRenderer( $field_id, $message, $attributes = array() ) {
		return function () use ( $field_id, $message, $attributes ) {
			$field_name  = $this->options->getFieldName( $field_id );
			$saved_value = $this->options->getOption( $field_id );
			$checked     = isset( $saved_value ) && $saved_value == 'on';

			$additional_attributes = '';
			foreach ( $attributes as $key => $value ) {
				$additional_attributes .= ' ' . $key . '="' . $value . '"';
			}
			?>
            <p>

                <input
                        type="hidden"
                        name="<?= $field_name ?>"
                        value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?>
					<?= $additional_attributes ?>
                       value="on"/>
                <label for="id_<?= $field_name ?>"><?= $message; ?></label>
            </p>
			<?php
		};
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
			$this->renderNavigationTabs();

			echo "<p>$message</p>";

			echo '<hr>';
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
			$saved_value = $this->options->getOption( $field_id, $default );

			$additional_attributes = '';
			foreach ( $attributes as $key => $value ) {
				$additional_attributes .= ' ' . $key . '="' . $value . '"';
			}
			?>
            <p>
                <input
                        class="button_size_selector"
                        id="id_<?= $field_name ?>"
					<?= $additional_attributes ?>
                        name="<?= $field_name ?>"
                        value="<?= $saved_value ?>"/>
            </p>
			<?php
		};
	}



	/**
	 * Register General Settings Section
	 *
	 * @since 3.1.1
	 */
	public function registerGeneralSettings() {
		$section = 'performance_section';
		$title   = __( 'General settings', 'da-reactions' );
		$intro   = __( 'These are general settings, you can select to enable or disable reactions for specific content types and views.', 'da-reactions' );

		add_settings_section(
			$section,
			$title,
			$this->makeSectionRenderer( $intro ),
			$this->options_page
		);

		add_settings_field(
			'da_r_post_type_selector',
			__( 'Add reactions to post types and comments', 'da-reactions' ),
			array( $this, 'renderPostTypeSelector' ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_template_type_selector',
			__( 'Add reactions to single pages and/or archives too', 'da-reactions' ),
			array( $this, 'renderPageTypeSelector' ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_chart_colors_selector',
			__( 'Use different colors for chart widgets?', 'da-reactions' ),
			array( $this, 'renderChartColorSelector' ),
			$this->options_page,
			$section
		);
	}

	/**
	 * Register Performance Settings Section
	 *
	 * @since 3.1.1
	 */
	public function registerPerformanceSettings() {
		$section = 'performance_section';
		$title   = __( 'Performance settings', 'da-reactions' );
		$intro   = __( 'Use those settings to solve performances issues', 'da-reactions' );

		add_settings_section(
			$section,
			$title,
			$this->makeSectionRenderer( $intro ),
			$this->options_page
		);

		add_settings_field(
			'da_r_use_cache',
			__( 'Use plugin own cache system to serve generated widgets from disk?', 'da-reactions' ),
			$this->makeCheckboxRenderer(
				'enable_internal_cache',
				__( 'Enable internal plugin cache', 'da-reactions' )
			),
			$this->options_page,
			$section,
			array(
				'class' => 'enable_cache_selector'
			)
		);

		add_settings_field(
			'da_r_use_lazy_load',
			__( 'Enable asyncronous widget lazy load?', 'da-reactions' ),
			$this->makeCheckboxRenderer(
				'enable_lazy_load',
				__( 'Enable lazy load . ', 'da-reactions' )
			),
			$this->options_page,
			$section,
			array(
				'class' => 'enable_lazy_load_selector'
			)
		);
	}

	/**
	 * Register Plugin Settings Section
	 *
	 * @since 3.1.1
	 */
	public function registerPreferencesSettings() {
		$section = 'plugin_section';
		$title   = __( 'Plugin settings', 'da-reactions' );
		$intro   = __( 'These are plugin settings, select a method to identify unlogged users and check the delete option if you want to get rid of all data on plugin deactivation . ', 'da-reactions' );

		add_settings_section(
			$section,
			$title,
			$this->makeSectionRenderer( $intro ),
			$this->options_page
		);

		add_settings_field(
			'da_r_identification_method',
			__( 'Which identification method should be used for unregistered users?', 'da-reactions' ),
			array( $this, 'renderUserIdentificationMethod' ),
			$this->options_page,
			$section
		);

		add_settings_field(
			'da_r_remove_data_on_disable',
			__( 'Remove all data when disable (Warning! Cannot be undone!)', 'da-reactions' ),
			array( $this, 'renderRemoveDataOnDisableCheckbox' ),
			$this->options_page,
			$section
		);
	}

	/**
	 * Register User Settings Section
	 *
	 * @since 3.1.1
	 */
	public function registerUserSettings() {
		$section = 'performance_section';
		$title   = __( 'General settings', 'da-reactions' );
		$intro   = __( 'Users’ related settings.', 'da-reactions' );

		add_settings_section(
			$section,
			$title,
			$this->makeSectionRenderer( $intro ),
			$this->options_page
		);


		add_settings_field(
			'da_r_user_can_change',
			__( 'Can users change their reactions?', 'da-reactions' ),
			$this->makeCheckboxRenderer(
				'user_can_change_reaction',
				__( 'User can change reaction.', 'da-reactions' )
			),
			$this->options_page,
			$section
		);
	}

	/**
	 * Render function for color type selector
	 *
	 * @since 1.3.2
	 */
	public function renderChartColorSelector() {

		$field_name  = $this->options->getFieldName( "chart_colors" );
		$saved_value = $this->options->getOption( "chart_colors" );
		?>
        <p>
			<?php _e( 'Sometimes icons’ colors are way too similar to be used also for Charts, so you may change colors here . ' ); ?>
        </p>
        <p>
            <label for="id_<?= $field_name; ?>"><?php _e( 'Chart color scheme: ' ) ?></label>
            <select id="id_<?= $field_name; ?>" name="<?= $field_name; ?>">
                <option value="icons" <?= ( empty( $saved_value ) || $saved_value === 'icons' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Use buttons’ colors', 'da-reactions' ); ?></option>
                <option value="random" <?= ( $saved_value === 'random' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Use random generated colors', 'da-reactions' ); ?></option>
                <option value="default" <?= ( $saved_value === 'default' ) ? 'selected = "selected"' : ''; ?>>
					<?php _e( 'Use default rainbow palette', 'da-reactions' ); ?></option>
            </select>
        </p>
		<?php
	}

	/**
	 * Render function for navigation tabs
	 *
	 * @since 3.1.1
	 */
	public function renderNavigationTabs() {

		$page = $this->options_group . '_settings';
		echo '<h2 class="nav-tab-wrapper">';

		foreach ( $this->navigation as $key => $nav ) {
			$url          = admin_url( "admin.php?page=$page&tab=$key" );
			$active_class = $this->current_tab === $key ? ' nav-tab-active' : '';
			echo '<a href="' . $url . '" class="nav-tab' . $active_class . '">' . $nav['title'] . '</a >';
		}
		echo '</h2>';
	}

	/**
	 * Render function for page type checkgroup
	 *
	 * @since   1.0.0
	 */
	public function renderPageTypeSelector() {

		$registered_page_types = json_decode( '{
			"single": {
				"name": "single",
                "label": "' . __( 'Single pages and posts', 'da-reactions' ) . '"
            },
            "archive": {
				"name": "archive",
                "label": "' . __( 'Archives', 'da-reactions' ) . '"
            },
            "blog": {
				"name": "blog",
                "label": "' . __( 'Blog page', 'da-reactions' ) . '"
            }
        }' );

		foreach ( $registered_page_types as $page_type ) {
			$field_name  = $this->options->getFieldName( "page_type_$page_type->name" );
			$saved_value = $this->options->getOption( "page_type_$page_type->name" );
			$checked     = isset( $saved_value ) && $saved_value == 'on';
			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>"><?= $page_type->label ?></label>
            </p>
			<?php
		}

	}

	/**
	 * Render function for post type checkgroup
	 *
	 * @since   1.0.0
	 */
	public function renderPostTypeSelector() {

		$post_type_query = array(
			'public' => true,
		);
		$post_type_query['_builtin'] = true;

		$registered_post_types = get_post_types(
			$post_type_query,
			'objects'
		);

		foreach ( $registered_post_types as $post_type ) {

			$field_name  = $this->options->getFieldName( "post_type_$post_type->name" );
			$saved_value = $this->options->getOption( "post_type_$post_type->name" );
			$checked     = isset( $saved_value ) && $saved_value == 'on';
			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>"><?= $post_type->label ?></label>
				<?php

				if ( post_type_supports( $post_type->name, 'comments' ) ) {
					$post_type_name = $post_type->name;
					$field_name     = $this->options->getFieldName( "post_type_${post_type_name}_comments" );
					$saved_value    = $this->options->getOption( "post_type_${post_type_name}_comments" );
					$checked        = isset( $saved_value ) && $saved_value == 'on';
					?>
                    <input type="hidden" name="<?= $field_name ?>" value="off"/>
                    <input id="id_<?= $field_name ?>" type="checkbox"
                           name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                    <label for="id_<?= $field_name ?>"><?php _e( ' and their comments.', 'da-reactions' ); ?></label>
					<?php
				}
				?>
            </p>
			<?php
		}
	}

	/**
	 * Render function for remove data on plugin disable checkbox
	 *
	 * @since   1.0.0
	 */
	public
	function renderRemoveDataOnDisableCheckbox() {

		if ( ! is_multisite() || is_main_site() ) {

			$field_name  = $this->options->getFieldName( 'remove_data_on_disable' );
			$saved_value = $this->options->getOption( 'remove_data_on_disable' );
			$checked     = isset( $saved_value ) && $saved_value == 'on';

			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>"><?php _e( 'Delete all data when disable plugin . Warning! Lost data cannot be recovered . ', 'da-reactions' ); ?></label>
            </p>
			<?php

		} else {

			$field_name        = 'disabled_option';
			$main_site_options = Options::getInstance( 'general', get_main_site_id() );
			$saved_value       = $main_site_options->getOption( 'remove_data_on_disable' );
			$checked           = isset( $saved_value ) && $saved_value == 'on';

			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="disabled" <?php checked( $checked, 1 ) ?> value="on" disabled/>
                <label for="id_<?= $field_name ?>">
					<?php _e( 'This option is only available in main blog settings because may affect all blogs in this network . ', 'da-reactions' ); ?></label>
            </p>
			<?php
		}

	}

	/**
	 * Render function for user identifying method checkgroup
	 *
	 * @since 1.0.0
	 */
	public function renderUserIdentificationMethod() {

		$id_methods = array(
			'cookie' => array(
				'name' => __( 'Set cookie', 'da-reactions' )
			),
			'ip'     => array(
				'name' => __( 'Save IP address', 'da-reactions' )
			)
		);

		foreach ( $id_methods as $method_slug => $method_info ) {

			$field_name  = $this->options->getFieldName( "id_method_$method_slug" );
			$saved_value = $this->options->getOption( "id_method_$method_slug" );
			$checked     = isset( $saved_value ) && $saved_value == 'on';
			?>
            <p>
                <input type="hidden" name="<?= $field_name ?>" value="off"/>
                <input id="id_<?= $field_name ?>" type="checkbox"
                       name="<?= $field_name ?>" <?php checked( $checked, 1 ) ?> value="on"/>
                <label for="id_<?= $field_name ?>"><?= $method_info['name'] ?></label>
            </p>
			<?php
		}

	}


	/**
	 * Should validate input data, do nothing for now
	 *
	 * @param array $input
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public
	function sanitizeData(
		$input
	) {
		/**
		 * Preserve previously saved data
		 *
		 * @since 3.1.1
		 */
		$saved_options = $this->options->getAllOptions();
		foreach ( $input as $key => $value ) {
			$saved_options[ $key ] = $value;
		}

		return $saved_options;
	}

}
