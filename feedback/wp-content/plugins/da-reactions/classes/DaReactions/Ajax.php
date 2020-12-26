<?php
/**
 * Class Ajax
 *
 * Manages all ajax requests
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */

namespace DaReactions;

use DaReactions\Plugins\BuddyPress;

/**
 * Class Ajax
 *
 * Manages all ajax requests
 *
 * @package DaReactions
 *
 * @since 1.0.0
 */
class Ajax {

	/**
	 * The name of this plugin
	 *
	 * @var string $plugin_name
	 *
	 * @since 1.0.0
	 */
	private $plugin_name;

	/**
	 * List of all third party supported plugins
	 *
	 * @var array $third_party_plugins
	 *
	 * @since 1.3.2
	 */
	private $third_party_plugins;

	/**
	 * Ajax constructor.
	 *
	 * @param Main $main
	 *
	 * @since 1.0.0
	 */
	public function __construct( Main $main ) {

		$this->plugin_name = $main->getPluginName();

		$this->third_party_plugins = array();
		if ( $main->isBuddyPressInstalled() ) {
			$this->third_party_plugins['buddypress'] = true;
		}

	}

	/**
	 * Invoked from frontend when user clicks on a reaction button
	 *
	 * @since 1.0.0
	 */
	public function addReaction() {

		$general_options = Options::getInstance( 'general' );
		$item_id         = intval( $_POST['id'] );
		$nonce           = sanitize_text_field( $_POST['nonce'] );
		$item_type       = sanitize_text_field( $_POST['type'] );
		$current_user    = wp_get_current_user();
		$reaction        = intval( $_POST['reaction'] );

		if ( ! wp_verify_nonce( $nonce, $item_type . '-' . absint( $item_id ) ) ) {
			wp_send_json(
				array(
					'success' => 'no',
					'message' => __( 'Nonce error', 'da-reactions' )
				)
			);
			exit();
		}

		$user_role         = User::getUserRole( $current_user );
		$user_can_vote     = true;
		$operation_success = false;


		if ( $user_can_vote ) {
			if ( Data::insertUserReaction( $item_id, $item_type, $reaction ) ) {
				$operation_success = true;
			}
		}

		if ( ! empty( $this->third_party_plugins ) ) {
			$this->warnThirdPartyPlugins( $item_id, $item_type, $reaction, $operation_success );
		}

		if ( $operation_success ) {
			wp_send_json(
				array(
					'success'   => 'ok',
					'reactions' => Data::getReactionsForContent( $item_id, $item_type )
				)
			);
		}

		wp_send_json(
			array(
				'success' => 'no',
				'message' => __( 'Generic error', 'da-reactions' )
			)
		);

	}

	/**
	 * Walk result and add image and use details
	 *
	 * @param $item
	 */
	public function addDetails( $item ) {
		$this->addImages( $item );
		$this->addUserLink( $item );
	}

	/**
	 * Add user link to results
	 *
	 * @param $item
	 */
	public function addUserLink( $item ) {
		if ( function_exists( 'bp_core_get_user_domain' ) ) {
			$item->user_link = bp_core_get_user_domain( $item->user_id );
		} else {
			$item->user_link = get_author_posts_url( $item->user_id );
		}
	}

	/**
	 * Add image full path
	 *
	 * @param $item
	 */
	public function addImages( $item ) {
		$item->image = FileSystem::getImageUrl( $item->file_name );
	}

	/**
	 * Get User list and reactions
	 *
	 * @since 3.0.0
	 */
	public function getUsersReactions() {
		$item_id    = intval( $_POST['id'] );
		$item_type  = sanitize_text_field( $_POST['type'] );
		$emotion_id = intval( $_POST['reaction'] );
		$limit      = intval( $_POST['limit'] );
		$pagenum    = 1;
		$nonce      = sanitize_text_field( $_POST['nonce'] );
		if ( isset( $_POST['pagenum'] ) ) {
			$pagenum = max( intval( $_POST['pagenum'] ), 1 );
		}

		if ( ! wp_verify_nonce( $nonce, $item_type . '-' . absint( $item_id ) ) ) {
			wp_send_json(
				array(
					'success' => 'no',
					'message' => __( 'Nonce error', 'da-reactions' )
				)
			);
			exit();
		}

		$data = Data::getReactionsAndUsersForContent( $item_id, $item_type, $emotion_id, $limit, $pagenum );

		$reactions = Data::getAllReactions();
		foreach ( $reactions as $reaction ) {
			$reaction->image = FileSystem::getImageUrl( $reaction->file_name );
			if ( (int) $reaction->ID === (int) $emotion_id ) {
				$reaction->current = true;
			}
		}

		if ( is_array( $data['records'] ) ) {
			array_walk(
				$data['records'],
				array( $this, 'addDetails' )
			);
		}

		wp_send_json(
			array(
				'success'    => 'ok',
				'reactions'  => $data['records'],
				'pagination' => $data['pagination'],
				'buttons'    => $reactions
			)
		);
	}


	/**
	 * Invoked from frontend to load button asyncronously
	 *
	 * @since 1.0.0
	 */
	public function loadButtons() {
		header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
		header( "Cache-Control: post-check=0, pre-check=0", false );
		header( "Pragma: no-cache" );

		$_POST     = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
		$item_id   = intval( $_POST['id'] );
		$item_type = sanitize_text_field( $_POST['type'] );
		$nonce     = sanitize_text_field( $_POST['nonce'] );

		$valid_nonce = wp_verify_nonce( $nonce, $item_type . '-' . absint( $item_id ) );

		if ( strpos( $item_type, '-g' ) !== false ) {
			$valid_nonce = wp_verify_nonce( $nonce, 'nonce' );
		}

		if ( ! $valid_nonce ) {
			wp_send_json(
				array(
					'success' => 'no',
					'message' => __( 'Nonce error', 'da-reactions' )
				)
			);
			exit();
		}

		echo Frontend::getButtons( $item_type, $item_id );

		exit();
	}


	/**
	 * Invoked from backend to load buttons preview asyncronously
	 *
	 * @since 1.0.0
	 */
	public function loadButtonsPreview() {

		header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
		header( "Cache-Control: post-check=0, pre-check=0", false );
		header( "Pragma: no-cache" );

		$item_id   = - 1;
		$item_type = 'preview';
		$template  = sanitize_text_field( $_POST['da-reactions_graphic']['use_template'] );
		$size      = intval( $_POST['da-reactions_graphic']['button_size'] );
		$options   = Options::getInstance( 'preview' );
		$alignment = sanitize_text_field( $_POST['da-reactions_graphic']['buttons_alignment'] );
		$options->setOption( 'button_size', $size );
		$options->setOption( 'buttons_alignment', $alignment );
		$nonce = sanitize_text_field( $_POST['nonce'] );

		if ( wp_verify_nonce( $nonce, 'nonce' ) ) {

			$reactions = Data::getReactionsForContent( $item_id, $item_type );


			$method = sanitize_text_field( $_POST['da-reactions_graphic']['fade_method'] );
			$value  = intval( $_POST['da-reactions_graphic']['fade_value'] );
			$size   = intval( $_POST['da-reactions_graphic']['button_size'] );

			$style = Frontend::getInlineCss(
					$method,
					$value,
					$size
				) . '
#wpwrap {
	padding-bottom: ' . ( $size + 60 ) . 'px;
}		
div#reactions_preview {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: white;
    padding: 30px;
    z-index: 9990;
    box-sizing: border-box;
    opacity: 0.5;
}
div#reactions_preview:hover {
    opacity: 1;
}';
			$html  = 'Template not found error [' . $template . ']';
			switch ( $template ) {
				case 'exposed':
					$html = Frontend::renderTemplateExposed( $reactions, $options, $item_type, $item_id );
					break;
				case 'reveal':
					$html = Frontend::renderTemplateReveal( $reactions, $options, $item_type, $item_id );
					break;
			}

			wp_send_json(
				array(
					'success' => true,
					'html'    => $html,
					'style'   => $style
				)
			);
		}
		exit();
	}

	/**
	 * Send reaction to third party plugins
	 *
	 * @param $item_id
	 * @param $item_type
	 * @param $reaction
	 * @param $operation_success
	 *
	 * @since 1.3.0
	 *
	 */
	public function warnThirdPartyPlugins( $item_id, $item_type, $reaction, $operation_success ) {
		if ( $operation_success ) {
			if ( $this->third_party_plugins['buddypress'] ) {
				$bp_manager = new BuddyPress();
				$bp_manager->addActionToStream( $item_id, $item_type, $reaction );
			}
		}
	}
}
