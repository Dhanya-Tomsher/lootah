<?php
/**
 * Class Data
 *
 * Manages all database requests
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

/**
 * Class Data
 *
 * Manages all database requests
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */
class Data {

	/**
	 * Deletes all inactive reactions from database
	 *
	 * @since 1.0.0
	 */
	public static function clearDisabledReactions() {

		global $wpdb;

		$reactions_table_name = $wpdb->prefix . 'da_r_reactions';
		$votes_table_name     = $wpdb->prefix . 'da_r_votes';

		// Get all inactive reactions
		/** @noinspection SqlResolve */
		$query = "SELECT * FROM $reactions_table_name WHERE active = %d";

		$inactive_reactions = $wpdb->get_results(
			$wpdb->prepare(
				$query,
				0
			)
		);

		foreach ( $inactive_reactions as $inactive_reaction ) {
			$wpdb->delete(
				$votes_table_name,
				array(
					'emotion_id' => $inactive_reaction->ID
				)
			);
		}

		$wpdb->delete(
			$reactions_table_name,
			array(
				'active' => 0
			)
		);
	}

	/**
	 * Creates initial data
	 *
	 * @param null|string $prefix The table name prefix for a specific blog
	 *
	 * @since 1.0.0
	 */
	public static function createDefaultReactions( $prefix = null ) {
		global $wpdb;
		if ( null === $prefix ) {
			$prefix = $wpdb->prefix;
		}

		$wpdb->show_errors();

		$table_name = $prefix . 'da_r_reactions';

		$wpdb->insert( $table_name, array(
			'ID'         => 1,
			'label'      => 'Like',
			'color'      => '#8F9CDF',
			'file_name'  => 'like-1.svg',
			'sort_order' => 1
		) );
		$wpdb->insert( $table_name, array(
			'ID'         => 2,
			'label'      => 'Love',
			'color'      => '#DF8F9C',
			'file_name'  => 'love-2.svg',
			'sort_order' => 2
		) );
		$wpdb->insert( $table_name, array(
			'ID'         => 3,
			'label'      => 'Ah Ah',
			'color'      => '#DFD28F',
			'file_name'  => 'ah-ah-3.svg',
			'sort_order' => 3
		) );
		$wpdb->insert( $table_name, array(
			'ID'         => 4,
			'label'      => 'Wow',
			'color'      => '#9CDF8F',
			'file_name'  => 'wow-4.svg',
			'sort_order' => 4
		) );
		$wpdb->insert( $table_name, array(
			'ID'         => 5,
			'label'      => 'Sad',
			'color'      => '#8FDFD2',
			'file_name'  => 'sad-5.svg',
			'sort_order' => 5
		) );
		$wpdb->insert( $table_name, array(
			'ID'         => 6,
			'label'      => 'Grrr',
			'color'      => '#D28FDF',
			'file_name'  => 'grrr-6.svg',
			'sort_order' => 6
		) );

		$wpdb->hide_errors();
	}

	/**
	 * Create Reactions table on database
	 *
	 * @param null|string $prefix The table name prefix for a specific blog
	 *
	 * @since 1.0.0
	 */
	public static function createReactionsTable( $prefix = null ) {
		global $wpdb;
		if ( null === $prefix ) {
			$prefix = $wpdb->prefix;
		}

		$wpdb->show_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $prefix . 'da_r_reactions';

		$create_reactions_table_sql_string = "CREATE TABLE IF NOT EXISTS $table_name (
            ID mediumint(9) NOT NULL AUTO_INCREMENT,
            label varchar(36) NOT NULL DEFAULT %s,
            file_name varchar(36) NOT NULL DEFAULT %s,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            color varchar(36) NOT NULL DEFAULT %s,
            active smallint(1) NOT NULL DEFAULT %d,
            sort_order smallint(3) NOT NULL DEFAULT %d,
            PRIMARY KEY (ID)
        ) $charset_collate";

		$create_reactions_table_sql_string = $wpdb->prepare(
			$create_reactions_table_sql_string,
			'Reaction',
			'',
			'#006699',
			1,
			0
		);

		dbDelta( $create_reactions_table_sql_string );

		$wpdb->hide_errors();

	}

	/**
	 * Create Votes table on database
	 *
	 * @param null|string $prefix The table name prefix for a specific blog
	 *
	 * @since 1.0.0
	 */
	public static function createVotesTable( $prefix = null ) {
		global $wpdb;
		if ( null === $prefix ) {
			$prefix = $wpdb->prefix;
		}

		$wpdb->show_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$charset_collate = $wpdb->get_charset_collate();

		$table_name = $prefix . 'da_r_votes';

		$create_votes_table_sql_string = "CREATE TABLE IF NOT EXISTS $table_name (
            ID mediumint(9) NOT NULL AUTO_INCREMENT,
            resource_id mediumint(9),
            resource_type varchar(20),
            emotion_id mediumint(9) NOT NULL,
            user_id varchar(32),
            user_token varchar(32),
            user_ip varchar(16),
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            KEY da_reaction_resource_id (resource_id),
            KEY da_reaction_user_id (user_id),
            KEY da_reaction_resource_type (resource_type),
            PRIMARY KEY (id)
        ) $charset_collate";

		dbDelta( $create_votes_table_sql_string );

		$wpdb->hide_errors();

	}

	/**
	 * Deletes reaction for specific content
	 *
	 * @param int $item_id
	 * @param string $item_type
	 *
	 * @return bool|int
	 *
	 * @since 1.0.0
	 */
	public static function deleteAllContentReactions( $item_id = 0, $item_type = 'post' ) {

		if ( $item_id == 0 ) {
			return false;
		}

		global $wpdb;

		if ( $item_type != 'comment' ) {
			/** @noinspection SqlResolve */
			$query = "SELECT * FROM $wpdb->comments WHERE comment_post_ID = %d";

			$comments = $wpdb->get_results( $wpdb->prepare( $query, $item_id ) );

			foreach ( $comments as $comment ) {
				self::deleteAllContentReactions( $comment->comment_ID, 'comment' );
			};
		}


		$table_name = $wpdb->prefix . 'da_r_votes';

		return $wpdb->delete(
			$table_name,
			array(
				'resource_id'   => $item_id,
				'resource_type' => $item_type
			)
		);

	}

	/**
	 * Deletes reaction for specific user on specific content
	 *
	 * @param int $item_id
	 * @param string $item_type
	 *
	 * @return bool|int
	 *
	 * @since 1.0.0
	 */
	public static function deleteUserReaction( $item_id = 0, $item_type = 'post' ) {

		if ( $item_id == 0 ) {
			return false;
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_votes';

		$user_token = User::getUserToken();

		return $wpdb->delete(
			$table_name,
			array(
				'resource_id'   => $item_id,
				'resource_type' => $item_type,
				'user_token'    => $user_token
			)
		);
	}

	/**
	 * Deletes reactions for specific content blocks
	 * Leaves specific ids
	 * Used to clean database from deleted Gutenberg blocks
	 *
	 * @param string $resource_type
	 * @param array $exclude_ids
	 *
	 * @return int|bool
	 */
	public static function deleteGutenbergBlockVotes( $resource_type = '', $exclude_ids = array() ) {


		if ( empty( $resource_type ) ) {
			return false;
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_votes';


		$parameters = array( $resource_type );

		/** @noinspection SqlResolve */
		$sql = "DELETE FROM $table_name WHERE resource_type = %s";

		if ( count( $exclude_ids ) ) {
			$exclude_id_placeholders = implode( ', ', array_fill( 0, count( $exclude_ids ), '%d' ) );
			$parameters              = array_merge( $parameters, $exclude_ids );
			$sql                     = $sql . " AND resource_id NOT IN ($exclude_id_placeholders)";
		}

		return $wpdb->query( $wpdb->prepare( $sql, $parameters ) );
	}

	/**
	 * Marks all reactions as disabled
	 *
	 * @return false|int
	 *
	 * @since 1.0.0
	 */
	public static function disableAllReactions() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_reactions';

		return $wpdb->update(
			$table_name,
			array(
				'active' => '0'
			),
			array(
				'active' => '1'
			),
			array( '%d' ),
			array( '%d' )
		);
	}

	/**
	 * Drops custom tables from database
	 * Leaves DataBase clean after uninstall or deactivation
	 *
	 * @param null $prefix
	 *
	 * @since 1.0.0
	 */
	public static function dropTables( $prefix = null ) {
		global $wpdb;
		if ( null === $prefix ) {
			$prefix = $wpdb->prefix;
		}

		$wpdb->show_errors();

		$table_name = $prefix . 'da_r_reactions';
		$sql        = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );
		$table_name = $prefix . 'da_r_votes';
		$sql        = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query( $sql );

		$wpdb->hide_errors();
	}

	/**
	 * Retrieve all reactions from database
	 * Used for dashboard widgets
	 *
	 * @return array|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getAllContentReactions() {
		global $wpdb;

		$reactions_table = $wpdb->prefix . 'da_r_reactions';
		$votes_table     = $wpdb->prefix . 'da_r_votes';

		/** @noinspection SqlResolve */
		$query = "SELECT * FROM (
			SELECT 
				r.ID,
				r.label,
				r.file_name,
				r.active,
				r.color,
				r.sort_order,
				count(v.ID) AS total
			FROM $reactions_table r
			LEFT JOIN $votes_table v
				ON v.emotion_id = r.ID
				AND r.active = 1
			GROUP BY r.ID
			ORDER BY r.sort_order ) q;
		";

		$op = $wpdb->get_results( $query );

		return $op;
	}


	/**
	 * Get all reactions from database
	 *
	 * @return array|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getAllReactions() {
		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_reactions';

		/** @noinspection SqlResolve */
		$query = "SELECT * FROM $table_name ORDER BY sort_order";

		return $wpdb->get_results( $query );
	}


	/**
	 * Gets all comments ordered by reactions quantity
	 * Used in ContentsByReactionWidget->widget
	 *
	 * @param int $reaction_id
	 * @param int $limit
	 *
	 * @return array|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getCommentsByReaction( $reaction_id = 0, $limit = 5 ) {

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name    = "widget.typecomment.reaction$reaction_id.limit$limit";
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			return $cached_result;
		}

		global $wpdb;

		$votes_table = $wpdb->prefix . 'da_r_votes';

		$comments_table = $wpdb->comments;

		$args = array();

		/** @noinspection SqlResolve */
		$query = "SELECT c.comment_ID,
            c.comment_post_ID,
            c.comment_author,
            c.comment_date,
            c.comment_content,
            c.comment_approved,
            c.user_id,
            COUNT(v.ID) AS total_reactions
            
            FROM $comments_table c
            
            INNER JOIN $votes_table v
            
            ON v.resource_id= c.comment_ID
            
            AND v.resource_type = %s";

		$args[] = 'comment';

		if ( $reaction_id > 0 ) {
			$query  .= " AND v.emotion_id = %d ";
			$args[] = $reaction_id;
		};

		$query .= "WHERE c.comment_approved = %d
			GROUP BY c.comment_ID
            ORDER BY total_reactions DESC LIMIT %d";

		$args[] = 1;
		$args[] = absint( $limit );

		$prepared_query = $wpdb->prepare( $query, $args );

		$result = $wpdb->get_results( $prepared_query, OBJECT );

		Cache::set( $cache_name, $result );

		return $result;
	}

	/**
	 * Gets all contents ordered by reactions quantity
	 * Used in ContentsByReactionWidget->widget
	 *
	 * @param string $item_type
	 * @param int $reaction_id
	 * @param int $limit
	 *
	 * @return array|null|object
	 */
	public static function getContentsByReaction( $item_type = 'post', $reaction_id = 0, $limit = 5 ) {

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name    = "widget.type$item_type.reaction$reaction_id.limit$limit";
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			return $cached_result;
		}

		global $wpdb;

		$votes_table = $wpdb->prefix . 'da_r_votes';
		$posts_table = $wpdb->posts;

		$args   = array();
		$args[] = $item_type;
		$args[] = 'publish';

		/** @noinspection SqlResolve */
		$query = "SELECT p.ID,
            p.post_author,
            p.post_date,
            p.post_date_gmt,
            p.post_content,
            p.post_title,
            p.post_excerpt,
            p.post_status,
            p.comment_status,
            p.ping_status,
            p.post_password,
            p.post_name,
            p.to_ping,
            p.pinged,
            p.post_modified,
            p.post_modified_gmt,
            p.post_content_filtered,
            p.post_parent,
            p.guid,
            p.menu_order,
            p.post_type,
            p.post_mime_type,
            p.comment_count,
            COUNT(v.ID) AS total_reactions
            
            FROM $posts_table p
            
            INNER JOIN $votes_table v
            
            ON v.resource_id= p.ID
            
            AND v.resource_type = p.post_type
            
            WHERE p.post_type = %s
            
            AND p.post_status = %s";

		if ( $reaction_id > 0 ) {
			$query  .= "
			AND v.emotion_id = %d";
			$args[] = $reaction_id;
		};

		$query .= "
			GROUP BY p.ID
            
            ORDER BY total_reactions DESC
            
            LIMIT %d";

		$args[] = $limit;

		$prepared_query = $wpdb->prepare( $query, $args );

		$result = $wpdb->get_results( $prepared_query, OBJECT );

		Cache::set( $cache_name, $result );

		return $result;
	}

	/**
	 * Gets the most voted reaction for specific content
	 *
	 * @param $item_id
	 * @param $item_type
	 *
	 * @return array|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getMainReactionForContent( $item_id, $item_type ) {

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name    = "single.type$item_type.id$item_id";
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			return $cached_result;
		}

		global $wpdb;

		$reactions_table = $wpdb->prefix . 'da_r_reactions';
		$votes_table     = $wpdb->prefix . 'da_r_votes';

		/** @noinspection SqlResolve */
		$query = "SELECT
			r.ID,
			r.label,
			r.file_name,
			r.created_at,
			r.color,
			r.active,
			r.color,
			r.sort_order,
			count(v.ID) AS total
			
			FROM $reactions_table r
			INNER JOIN $votes_table v
							
			ON v.emotion_id = r.ID
						
			WHERE v.resource_type = %s
			AND v.resource_id = %d
			AND r.active = %d
			
			LIMIT 1;
		";

		$prepared_query = $wpdb->prepare(
			$query,
			$item_type,
			$item_id,
			1
		);

		$result = $wpdb->get_results(
			$prepared_query
		);

		Cache::set( $cache_name, $result );

		return $result;
	}

	/**
	 * Get reaction object by id
	 *
	 * @param int $reaction_id
	 *
	 * @return object | boolean
	 * @since 1.3.0
	 *
	 */
	public static function getReactionById( $reaction_id ) {

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name    = "reaction.reaction$reaction_id";
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			return $cached_result;
		}

		if ( $reaction_id === 0 ) {
			return false;
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_reactions';

		/** @noinspection SqlResolve */
		$query = "SELECT * FROM $table_name WHERE ID = %d";

		$prepared_query = $wpdb->prepare(
			$query,
			$reaction_id
		);

		$result = $wpdb->get_row(
			$prepared_query
		);

		Cache::set( $cache_name, $result );

		return $result;

	}

	/**
	 * Gets reaction for specific user on specific content
	 *
	 * @param int $item_id
	 * @param string $item_type
	 * @param bool $skip_cache
	 *
	 * @return array|bool|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getReactionForUser( $item_id = 0, $item_type = 'post', $skip_cache = false ) {

		$user_token = User::getUserToken();

		if ( ! $skip_cache ) {
			/**
			 * Get from cache
			 *
			 * @since 3.0.0
			 */
			$cache_name    = "single.user$user_token.id$item_id.type$item_type";
			$cached_result = Cache::get( $cache_name );
			if ( ! is_null( $cached_result ) ) {
				return $cached_result;
			}
		}

		if ( $item_id === 0 ) {
			return false;
		}

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_votes';


		/** @noinspection SqlResolve */
		$qry = "SELECT v.ID,
        v.resource_id,
        v.resource_type,
        v.emotion_id,
        v.user_id,
        v.user_token,
        v.created_at
        
    	FROM $table_name v
    	WHERE v.resource_id = %d
    	AND v.resource_type = %s
    	AND v.user_token = %s";

		$prepared_query = $wpdb->prepare( $qry, $item_id, $item_type, $user_token );

		$result = $wpdb->get_row( $prepared_query );

		if ( ! $skip_cache ) {
			Cache::set( $cache_name, $result );
		}

		return $result;

	}

	/**
	 * /**
	 * Gets reactions and users for specific item
	 *
	 * @param int $item_id
	 * @param string $item_type
	 * @param int $reaction_id
	 * @param int $limit
	 * @param int $pagenum
	 *
	 * @since 3.0.0
	 *
	 * @return array|mixed|null
	 */
	public static function getReactionsAndUsersForContent( $item_id = 0, $item_type = 'post', $reaction_id = 0, $limit = 10, $pagenum = 1 ) {

		$general_options          = Options::getInstance( 'general' );
		$default_votername        = $general_options->getOption( 'default_votername', 'Anon' );
		$display_anonymous_voters = $general_options->getOption( 'display_anonymous_voters', 'off' ) === 'on';

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name = "content.id$item_id.type$item_type.reaction$reaction_id.limit$limit.page$pagenum";
		/// @TODO: remove deleteAll
		Cache::deleteAll();
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			return $cached_result;
		}

		global $wpdb;

		$reactions_table = $wpdb->prefix . 'da_r_reactions';
		$votes_table     = $wpdb->prefix . 'da_r_votes';
		$users_table     = $wpdb->users;

		/** @noinspection SqlResolve */
		$base_query = "SELECT 
		COALESCE(u.display_name, %s) as display_name,
		r.label,
		r.file_name,
		v.resource_id,
		v.resource_type,
		v.emotion_id,
		v.user_id
		
		FROM $votes_table v
		LEFT JOIN $reactions_table r
		ON r.ID = v.emotion_id
		LEFT JOIN $users_table u
		ON u.ID = v.user_id
		WHERE v.resource_type = %s
		AND v.resource_id = %d
		AND (v.emotion_id = %d || %d = 0)";

		if ( ! $display_anonymous_voters ) {
			$base_query = $base_query . "
			AND v.user_id != 0";
		}

		$base_query = $base_query . "
		ORDER BY v.created_at DESC";

		$prepared_base_query = $wpdb->prepare(
			$base_query,
			$default_votername,
			$item_type,
			$item_id,
			$reaction_id,
			$reaction_id
		);

		$result_query = $prepared_base_query . $wpdb->prepare(
				' LIMIT %d, %d',
				( $pagenum - 1 ) * $limit,
				$limit
			);

		$total_query = "SELECT COUNT(1) FROM ($prepared_base_query) AS total";

		$result = $wpdb->get_results( $result_query );

		$total = $wpdb->get_var( $total_query );

		Cache::set( $cache_name, $result );

		return array(
			'records'    => $result,
			'pagination' => array(
				'total' => $total,
				'index' => $pagenum,
				'size'  => $limit
			)
		);
	}

	/**
	 * Gets all reactions for specific content
	 *
	 * @param $item_id
	 * @param $item_type
	 *
	 * @return array|null|object
	 *
	 * @since 1.0.0
	 */
	public static function getReactionsForContent( $item_id, $item_type ) {

		/**
		 * Get from cache
		 *
		 * @since 3.0.0
		 */
		$cache_name    = "content.id$item_id.type$item_type";
		$cached_result = Cache::get( $cache_name );
		if ( ! is_null( $cached_result ) ) {
			$result = $cached_result;
		} else {

			global $wpdb;

			$reactions_table = $wpdb->prefix . 'da_r_reactions';
			$votes_table     = $wpdb->prefix . 'da_r_votes';

			$gutenberg_item_type = $item_type . '-g' . $item_id;

			/** @noinspection SqlResolve */
			$query = "SELECT 
				r.ID,
				r.label,
				r.file_name,
				r.active,
				r.color,
				r.sort_order,
				count(v.ID) AS total
			FROM $reactions_table r
			LEFT JOIN $votes_table v
				ON v.emotion_id = r.ID
				AND (
						(
							v.resource_type = %s
							AND
							v.resource_id = %d
						)
						OR
						v.resource_type LIKE %s
					)
				AND r.active = 1
			GROUP BY r.ID
			ORDER BY r.sort_order;
		";

			$prepared_query = $wpdb->prepare(
				$query,
				$item_type,
				$item_id,
				$gutenberg_item_type
			);

			$result = $wpdb->get_results(
				$prepared_query
			);

			Cache::set( $cache_name, $result );
		}

		$user_reaction = self::getReactionForUser( $item_id, $item_type );

		foreach ( $result as $k => $item ) {
			if ( $user_reaction ) {
				$result[ $k ]->current = false;
				if ( $user_reaction->emotion_id === $item->ID ) {
					$result[ $k ]->current = true;
				}
			}
		}

		return $result;
	}

	/**
	 * Counts total reactions for a specific content type
	 * Used in DashboardWidget
	 *
	 * @param $content_type
	 *
	 * @return null|string
	 */
	public static function getTotalReactionsForContentType( $content_type ) {
		global $wpdb;

		$votes_table = $wpdb->prefix . 'da_r_votes';

		/** @noinspection SqlResolve */
		$query = "SELECT COUNT(ID) FROM $votes_table WHERE resource_type = %s OR resource_type LIKE %s";

		return $wpdb->get_var( $wpdb->prepare( $query, $content_type, $content_type . '-g%' ) );
	}

	/**
	 * Adds user reaction to database
	 *
	 * @param $item_id
	 * @param string $item_type
	 * @param int $reaction
	 *
	 * @return bool|false|int
	 *
	 * @since 1.0.0
	 */
	public static function insertUserReaction( $item_id, $item_type = 'post', $reaction = 0 ) {

		$user_token = User::getUserToken();

		Cache::delete( [ "id$item_id", "type$item_type", "user$user_token" ] );

		$general_options = Options::getInstance( 'general' );

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_votes';


		$user_ip = '';

		if ( $general_options->getOption( 'id_method_ip' ) === 'on' ) {
			$user_ip = User::getUserIp();
		}

		$current_user = wp_get_current_user();

		$current_user_reaction = self::getReactionForUser( $item_id, $item_type, true );

		if ( ! empty( $current_user_reaction ) ) {

			if ( $general_options->getOption( 'user_can_change_reaction' ) === 'on' ) {
				self::deleteUserReaction( $item_id, $item_type );
			} else {
				return false;
			}
		}

		$op = $wpdb->insert( $table_name, array(
			"resource_id"   => $item_id,
			"resource_type" => $item_type,
			"emotion_id"    => $reaction,
			"user_id"       => $current_user->ID,
			"user_token"    => $user_token,
			"user_ip"       => $user_ip
		), array( "%d", "%s", "%d", "%d", "%s", "%s" ) );

		return $op;
	}

	/**
	 * Updates or create a new reaction from ButtonSettings Page
	 *
	 * @param $reaction_id
	 * @param $reaction
	 *
	 * @return int
	 *
	 * @since 1.0.0
	 */
	public static function updateOrCreateReaction( $reaction_id, $reaction ) {

		Cache::delete( [ "reaction$reaction_id" ] );

		global $wpdb;

		$table_name = $wpdb->prefix . 'da_r_reactions';

		/** @noinspection SqlResolve */
		$query = "SELECT ID,
 				label,
 				file_name,
 				created_at,
 				color,
 				active,
 				sort_order
 				FROM $table_name WHERE ID = %d";

		$current_reaction = $wpdb->get_row(
			$wpdb->prepare(
				$query,
				$reaction_id
			)
		);

		$active     = '1';
		$label      = empty( $reaction['label'] ) ? 'Reaction' : sanitize_text_field( $reaction['label'] );
		$color      = preg_match( '/^#[a-f0-9]{6}$/i', $reaction['color'] ) ? $reaction['color'] : '#036789';
		$file_name  = isset( $reaction['file_name'] ) ? $reaction['file_name'] : '';
		$sort_order = absint( $reaction['sort_order'] );

		// Save reaction to database
		if ( isset( $current_reaction ) ) {
			$wpdb->update(
				$table_name,
				array(
					'active'     => $active,
					'label'      => $label,
					'color'      => $color,
					'file_name'  => $file_name,
					'sort_order' => $sort_order
				),
				array(
					'ID' => $reaction_id
				)
			);

			return $reaction_id;
		} else {
			$wpdb->insert( $table_name, array(
				'active'     => '1',
				'label'      => $label,
				'color'      => $color,
				'file_name'  => $file_name,
				'sort_order' => $sort_order
			) );

			return $wpdb->insert_id;
		}
	}
}
