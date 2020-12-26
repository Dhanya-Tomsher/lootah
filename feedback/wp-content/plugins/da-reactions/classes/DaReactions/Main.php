<?php
/**
 * Main class for plugin
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

use DaReactions\Plugins\BuddyPress;
use DaReactions\Plugins\Gutenberg;
use DaReactions\Plugins\Network;
use DaReactions\Widgets\DashboardWidget;

/**
 * Class Main
 * @package DaReactions
 *
 * Main class for plugin
 *
 * @since 1.0.0
 */
class Main {

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
	 * Flag to check if BuddyPress is installed
	 *
	 * @since   1.1.0
	 * @access  private
	 * @var     bool $buddy_press_installed
	 */
	protected $buddy_press_installed;

	/**
	 * Flag to check if Gutenberg Editor is installed
	 *
	 * @since   1.2.0
	 * @access  private
	 * @var     bool $gutenberg_installed ;
	 */
	protected $gutenberg_installed;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'da-reactions';

		$this->buddy_press_installed = false;

		$this->gutenberg_installed = function_exists( 'register_block_type' );

		$this->loader = new Loader();
		$this->setLocale();
		$this->defineAdminHooks();
		$this->definePublicHooks();

	}

	/**
	 * Mark BuddyPress as installed
	 *
	 * @since 3.0.0
	 */
	public function enableBuddyPress() {
		$this->buddy_press_installed = true;
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the \DaReactions\I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function setLocale() {

		$plugin_i18n = new I18n();

		$this->loader->addAction( 'plugins_loaded', $plugin_i18n, 'loadPluginTextdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function defineAdminHooks() {

		$plugin_admin            = new Admin( $this );
		$plugin_ajax             = new Ajax( $this );
		$plugin_meta_box         = new MetaBox( $this->getPluginName(), $this->loader );
		$plugin_custom_column    = new CustomColumn( $this->getPluginName() );
		$plugin_dashboard_widget = new DashboardWidget( $this->getPluginName() );


		// Enqueue styles
		$this->loader->addAction( 'admin_enqueue_scripts', $plugin_admin, 'enqueueStyles' );
		// Enqueue scripts
		$this->loader->addAction( 'admin_enqueue_scripts', $plugin_admin, 'enqueueScripts' );

		// Register admin pages
		$this->loader->addAction( 'admin_menu', $plugin_admin, 'addSettingsPage' );
		$this->loader->addAction( 'admin_init', $plugin_admin, 'initSettings' );

		// Register Admin AJAX actions
		$this->loader->addAction( 'wp_ajax_load_buttons_preview', $plugin_ajax, 'loadButtonsPreview' );

		// Register Widget
		$this->loader->addAction( 'widgets_init', $plugin_admin, 'registerWidgets' );

		// Add Links on Installed plugins list
		$this->loader->addFilter( 'plugin_action_links_' . DA_REACTIONS_NAME, $plugin_admin, 'addPluginActionLinks' );

		// Register meta box for edit pages and saves values
		$this->loader->addAction( "add_meta_boxes", $plugin_meta_box, 'addReactionsMetaBox' );
		$this->loader->addAction( "save_post", $plugin_meta_box, 'saveReactionsData' );

		// Add custom column to lists
		$this->loader->addAction( 'manage_posts_custom_column', $plugin_custom_column, 'displayPostsReactions' );
		$this->loader->addAction( 'manage_pages_custom_column', $plugin_custom_column, 'displayPostsReactions' );
		$this->loader->addFilter( 'manage_posts_columns', $plugin_custom_column, 'addReactionColumn' );
		$this->loader->addFilter( 'manage_pages_columns', $plugin_custom_column, 'addReactionColumn' );

		// Add Dashboard Widget
		$this->loader->addAction( 'wp_dashboard_setup', $plugin_dashboard_widget, 'addDashboardWidgets' );

		// Delete all related entry on content deletion
		$this->loader->addAction( "before_delete_post", $plugin_admin, 'deleteAllReactionsForContent' );
		$this->loader->addAction( "delete_comment", $plugin_admin, 'deleteAllReactionsForComment' );



		// Register BuddyPress specific hooks
		$this->loader->addAction( 'bp_include', $this, 'enableBuddyPress' );

		// Register modal for deactivation
		$this->loader->addAction( 'admin_footer', $plugin_admin, 'renderModalHtml' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks() {

		$plugin_public  = new Frontend( $this );
		$plugin_ajax    = new Ajax( $this );
		$plugin_user    = new User( $this );
		$plugin_archive = new Archive( $this );

		// Enqueue styles
		$this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueStyles' );
		$this->loader->addAction( 'wp_enqueue_scripts', $plugin_public, 'enqueueScripts' );

		// Register Public AJAX actions
		$this->loader->addAction( 'wp_ajax_add_reaction', $plugin_ajax, 'addReaction' );
		$this->loader->addAction( 'wp_ajax_nopriv_add_reaction', $plugin_ajax, 'addReaction' );
		$this->loader->addAction( 'wp_ajax_load_buttons', $plugin_ajax, 'loadButtons' );
		$this->loader->addAction( 'wp_ajax_nopriv_load_buttons', $plugin_ajax, 'loadButtons' );
		$this->loader->addAction( 'wp_ajax_get_users_reactions', $plugin_ajax, 'getUsersReactions' );
		$this->loader->addAction( 'wp_ajax_nopriv_get_users_reactions', $plugin_ajax, 'getUsersReactions' );

		// Register HTML injection on singles, archives and comments
		$this->loader->addFilter( 'the_content', $plugin_public, 'addButtonsToContent' );
		$this->loader->addFilter( 'the_excerpt', $plugin_public, 'addButtonsToExcerpt' );
		$this->loader->addFilter( 'comment_text', $plugin_public, 'addButtonsToComment' );

		// Register init actions
		$this->loader->addAction( 'init', $plugin_user, 'setCookie' );

		// Register router actions
		$this->loader->addAction( 'init', $plugin_archive, 'rewritesInit' );
		$this->loader->addAction( 'init', $plugin_archive, 'queryVars' );
		$this->loader->addAction( 'posts_selection', $plugin_archive, 'setReactionsArchive' );

		$this->loader->addAction( 'admin_head-nav-menus.php', $plugin_archive, 'setReactionsArchiveMenuItems' );
		$this->loader->addFilter( 'get_the_archive_title', $plugin_archive, 'setReactionsArchiveTitle' );
		$this->loader->addFilter( 'posts_fields_request', $plugin_archive, 'filterFields' );
		$this->loader->addFilter( 'posts_join_request', $plugin_archive, 'filterJoin' );
		$this->loader->addFilter( 'posts_where_request', $plugin_archive, 'filterWhere' );
		$this->loader->addFilter( 'posts_groupby_request', $plugin_archive, 'filterGroupBy' );



	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @return    string    The name of the plugin.
	 * @since     1.0.0
	 */
	public function getPluginName() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 * @since     1.0.0
	 */
	public function getLoader() {
		return $this->loader;
	}

	/**
	 * Tell if BuddyPress plugin is installed
	 *
	 * @return bool
	 *
	 * @since 1.1.0
	 */
	public function isBuddyPressInstalled() {
		return $this->buddy_press_installed;
	}

}
