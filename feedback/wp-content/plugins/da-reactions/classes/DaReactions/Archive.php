<?php
/**
 * Class CustomColumn
 * @package DaReactions
 *
 * Adds a custom column to content lists
 *
 * @since 3.6.0
 */


namespace DaReactions;

use Walker_Nav_Menu_Checklist;

/**
 * Class Archive
 * @package DaReactions
 *
 * Adds a reaction based archive page
 *
 * @since 3.6.0
 */
class Archive {
	const PARAM_NAME = 'da_reaction_id';
	const ROUTE_PREFIX = 'reaction';

	/**
	 * Archive constructor.
	 *
	 * @param Main $main
	 */
	public function __construct( Main $main ) {
	}

	/**
	 * Register rewrite rule to access reactions archive pages
	 *
	 * @since 3.6.0
	 */
	public function rewritesInit() {

		$route_regex = self::ROUTE_PREFIX . '/([0-9]+)/?$';

		add_rewrite_rule(
			$route_regex,
			'index.php?' . self::PARAM_NAME . '=$matches[1]',
			'top'
		);

		$registered_rules = get_option( 'rewrite_rules' );

		if ( ! isset( $registered_rules[ $route_regex ] ) ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	}

	/**
	 * Add a new rewrite tag (like %postname%).
	 *
	 * @param $query_vars
	 */
	public function queryVars( $query_vars ) {
		add_rewrite_tag( '%' . self::PARAM_NAME . '%', '([^&]+)' );
	}


	/**
	 * Set Reactions archive as archive page in order to load archive template
	 */
	public function setReactionsArchive() {
		$reaction_id = $this->getReactionId();
		if ( $reaction_id ) {
			$reaction = Data::getReactionById( $reaction_id );
			if ( $reaction ) {
				global $wp_query;
				if ( $wp_query->is_main_query() ) {
					$wp_query->is_home    = false;
					$wp_query->is_archive = true;
				}
			}
		}
	}

	/**
	 * Generates code for menu items in menu
	 */
	public function renderReactionsArchiveMenuItems() {
		global $nav_menu_selected_id;
		$reactions = Data::getAllReactions();

		?>
        <div id="da-reactions-plugin-div" class="posttypediv">
            <h4><?php _e( 'Archive by Reaction', 'da-reactions' ) ?></h4>
            <div id="tabs-panel-da-reactions-plugin-all" class="tabs-panel tabs-panel-active">
                <ul id="da-reactions-checklist-pop" class="categorychecklist form-no-clear">
					<?php
					foreach ( $reactions as $reaction ) {
						?>
                        <li>
                            <label class="menu-item-title">
                                <input type="checkbox" class="menu-item-checkbox"
                                       name="<?= esc_attr( $reaction->label ); ?>"
                                       value="<?= get_site_url(null, self::ROUTE_PREFIX . '/' . $reaction->ID); ?>">
                                <img src="<?= FileSystem::getImageUrl( $reaction->file_name ); ?>"
                                     alt="<?= esc_attr( $reaction->label ); ?>" style="width: 1em; height: auto;"/>
								<?= $reaction->label; ?>
                            </label>
                        </li>
						<?php
					}
					?>
                </ul>
            </div>
            <p class="button-controls">
		<span class="add-to-menu">
			<input
                    type="submit"
				<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?>
				class="button-secondary submit-add-to-menu right"
                    value="<?php esc_attr_e( 'Add to Menu' ); ?>"
                    name="add-da-reactions-menu-item"
                    id="submit-da-reactions-menu-item"/>
			<span class="spinner"></span>
		</span>
            </p>
        </div>
		<?php
	}

	/**
	 * Add block to side meta
	 */
	public function setReactionsArchiveMenuItems() {
		global $wp_meta_boxes;

		if ( ! isset( $wp_meta_boxes['nav-menus'] ) ) {
			$wp_meta_boxes['nav-menus'] = [];
		}
		if ( ! isset( $wp_meta_boxes['nav-menus']['side'] ) ) {
			$wp_meta_boxes['nav-menus']['side'] = [];
		}
		if ( ! isset( $wp_meta_boxes['nav-menus']['side']['default'] ) ) {
			$wp_meta_boxes['nav-menus']['side']['default'] = [];
		}
		if ( ! isset( $wp_meta_boxes['nav-menus']['side']['default']['da-reactions-archives'] ) ) {
			$wp_meta_boxes['nav-menus']['side']['default']['da-reactions-archives'] = [
				"id"       => 'da-reactions-archives',
				"title"    => __( 'Archive by Reaction', 'da-reactions' ),
				"callback" => array( $this, "renderReactionsArchiveMenuItems" ),
				"args"     => null
			];
		}
	}

	/**
	 * Changes archive title
	 *
	 * @param $title
	 *
	 * @return string
	 */
	public function setReactionsArchiveTitle( $title ) {
		$reaction_id = $this->getReactionId();

		if ( $reaction_id ) {
			$reaction = Data::getReactionById( $reaction_id );

			if ( $reaction ) {
				$title = sprintf( __( 'Archive for %s reaction', 'text_domain' ), $reaction->label );
			}
		}

		return $title;
	}

	/**
	 * Retrieve reaction_id in the WP_Query class.
	 *
	 * @return bool|int
	 */
	private function getReactionId() {
	    global $wp_query;
	    if (isset($wp_query)) {
		    $reaction_id = get_query_var( self::PARAM_NAME );
		    if ( isset( $reaction_id ) ) {
			    return (int) $reaction_id;
		    }
	    }

		return false;
	}

	/**
	 * Add JOIN clause to query
	 *
	 * @param $join
	 *
	 * @return string
	 */
	function filterJoin( $join ) {

		$reaction_id = $this->getReactionId();

		if ( $reaction_id ) {
			global $wp_query;


			if ( $wp_query->is_main_query() ) {
				global $wpdb;
				$votes_table = $wpdb->prefix . 'da_r_votes';
				$join        .= " INNER JOIN $votes_table v ON $wpdb->posts.ID = v.resource_id";
			}
		}


		return $join;
	}

	/**
	 * Check if we are in the right place to apply all filters
	 *
	 * @return bool
	 */
	private function shouldFilterQuery() {
		global $wp_query;
		$reaction_id = $this->getReactionId();

		return ( (int) $reaction_id > 0 && $wp_query->is_main_query() );
	}

	/**
	 * Add reactions count to queried params
	 *
	 * @param $fields
	 *
	 * @return string
	 */
	function filterFields( $fields ) {
		if ( $this->shouldFilterQuery() ) {
			$fields .= ', COUNT(v.ID) AS total_reactions';
		}

		return $fields;
	}

	/**
	 * Add WHERE clause
	 *
	 * @param $where
	 *
	 * @return string
	 */
	function filterWhere( $where ) {
		$reaction_id = $this->getReactionId();

		if ( $this->shouldFilterQuery() ) {
			$where .= " AND (v.emotion_id = $reaction_id)";
		}

		return $where;
	}

	/**
	 * Add GROUPBY clause
	 *
	 * @param $groupby
	 *
	 * @return string
	 */
	function filterGroupBy( $groupby ) {
		if ( $this->shouldFilterQuery() ) {
			global $wpdb;
			$groupby .= " $wpdb->posts.ID";
		}

		return $groupby;
	}
}
