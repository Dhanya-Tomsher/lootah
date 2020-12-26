<?php
/**
 * Widget API: ContentsByReactionWidget extends WP_Widget
 *
 * @package DaReactions
 * @subpackage Widgets
 * @since 1.0.0
 */

namespace DaReactions\Widgets;

use DaReactions\FileSystem;
use WP_Widget;
use DaReactions\Data;

/**
 * Class ContentsByReactionWidget
 * @package DaReactions\Widgets
 *
 * Defines a widget to display most voted contents
 *
 * @since 1.0.0
 */
class ContentsByReactionWidget extends WP_Widget {

	/**
	 * ContentsByReactionWidget constructor.
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		parent::__construct(
			'da-reactions-most-voted-widget',
			__( 'Content with most reactions', 'da-reactions' ),
			array(
				'description' => __( 'Displays content with most reactions, can be filtered by content type and specific reaction', 'da-reactions' )
			)
		);
	}

	/**
	 * Render the widget on frontend
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}
		$show_reaction = isset( $instance['show_reaction'] ) ? $instance['show_reaction'] : false;
		$reaction      = isset( $instance['reaction'] ) ? intval( $instance['reaction'] ) : 0;
		$post_type     = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';

		if ( $post_type === 'comments' ) {
			$r = Data::getCommentsByReaction( $reaction, $number );
		} else {
			$r = Data::getContentsByReaction( $post_type, $reaction, $number );
		}

		?>
		<?php echo $args['before_widget']; ?>
		<?php
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
        <ul>
			<?php

			if ( count( $r ) < 1 ) {
				echo( '<li>' );
				_e( 'No reactions found.', 'da-reactions' );
				echo( '</li>' );
			} else if ( $post_type === 'comments' ) {
				$post_ids = array_unique( wp_list_pluck( $r, 'comment_post_ID' ) );
				_prime_post_caches( $post_ids, strpos( get_option( 'permalink_structure' ), '%category%' ), false );

				foreach ( (array) $r as $comment ) {

					$limit        = 50; /// Limit comment text
					$comment_text = strip_tags( $comment->comment_content );
					if ( strlen( $comment_text ) > $limit ) {
						$stringCut    = substr( $comment_text, 0, $limit );
						$endPoint     = strrpos( $stringCut, ' ' );
						$comment_text = $endPoint ? substr( $stringCut, 0, $endPoint ) : substr( $stringCut, 0 );
					}
					?>
                    <li class="reactioncomments">
                        <p>
							<?php
							if ( $show_reaction ) {
								$post_reactions = Data::getMainReactionForContent( $comment->comment_ID, 'comment' );
								if ( count( $post_reactions ) ) {
									$post_main_reaction = array_shift( $post_reactions );
									$image              = FileSystem::getImageUrl( $post_main_reaction->file_name );
									?>
                                    <span class="post-reaction">
                                    <img class="reaction_<?= $post_main_reaction->ID; ?>_<?= $post_main_reaction->total; ?>"
                                         src="<?= $image; ?>"
                                         alt="<?= $post_main_reaction->label; ?>"
                                         style="height: 1em; width: auto;"/>
                                </span>
									<?php
								}
							}
							echo( $comment_text );
							?>
                        </p>
                        <span class="comment-author-link">
                            <?php echo get_comment_author_link( $comment ); ?>
                        </span>
						<?php _e( ' on ', 'da-reactions' ); ?>
                        <a href="<?php echo esc_url( get_comment_link( $comment ) ) ?>">
							<?php echo get_the_title( $comment->comment_post_ID ) ?>
                        </a>
                    </li>
					<?php
				}
			} else {
				foreach ( $r as $post ) {
					$post_title = get_the_title( $post->ID );
					$title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
					?>
                    <li class="reactions_<?= $post->total_reactions; ?>">
						<?php
						if ( $show_reaction ) {
							$post_reactions     = Data::getMainReactionForContent( $post->ID, $post->post_type );
							$post_main_reaction = array_shift( $post_reactions );
							$image              = FileSystem::getImageUrl( $post_main_reaction->file_name );
							?>
                            <span class="post-reaction">
                            <img class="reaction_<?= $post_main_reaction->ID; ?>_<?= $post_main_reaction->total; ?>"
                                 src="<?= $image; ?>"
                                 alt="<?= $post_main_reaction->label; ?>"
                                 title="<?= $post_main_reaction->label; ?>"
                                 style="height: 1em; width: auto;"/>
                        </span>
						<?php } ?>
                        <a href="<?php the_permalink( $post->ID ); ?>"><?php echo $title; ?></a>
                    </li>
					<?php
				}
			}
			?>
        </ul>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Render function for widget form on Admin page
	 *
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 *
	 * @since 1.0.0
	 */
	public function form( $instance ) {

		$title                 = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number                = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_reaction         = isset( $instance['show_reaction'] ) ? (bool) $instance['show_reaction'] : false;
		$reaction              = isset( $instance['reaction'] ) ? absint( $instance['reaction'] ) : 0;
		$post_type             = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
		$registered_post_types = get_post_types(
			array(
				'public' => true
			),
			'objects'
		);

		$reactions = Data::getAllReactions();
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'da-reactions' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
                   value="<?php echo esc_attr( $title ); ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'reaction' ); ?>"><?php _e( 'Reaction:', 'da-reactions' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'reaction' ); ?>"
                    name="<?php echo $this->get_field_name( 'reaction' ); ?>">
                <option value="0" <?= ( $reaction === 0 ? 'selected' : '' ); ?>>
					<?php _e( 'All reactions', 'da-reactions' ); ?>
                </option>
				<?php
				foreach ( $reactions as $reactionItem ) {
					$reactionId = intval( $reactionItem->ID );
					?>
                    <option value="<?= $reactionId; ?>" <?= ( $reactionId === $reaction ? 'selected' : '' ); ?>>
						<?= $reactionItem->label; ?>
                    </option>
					<?php
				}
				?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', 'da-reactions' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>"
                    name="<?php echo $this->get_field_name( 'post_type' ); ?>">
				<?php
				foreach ( $registered_post_types as $registered_post_type ) {
					?>
                    <option value="<?= $registered_post_type->name; ?>" <?= ( $registered_post_type->name === $post_type ? 'selected' : '' ); ?>>
						<?= $registered_post_type->label; ?>
                    </option>
					<?php
				}
				?>

                <option value="comments" <?= ( 'comments' === $post_type ? 'selected' : '' ); ?>>
					<?= __( 'Comments', 'da-reactions' ); ?>
                </option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'da-reactions' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>"
                   name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1"
                   value="<?php echo $number; ?>" size="3"/></p>

        <p>
            <input type="hidden" name="<?php echo $this->get_field_name( 'show_reaction' ); ?>" value="off" />
            <input class="checkbox" type="checkbox"<?php checked( $show_reaction ); ?>
                   id="<?php echo $this->get_field_id( 'show_reaction' ); ?>"
                   name="<?php echo $this->get_field_name( 'show_reaction' ); ?>"/>
            <label for="<?php echo $this->get_field_id( 'show_reaction' ); ?>"><?php _e( 'Display post reaction image?' ); ?></label>
        </p>
		<?php
	}

	/**
	 * Save widget instance data
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['number']        = (int) $new_instance['number'];
		$instance['show_reaction'] = isset( $new_instance['show_reaction'] ) ? (bool) $new_instance['show_reaction'] : false;
		$instance['reaction']      = (int) $new_instance['reaction'];
		$instance['post_type']     = sanitize_text_field( $new_instance['post_type'] );

		return $instance;
	}
}
