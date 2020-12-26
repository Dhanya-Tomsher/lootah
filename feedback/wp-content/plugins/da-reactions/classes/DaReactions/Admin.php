<?php
/**
 * Manages the admin features for this plugin
 *
 * Class Admin
 * @package DaReactions
 */

namespace DaReactions;

use DaReactions\Pages\ButtonsSettings;
use DaReactions\Pages\GeneralSettings;
use DaReactions\Pages\GraphicSettings;

/**
 * Manages the admin features for this plugin
 *
 * Class Admin
 * @package DaReactions
 */
class Admin {

	/**
	 * @var ButtonsSettings Instance of settings page
	 * @since 1.0.0
	 */
	private $buttons_settings_page;

	/**
	 * @var GeneralSettings Instance of settings page
	 * @since 1.0.0
	 */
	private $general_settings_page;

	/**
	 * @var GraphicSettings Instance of settings page
	 * @since 1.0.0
	 */
	private $graphic_settings_page;

	/**
	 * @var string $plugin_name
	 * The name of the plugin
	 *
	 * @since 1.0.0
	 */
	private $plugin_name;

	/**
	 * Admin constructor.
	 *
	 * @param Main $main
	 *
	 * @since 1.0.0
	 */
	public function __construct( Main $main ) {
		$this->plugin_name = $main->getPluginName();

		$third_party_plugins = [];
		if ( $main->isBuddyPressInstalled() ) {
			$third_party_plugins['buddypress'] = true;

		}


		if ( is_multisite() ) {
			$sites = get_sites();
			foreach ( $sites as $site ) {
				Options::createInstance( $this->plugin_name . '_buttons', 'buttons', $site->blog_id );
				Options::createInstance( $this->plugin_name . '_general', 'general', $site->blog_id );
				Options::createInstance( $this->plugin_name . '_graphic', 'graphic', $site->blog_id );
			}
		} else {
			Options::createInstance( $this->plugin_name . '_buttons', 'buttons' );
			Options::createInstance( $this->plugin_name . '_general', 'general' );
			Options::createInstance( $this->plugin_name . '_graphic', 'graphic' );
		}

		$this->buttons_settings_page = new ButtonsSettings( $this->plugin_name . '_buttons' );
		$this->general_settings_page = new GeneralSettings( $this->plugin_name . '_general', $main );
		$this->graphic_settings_page = new GraphicSettings( $this->plugin_name . '_graphic' );
	}

	/**
	 * Adds links to plugin row in main plugins page
	 *
	 * @param array $links
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function addPluginActionLinks( $links ) {

		if ( is_array( $links ) && isset( $links['edit'] ) ) {
			// We shouldn't encourage editing our plugin directly.
			unset( $links['edit'] );
		}

		$links['settings'] = '
		<a 
		href="' . admin_url( 'admin.php?page=da-reactions' ) . '"
		class="dashicons-before dashicons-admin-customizer"
		title="' . __( 'Settings', 'da-reactions' ) . '">
		    <span class="screen-reader-text">' . admin_url( 'admin.php?page=da-reactions' ) . '</span>
        </a>';

		$links['newsletter'] = '
		<a
		href="http://eepurl.com/dvA2nD"
		target="_blank"
		class="dashicons-before dashicons-email"
		title="' . __( 'Newsletter', 'da-reactions' ) . '">
		    <span class="screen-reader-text">' . admin_url( 'admin.php?page=da-reactions' ) . '</span>
        </a>';

		$links['help'] = '
		<a
		href="https://www.da-reactions-plugin.com/knowledge-base/"
		target="_blank"
		class="dashicons-before dashicons-sos"
		title="' . __( 'Help', 'da-reactions' ) . '">
		    <span class="screen-reader-text">' . __( 'Help', 'da-reactions' ) . '</span>
        </a>';

		/*
		$links['pro'] = '
		<a
		href="https://www.da-reactions-plugin.com/pricing/"
		target="_blank"
		style="color: red">
		    ' . __( 'Get PRO', 'da-reactions' ) . '
        </a>';
		*/

		return $links;
	}

	/**
	 * Registers admin menu pages
	 *
	 * @since 1.0.0
	 */
	public function addSettingsPage() {

		global $submenu;

		$image_string = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgMTE1LjY2OCAxMTUuNjY4IiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMTUuNjY4IDExNS42Njg7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCgk8cGF0aCBkPSJNNTcuODM0LDBDMjUuODkzLDAsMCwyNS44OTMsMCw1Ny44MzRjMCwzMS45NCwyNS44OTMsNTcuODM0LDU3LjgzNCw1Ny44MzRzNTcuODM0LTI1Ljg5NCw1Ny44MzQtNTcuODM0DQoJCUMxMTUuNjY4LDI1Ljg5Myw4OS43NzUsMCw1Ny44MzQsMHogTTI5LjE0LDUzLjM1OGMtNC41NDUsMC04LjI0Miw0LjQyMy04LjI0Miw5Ljg2aC02YzAtOC43NDYsNi4zODktMTUuODYsMTQuMjQyLTE1Ljg2DQoJCXMxNC4yNDIsNy4xMTQsMTQuMjQyLDE1Ljg2aC02QzM3LjM4Miw1Ny43ODEsMzMuNjg1LDUzLjM1OCwyOS4xNCw1My4zNTh6IE01Ny44MzQsOTcuMDA4Yy0xMC4zOTQsMC0xOC44Mi03LjMzMi0xOC44Mi0xNi4zNzUNCgkJaDM3LjY0Qzc2LjY1NCw4OS42NzYsNjguMjI5LDk3LjAwOCw1Ny44MzQsOTcuMDA4eiBNOTQuNzcyLDYzLjIxOGMwLTUuNDM3LTMuNjk2LTkuODYtOC4yNDItOS44NmMtNC41NDUsMC04LjI0MSw0LjQyMy04LjI0MSw5Ljg2DQoJCWgtNmMwLTguNzQ2LDYuMzg5LTE1Ljg2LDE0LjI0MS0xNS44NnMxNC4yNDIsNy4xMTQsMTQuMjQyLDE1Ljg2SDk0Ljc3MnoiLz4NCjwvc3ZnPg==';

		$menu_main_slug = $this->plugin_name;

		add_menu_page(
			__( 'Reactions', 'da-reactions' ), // Page title
			__( 'Reactions', 'da-reactions' ), // Menu title
			'manage_options', // Capability
			$menu_main_slug,
			null,
			$image_string,
			35
		);

		add_submenu_page(
			$menu_main_slug,
			__( 'Reactions manager', 'da-reactions' ), // Page title
			__( 'Reactions manager', 'da-reactions' ), // Menu title
			'manage_options',
			$menu_main_slug,
			array( $this->buttons_settings_page, 'displayPage' ) // Callback
		);

		add_submenu_page(
			$menu_main_slug,
			__( 'General settings', 'da-reactions' ), // Page title
			__( 'General settings', 'da-reactions' ), // Menu title
			'manage_options',
			$menu_main_slug . '_general_settings',
			array( $this->general_settings_page, 'displayPage' ) // Callback
		);

		add_submenu_page(
			$menu_main_slug,
			__( 'Graphic settings', 'da-reactions' ), // Page title
			__( 'Graphic settings', 'da-reactions' ), // Menu title
			'manage_options',
			$menu_main_slug . '_graphic_settings',
			array( $this->graphic_settings_page, 'displayPage' ) // Callback
		);

        $submenu['da-reactions'][30] = array(
	        '<span style="color: #f18500;"> ' . __( 'Help', 'da-reactions' ) . '</span>',
            'manage_options',
            'https://www.da-reactions-plugin.com/knowledge-base/',
            array( 'target' => '_blank')
        );

	}

	/**
	 * Deletes all reactions for deleted comments
	 *
	 * @param integer $comment_id The comment id
	 *
	 * @since 1.0.0
	 */
	public function deleteAllReactionsForComment( $comment_id ) {
		Data::deleteAllContentReactions( $comment_id, 'comment' );
	}

	/**
	 * Deletes all reactions for deleted posts
	 *
	 * @param integer $postid The post id
	 *
	 * @since 1.0.0
	 */
	public function deleteAllReactionsForContent( $postid ) {
		$post = get_post( $postid );
		Data::deleteAllContentReactions( $post->ID, $post->post_type );
	}

	/**
	 * Enqueues styles for admin
	 *
	 * @since 1.0.0
	 */
	public function enqueueStyles() {
		wp_enqueue_style(
			$this->plugin_name,
			DA_REACTIONS_URL . 'assets/dist/admin.css',
			array(),
			DA_REACTIONS_VERSION,
			'all'
		);
		wp_enqueue_style(
			$this->plugin_name . '_public',
			DA_REACTIONS_URL . 'assets/dist/public.css',
			array(),
			DA_REACTIONS_VERSION,
			'all'
		);
	}

	/**
	 * Enqueues scripts for admin
	 *
	 * @since 1.0.0
	 */
	public function enqueueScripts() {
		global $pagenow;

		$pages = array(
			'admin.php',
			'edit.php',
			'index.php',
			'plugins.php',
			'post.php',
            'nav-menus.php'
		);

		if ( in_array( $pagenow, $pages ) ) {

			$options = $this->general_settings_page->getOptions();

			if ( $pagenow === 'plugins.php' ) {
				/// Enqueue jQuery UI Dialog that is used to dusplay uninstall form confirmation
				wp_enqueue_script( 'jquery-ui-dialog' );
				wp_enqueue_style( 'wp-jquery-ui-dialog' );
			}

			wp_enqueue_script(
				$this->plugin_name,
				DA_REACTIONS_URL . 'assets/dist/admin.js',
				array(
					'jquery',
					'jquery-ui-sortable',
					'wp-color-picker'
				),
				DA_REACTIONS_VERSION,
				false
			);

			wp_enqueue_script(
				$this->plugin_name . '-menu',
				DA_REACTIONS_URL . 'assets/dist/admin.menu.js',
				array(
					'jquery'
				),
				DA_REACTIONS_VERSION,
				false
			);


			$current_user = wp_get_current_user();

			wp_localize_script( $this->plugin_name, 'DaReactionsAdmin', array(
				'remove_data_on_disable' => $options->getOption( 'remove_data_on_disable' ),
				'plugin_name'            => $this->plugin_name,
				'screen_name'            => get_current_screen(),
				'nonce'                  => wp_create_nonce( 'nonce' ),
				'non_sensitive_data'     => array(
					'version'   => get_bloginfo( 'version' ),
					'php'       => phpversion(),
					'multisite' => is_multisite()
				),
				'sensitive_data'         => array(
					'user_name'  => $current_user->display_name,
					'user_email' => $current_user->user_email,
					'site_url'   => get_site_url()
				),
				'strings'                => array(
					'DELETE_ON_DISABLE_CONFIRM'   => __( 'This action will delete all saved data, continue?', 'da-reactions' ),
					'DELETE_REACTION_ROW_CONFIRM' => __( 'Are you sure to delete this row?', 'da-reactions' ),
					'EXIT_WITHOUT_SAVING'         => __( 'Do you want to leave this page before saving?', 'da-reactions' ),
					'UNSUPPORTED_MIME_TYPE'       => __( 'Unsupported file format', 'da-reactions' ),
					'CONFIRM_BUTTON_LABEL'        => __( 'Confirm', 'da-reactions' ),
					'CANCEL_BUTTON_LABEL'         => __( 'Cancel', 'da-reactions' ),
				)
			) );

			if ( $pagenow === 'admin.php' && isset( $_GET['page'] ) && $_GET["page"] == "da-reactions_graphic_settings" ) {

				wp_enqueue_script(
					$this->plugin_name . '-frontend',
					DA_REACTIONS_URL . 'assets/dist/public.js',
					array(
						'jquery'
					),
					DA_REACTIONS_VERSION,
					false
				);

				$general_options = Options::getInstance( 'general' );
				$graphic_options = Options::getInstance( 'graphic' );

				wp_localize_script( $this->plugin_name . '-frontend', 'DaReactions', array(
					'ajax_url'                     => admin_url( 'admin-ajax.php' ),
					'display_detail_modal'         => $general_options->getOption( 'display_detail_modal', false ),
					'display_detail_modal_toolbar' => $general_options->getOption( 'display_detail_modal_toolbar', false ),
					'display_detail_tooltip'       => $general_options->getOption( 'display_detail_tooltip', false ),
					'modal_result_limit'           => absint( $general_options->getOption( 'modal_result_limit', 100 ) ),
					'tooltip_result_limit'         => absint( $general_options->getOption( 'tooltip_result_limit', 5 ) ),
					'show_count'                   => $graphic_options->getOption('show_count', 'always'),
					'loader_url'                   => DA_REACTIONS_URL . 'assets/dist/loading.svg',
					'nonce'                        => wp_create_nonce( 'da-reactions-preview' ),
				) );
			}
		}
	}

	/**
	 * Init all pages settings
	 *
	 * @since 1.0.0
	 */
	public function initSettings() {

		$this->buttons_settings_page->initSettings();
		$this->general_settings_page->initSettings();
		$this->graphic_settings_page->initSettings();
	}

	/**
	 * Register plugin widget
	 *
	 * @since 1.0.0
	 */
	public function registerWidgets() {
		register_widget( 'DaReactions\Widgets\ContentsByReactionWidget' );
	}

	/**
	 * Render HTML for confirmation modal
	 *
	 * @since 3.3.0
	 */
	public function renderModalHtml() {
		global $pagenow;
		if ( $pagenow === 'plugins.php' ) {
			$options     = $this->general_settings_page->getOptions();
			$remove_data = $options->getOption( 'remove_data_on_disable' ) === 'on'; ?>
            <div style="display: none">
            <div
                    id="da-reactions-dialog-confirm"
                    title="<?= esc_attr( __( 'Deactivate plugin?', 'da-reactions' ) ); ?>">
				<?php if ( $remove_data ) {
					?>
                    <div class="warning">
                        <h3><?= __( 'Warning!', 'da-reactions' ); ?></h3>
                        <p>
							<?= __( 'All data will be permanently deleted and cannot be recovered. Are you sure?', 'da-reactions' ); ?>
                        </p>
                        <p>
							<?= __( 'Want to deactivate without deleting all data? Change your preference first!', 'da-reactions' ); ?>
                            <a class=""
                               href="<?= admin_url( '?page=da-reactions_general_settings&tab=preferences' ); ?>">
								<?= __( 'Go to Preferences Page', 'da-reactions' ); ?>
                            </a>
                        </p>
                    </div>
                    <hr>
					<?php
				} ?>
                <h3><?= __( 'Please tell us why you are deactivating', 'da-reactions' ); ?></h3>
                <form>
                    <ul>
                        <li>
                            <input type="radio" name="reason" value="no-need" id="da-reactions-deactivation-reason-1">
                            <label for="da-reactions-deactivation-reason-1">
								<?= __( 'I no longer need the plugin.', 'da-reactions' ); ?>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="reason" value="no-work" id="da-reactions-deactivation-reason-2">
                            <label for="da-reactions-deactivation-reason-2">
								<?= __( 'The plugin does not work properly.', 'da-reactions' ); ?>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="reason" value="no-good" id="da-reactions-deactivation-reason-3">
                            <label for="da-reactions-deactivation-reason-3">
								<?= __( 'I found a better plugin.', 'da-reactions' ); ?>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="reason" value="graphic" id="da-reactions-deactivation-reason-4">
                            <label for="da-reactions-deactivation-reason-4">
								<?= __( 'Does not look good on my theme.', 'da-reactions' ); ?>
                            </label>
                        </li>
                        <li>
                            <input type="radio" name="reason" value="" id="da-reactions-deactivation-reason-5" checked>
                            <label for="da-reactions-deactivation-reason-5">
								<?= __( 'I don’t want to tell you (no data will be sent).', 'da-reactions' ); ?>
                            </label>
                        </li>
                    </ul>
                    <p>
                        <input type="checkbox" name="send_details" value="on" id="da-reactions-deactivation-details">
                        <label for="da-reactions-deactivation-details">
							<?= __( 'Add your email and site url to feedback message, WordPress version and PHP version will be sent.', 'da-reactions' ); ?>
                        </label>

                    </p>
                </form>

            </div>
            </div><?php
		}
	}
}
