<?php
/**
 * class Frontend
 * @package DaReactions
 * @since 1.0.0
 */

namespace DaReactions;

/**
 * Manages all frontend tasks such as print reactions buttons and load scripts and styles
 *
 * class Frontend
 * @package DaReactions
 * @since 1.0.0
 */
class Frontend {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param Main
	 *
	 * @since    1.0.0
	 *
	 */
	public function __construct( Main $main ) {

		$this->plugin_name = $main->getPluginName();

	}

	/**
	 * Inject reaction buttons HTML in comment content
	 *
	 * @param $comment_text
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function addButtonsToComment( $comment_text ) {

		global $post;

		$options = Options::getInstance( 'general' );

		$globally_enabled = $options->getOption( 'post_type_' . $post->post_type . '_comments' ) === 'on';
		$locally_enabled  = $options->getOption( 'post_type_' . $post->post_type . '_enable_comments_' . $post->ID ) === 'on';
		$locally_disabled = $options->getOption( 'post_type_' . $post->post_type . '_disable_comments_' . $post->ID ) === 'on';

		$enabled = ( $globally_enabled && ! $locally_disabled ) || $locally_enabled;

		if ( ! $enabled ) {
			return $comment_text;
		}

		global $comment;

		if ( is_singular() ) {
			$item_type = 'comment';
			$item_id   = $comment->comment_ID;

			$append = self::getButtonsPlaceholder( $item_type, $item_id );

			return $comment_text . $append;
		}

		return $comment_text;
	}

	/**
	 * Inject reaction buttons HTML in post content
	 *
	 * @param $content
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function addButtonsToContent( $content ) {

		global $post;

		$general_options = Options::getInstance( 'general' );

		$globally_enabled = $general_options->getOption( 'post_type_' . $post->post_type ) === 'on';
		$locally_enabled  = $general_options->getOption( 'post_type_' . $post->post_type . '_enable_' . $post->ID ) === 'on';
		$locally_disabled = $general_options->getOption( 'post_type_' . $post->post_type . '_disable_' . $post->ID ) === 'on';


		$enabled = ( $globally_enabled && ! $locally_disabled ) || $locally_enabled;

		if ( $enabled ) {
			if ( is_front_page() && is_home() ) {
				// Default homepage
				$enabled = $general_options->getOption( 'page_type_blog' ) === 'on';
			} elseif ( is_front_page() ) {
				// static homepage
			} elseif ( is_home() ) {
				// blog page
				$enabled = $general_options->getOption( 'page_type_blog' ) === 'on';
			} else if ( is_archive() ) {
				// archive page
				$enabled = $general_options->getOption( 'page_type_archive' ) === 'on';
			} else if ( is_singular() ) {
				$enabled = $general_options->getOption( 'page_type_single' ) === 'on';
			}
		}

		if ( ! $enabled ) {
			return $content;
		}

		$item_type = $post->post_type;
		$item_id   = $post->ID;
		$append    = self::getButtonsPlaceholder( $item_type, $item_id );

		return $content . $append;

	}

	/**
	 * Inject reaction buttons HTML in post excerpt
	 *
	 * @param $excerpt
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public function addButtonsToExcerpt( $excerpt ) {

		global $post;

		if ( ! $post ) {
			return false;
		}

		$general_options = Options::getInstance( 'general' );

		$globally_enabled = $general_options->getOption( 'post_type_' . $post->post_type ) === 'on';
		$locally_enabled  = $general_options->getOption( 'post_type_' . $post->post_type . '_enable_' . $post->ID ) === 'on';
		$locally_disabled = $general_options->getOption( 'post_type_' . $post->post_type . '_disable_' . $post->ID ) === 'on';
		$enabled          = ( $globally_enabled && ! $locally_disabled ) || $locally_enabled;

		if ( $enabled ) {
			if ( is_front_page() && is_home() ) {
				// Default homepage
				$enabled = $general_options->getOption( 'page_type_blog' ) === 'on';
			} elseif ( is_front_page() ) {
				// static homepage
			} elseif ( is_home() ) {
				// blog page
				$enabled = $general_options->getOption( 'page_type_blog' ) === 'on';
			} else if ( is_archive() ) {
				// archive page
				$enabled = $general_options->getOption( 'page_type_archive' ) === 'on';
			} else if ( is_singular() ) {
				$enabled = $general_options->getOption( 'page_type_single' ) === 'on';
			}
		}

		if ( ! $enabled ) {
			return $excerpt;
		}


		$item_type = $post->post_type;
		$item_id   = $post->ID;

		$append = self::getButtonsPlaceholder( $item_type, $item_id );

		return $excerpt . $append;
	}


	/**
	 * Registers the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueueStyles() {

		$graphic_options = Options::getInstance( 'graphic' );

		wp_enqueue_style(
			$this->plugin_name,
			DA_REACTIONS_URL . 'assets/dist/public.css',
			array(),
			DA_REACTIONS_VERSION,
			'all'
		);


		$fade_amount = absint( $graphic_options->getOption( 'fade_value', 50 ) );
		$fade_method = $graphic_options->getOption( 'fade_method', 'none' );
		$size        = absint( $graphic_options->getOption( 'button_size', 64 ) );

		$inline_css = self::getInlineCss( $fade_method, $fade_amount, $size );

		wp_add_inline_style( $this->plugin_name, $inline_css );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueueScripts() {

		$general_options = Options::getInstance( 'general' );
		$graphic_options = Options::getInstance( 'graphic' );

		wp_enqueue_script(
			$this->plugin_name,
			DA_REACTIONS_URL . 'assets/dist/public.js',
			array(
				'jquery',
			),
			DA_REACTIONS_VERSION,
			false
		);

		wp_localize_script( $this->plugin_name, 'DaReactions', array(
			'ajax_url'                     => admin_url( 'admin-ajax.php' ),
			'display_detail_modal'         => $general_options->getOption( 'display_detail_modal', false ),
			'display_detail_modal_toolbar' => $general_options->getOption( 'display_detail_modal_toolbar', false ),
			'display_detail_tooltip'       => $general_options->getOption( 'display_detail_tooltip', false ),
			'modal_result_limit'           => absint( $general_options->getOption( 'modal_result_limit', 100 ) ),
			'tooltip_result_limit'         => absint( $general_options->getOption( 'tooltip_result_limit', 5 ) ),
			'show_count'                   => $graphic_options->getOption('show_count', 'always'),
			'loader_url'                   => DA_REACTIONS_URL . 'assets/dist/loading.svg',
			'nonce'                        => wp_create_nonce( 'nonce' ),
		) );

	}

	/**
	 * Generates a placeholder to load buttons asyncronously
	 *
	 * @param $item_type
	 * @param $item_id
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getButtonsPlaceholder( $item_type, $item_id ) {
		$general_options = Options::getInstance( 'general' );
		$graphic_options = Options::getInstance( 'graphic' );
		if ( ! $general_options->getOption( 'enable_lazy_load', false ) ) {
			return self::getButtons( $item_type, $item_id );
		}

		$size = absint( $graphic_options->getOption( 'button_size', 64 ) );

		$alignment = $graphic_options->getOption( 'buttons_alignment', 'center' );

		$before_reactions = wpautop( $graphic_options->getOption( 'description_text', '' ) );

		$template = $graphic_options->getOption( 'use_template', 'exposed' );

		$element_id = 'da-reactions-slot-' . $item_type . '-' . absint( $item_id );

		$nonce = wp_create_nonce( $item_type . '-' . absint( $item_id ) );

		$op = '<div class="da-reactions-outer">' .
		      $before_reactions .
		      '<div class="da-reactions-data da-reactions-container-async ' . $alignment . '" data-type="' . $item_type . '" data-id="' . absint( $item_id ) . '" data-nonce="' . $nonce . '" id="' . $element_id . '">' .
		      '<div class="da-reactions-' . $template . '">' .
		      '<img alt="loading spinner" src="' . DA_REACTIONS_URL . 'assets/dist/loading.svg' . '" width="' . $size . '" height="' . $size . '" style="width:' . $size . 'px;height:' . $size . 'px">' .
		      '</div>' .
		      '</div>' .
		      '</div>';

		return $op;
	}

	/**
	 * Return html string for count badge
	 *
	 * @param $count
	 *
	 * @return string
	 */
	public static function getCountBadge( $count ) {
		$graphic_options   = Options::getInstance( 'graphic' );
		$showCounterOption = $graphic_options->getOption( 'show_count', 'always' );

		$style = 'style="display: none;"';

		if ( $showCounterOption === 'always' || ( $showCounterOption === 'non-zero' && $count > 0 ) ) {
			$style = '';
		}

		return '<div class="count" ' . $style . '>' . Utils::formatBigNumber( $count ) . '</div>';
	}

	/**
	 * Return css string for inline style
	 *
	 * @param $fade_method
	 * @param $fade_amount
	 * @param $size
	 *
	 * @return string
	 */
	public static function getInlineCss( $fade_method, $fade_amount, $size ) {
		$inline_css = '';
		switch ( $fade_method ) {
			case 'transparence':
				$value      = 1 - ( $fade_amount / 100 );
				$inline_css = "
		            div.da-reactions-container.has_current div.reaction img {
                        opacity: $value;
                    }
                    div.da-reactions-container.has_current div.reaction:hover img,
                    div.da-reactions-container.has_current div.reaction.active img {
                        opacity: 1;
                    }";
				break;
			case 'desaturate':
				$value      = $fade_amount;
				$inline_css = "
		            div.da-reactions-container.has_current div.reaction img {
                        filter: grayscale($value%);
                    }
                    div.da-reactions-container.has_current div.reaction:hover img,
                    div.da-reactions-container.has_current div.reaction.active img {
                        filter: none;
                    }";
				break;
			case 'blur':
				$value      = $fade_amount * $size / 200;
				$inline_css = "
		            div.da-reactions-container.has_current div.reaction img {
                        filter: blur(${value}px);
                    }
                    div.da-reactions-container.has_current div.reaction:hover img,
                    div.da-reactions-container.has_current div.reaction.active img {
                        filter: none;
                    }";
				break;
		}

		return $inline_css;
	}

	/**
	 * Generates Reaction buttons HTML markup
	 *
	 * @param $item_type
	 * @param $item_id
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getButtons( $item_type, $item_id ) {

		$graphic_options = Options::getInstance( 'graphic' );

		$template = $graphic_options->getOption( 'use_template', 'exposed' );

		$reactions = Data::getReactionsForContent( $item_id, $item_type );

		switch ( $template ) {
			case 'exposed':
				return self::renderTemplateExposed( $reactions, $graphic_options, $item_type, $item_id );
				break;
			case 'reveal':
				return self::renderTemplateReveal( $reactions, $graphic_options, $item_type, $item_id );
				break;
			default:
				return 'Template not found error [' . $template . ']';
		}
	}

	/**
	 * Generates an hamburger menu toggle for mobile
	 *
	 * @param int $size The size in pixels
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private static function getToggleButton( $size = 64 ) {
		$op = '<div class="reactions-toggle">' .
		      '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
	            viewBox="0 0 100 100" width="' . $size . '" height="' . $size . '" xml:space="preserve">' .
		      '<path class="bar1" d="M100,10.716c0,4.261-3.455,7.716-7.716,7.716H7.717c-4.261,0-7.716-3.455-7.716-7.716l0,0C0.001,6.455,3.455,3,7.717,3
            	h84.567C96.545,3,100,6.455,100,10.716L100,10.716z"/>' .
		      '<path class="bar2" d="M100,49.732c0,4.262-3.455,7.716-7.716,7.716H7.717c-4.261,0-7.716-3.454-7.716-7.716l0,0c0-4.261,3.455-7.716,7.716-7.716
                    h84.567C96.545,42.016,100,45.471,100,49.732L100,49.732z"/>' .
		      '<path class="bar3" d="M100,88.749c0,4.261-3.455,7.716-7.716,7.716H7.717c-4.261,0-7.716-3.455-7.716-7.716l0,0c0-4.261,3.455-7.716,7.716-7.716
                    h84.567C96.545,81.033,100,84.487,100,88.749L100,88.749z"/>' .
		      '</svg>' .
		      '</div>';

		return $op;

	}

	/**
	 *
	 * Generate HTML markup for the “exposed” template
	 *
	 * @param $reactions
	 * @param $graphic_options
	 * @param $item_type
	 * @param $item_id
	 *
	 * @return string
	 */
	public static function renderTemplateExposed( $reactions, $graphic_options, $item_type, $item_id ) {

		/** @var Options $graphic_options */
		$size = absint( $graphic_options->getOption( 'button_size', 64 ) );

		$alignment = $graphic_options->getOption( 'buttons_alignment', 'center' );

		$has_current = false;
		foreach ( $reactions as $reaction ) {
			if ( @$reaction->current ) {
				$has_current = true;
				continue;
			}
		}

		$nonce = wp_create_nonce( $item_type . '-' . absint( $item_id ) );

		$op = '';
		$op .= '<div class="da-reactions-container ' . $alignment . ' ' . ( $has_current ? 'has_current' : '' ) . '">';
		$op .= self::getToggleButton( $size );
		$op .= '<div class="reactions">';
		foreach ( $reactions as $reaction ) {
			$image = FileSystem::getImageUrl( $reaction->file_name );
			$op    .= '<div ' .
			          'class="da-reactions-data reaction reaction_' . $reaction->ID . ' ' . ( @$reaction->current ? 'active' : 'inactive' ) . '" ' .
			          'data-id="' . $item_id . '" ' .
			          'data-nonce="' . $nonce . '" ' .
			          'data-reaction="' . $reaction->ID . '" ' .
			          'data-title="' . $reaction->label . '" ' .
			          'data-type="' . $item_type . '" >' .
			          '<img src="' . $image . '" alt="' . $reaction->label . '" width="' . $size . '" height="' . $size . '" />' .
			          Frontend::getCountBadge( $reaction->total ) .
			          '</div>';
		}
		$op .= '</div></div>';

		return $op;
	}

	/**
	 * Generate HTML markup for the “reveal” template
	 *
	 * @param $reactions
	 * @param $graphic_options
	 * @param $item_type
	 * @param $item_id
	 *
	 * @return string
	 */
	public static function renderTemplateReveal( $reactions, $graphic_options, $item_type, $item_id ) {

		/** @var Options $graphic_options */
		$size = absint( $graphic_options->getOption( 'button_size', 64 ) );

		$alignment = $graphic_options->getOption( 'buttons_alignment', 'center' );

		$visible_reaction = $data = array_reduce( array_reverse( $reactions ), function ( $a, $b ) {
			return @$a->total > $b->total ? $a : $b;
		} );

		$has_current = false;
		$total_count = 0;
		foreach ( $reactions as $reaction ) {
			$total_count += $reaction->total;
			if ( @$reaction->current ) {
				$has_current      = true;
				$visible_reaction = $reaction;
			}
		}
		$visible_reaction_image = FileSystem::getImageUrl( $visible_reaction->file_name );

		$nonce = wp_create_nonce( $item_type . '-' . absint( $item_id ) );


		$op = '';
		$op .= '<div class="da-reactions-reveal ' . $alignment . '">';

		$op .= '<div class="before-reveal">';
		$op .= '<img
	        src="' . $visible_reaction_image . '"
			alt="' . __( 'Add your reaction', 'da-reactions' ) . '"
		    width="' . $size . '"
	        height="' . $size . '" />';
		$op .= Frontend::getCountBadge( $total_count );
		$op .= '</div>';

		$op .= '<div class="after-reveal da-reactions-container ' . ( $has_current ? 'has_current' : '' ) . '">';
		foreach ( $reactions as $reaction ) {
			$image = FileSystem::getImageUrl( $reaction->file_name );
			$op    .= '<div ' .
			          'class="da-reactions-data reaction reaction_' . $reaction->ID . ' ' . ( @$reaction->current ? 'active' : 'inactive' ) . '" ' .
			          'data-id="' . $item_id . '" ' .
			          'data-nonce="' . $nonce . '" ' .
			          'data-reaction="' . $reaction->ID . '" ' .
			          'data-title="' . $reaction->label . '" ' .
			          'data-type="' . $item_type . '" >' .
			          '<img src="' . $image . '" alt="' . $reaction->label . '" width="' . $size . '" height="' . $size . '" />' .
			          Frontend::getCountBadge( $reaction->total ) .
			          '</div>';
		}
		$op .= '</div>';

		$op .= '</div>';

		return $op;
	}

}
