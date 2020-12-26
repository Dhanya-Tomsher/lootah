<?php
/**
 * Class ButtonsSettings
 *
 * Generates setting page to create, edit, sort Reactions
 *
 * @package DaReactions\Pages
 *
 * @since 1.0.0
 */

namespace DaReactions\Pages;


use DaReactions\Data;
use DaReactions\FileSystem;
use DaReactions\Options;

/**
 * Class ButtonsSettings
 *
 * Generates setting page to create, edit, sort Reactions
 *
 * @package DaReactions\Pages
 *
 * @since 1.0.0
 */
class ButtonsSettings {

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
	 * ButtonsSettings constructor.
	 *
	 * @param string $options_group
	 */
	public function __construct( $options_group ) {
		$this->options_group = $options_group;
		$this->options_page  = $options_group . '_page';
		$this->options       = Options::getInstance( 'buttons' );
	}

	/**
	 * Renders the main form for this page
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
	 * Register settings fields for this page
	 *
	 * @since 1.0.0
	 */
	public function initSettings() {
		register_setting(
			$this->options_group,
			$this->options_group,
			array(
				'sanitize_callback' => array( $this, 'sanitizeData' )
			)
		);

		$main_section = 'button_section';

		add_settings_section(
			$main_section,
			__( 'Reactions', 'da-reactions' ),
			array( $this, 'renderButtons' ),
			$this->options_page
		);
	}

	/**
	 * Renders buttons fields
	 *
	 * @since 1.0.0
	 */
	public function renderButtons() {
		wp_enqueue_media();
		$reactions = Data::getAllReactions();
		?>
        <input type="hidden" name="da-reactions_setting_name" value="<?= $this->options->getFieldName( '' ) ?>"/>
        <table id="da-reactions-list">
            <thead>
            <tr>
                <th class="da-reactions-list-column-sort-head">
					<?= _x( 'Sort', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-icon-head">
					<?= _x( 'Icon', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-color-head">
					<?= _x( 'Color', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-label-head">
					<?= _x( 'Label', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-tools-head">
					<?= _x( 'Tools', 'Table column heading', 'da-reactions' ); ?>
                </th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th class="da-reactions-list-column-sort-foot">
					<?= _x( 'Sort', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-icon-foot">
					<?= _x( 'Icon', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-color-foot">
					<?= _x( 'Color', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-label-foot">
					<?= _x( 'Label', 'Table column heading', 'da-reactions' ); ?>
                </th>
                <th class="da-reactions-list-column-tools-foot">
					<?= _x( 'Tools', 'Table column heading', 'da-reactions' ); ?>
                </th>
            </tr>
            </tfoot>
			<?php
			if ( count( $reactions ) > 0 ) {
				?>
                <tbody class="sortable">
				<?php
				for ( $i = 0; $i < count( $reactions ); $i ++ ) {
					$reaction       = $reactions[ $i ];
					$image_file_url = FileSystem::getImageUrl( $reaction->file_name );

					$sort_field_name  = $this->options->getFieldName( '[' . $reaction->ID . '][sort_order]' );
					$image_field_name = $this->options->getFieldName( '[' . $reaction->ID . '][image]' );
					$color_field_name = $this->options->getFieldName( '[' . $reaction->ID . '][color]' );
					$label_field_name = $this->options->getFieldName( '[' . $reaction->ID . '][label]' );
					?>
                    <tr>
                        <td class="da-reactions-list-column-sort">
                            <span class="dashicons dashicons-menu handle"></span>
                            <input type="hidden" class="input_position" name="<?= $sort_field_name; ?>"
                                   value="<?= $reaction->sort_order; ?>"/>
                        </td>
                        <td class="da-reactions-list-column-icon">
                            <a href="javascript:" data-id="<?= $reaction->ID; ?>" class="change-image">
                                <img alt="<?= $reaction->label ?>" src="<?= $image_file_url; ?>?_=<?=time()?>" width="64"
                                     data-fill="<?= $reaction->color; ?>"/>
                                <input type="hidden" name="<?= $image_field_name; ?>" value=""/>
                            </a>
                        </td>
                        <td class="da-reactions-list-column-color">
                            <label for="da-reactions-color-picker-<?= $reaction->ID; ?>"
                                   class="screen-reader-text"><?= __( 'Color', 'da-reactions' ); ?></label>
                            <input id="da-reactions-color-picker-<?= $reaction->ID; ?>" type="text"
                                   name="<?= $color_field_name; ?>" data-colorpicker value="<?= $reaction->color; ?>"/>
                        </td>
                        <td class="da-reactions-list-column-label">
                            <label for="da-reactions-label-input-<?= $reaction->ID; ?>"
                                   class="screen-reader-text"><?= __( 'Label', 'da-reactions' ); ?></label>
                            <input id="da-reactions-label-input-<?= $reaction->ID; ?>" type="text"
                                   name="<?= $label_field_name; ?>" value="<?= $reaction->label; ?>"/>
                        </td>
                        <td class="da-reactions-list-column-tools">
                            <a href="#" class="delete" data-id="<?= $reaction->ID; ?>">
                                <span class="dashicons dashicons-trash"></span>
                            </a>
                        </td>
                    </tr>
					<?php
				}
				?>
                </tbody>
				<?php
			} else {
				?>
                <tr class="no-results">
                    <td colspan="5"><?php _e( 'There are no reactions', 'da-reactions' ); ?> <?= $this->getAddNewButton(); ?></td>
                </tr>
				<?php
			}
			?>
        </table>

        <p>
			<?= $this->getAddNewButton(); ?>
        </p>


        <!-- START ICON WINDOW -->
		<?php $files = FileSystem::getFiles(); ?>
        <div class="icon-select-window-background">
            <div class="icon-select-window">
				<?php
				?>
                <h2><?php _e( 'Choose SVG from those available:', 'da-reactions' ); ?></h2>
                <a href="javascript:" class="close">
                    <img alt="Unchecked" src="<?= DA_REACTIONS_URL; ?>assets/icons/svg/rating/unchecked.svg" width="64">
                </a>
                <div class="icon-list">
					<?php foreach ( $files as $dir => $file ) { ?>
						<?php if ( is_array( $file ) ) { ?>
							<?php foreach ( $file as $subfile ) { ?>
                                <div class="icon">
                                    <img alt="<?= $subfile ?> icon"
                                         src="<?= DA_REACTIONS_URL; ?>assets/icons/svg/<?= $dir; ?>/<?= $subfile; ?>"
                                         width="64"/>
                                </div>
							<?php } ?>
						<?php } else { ?>
                            <div class="icon">
                                <img alt="<?= $file ?> icon" src="<?= DA_REACTIONS_URL; ?>assets/icons/svg/<?= $file; ?>"
                                     width="64"/>
                            </div>
						<?php } ?>
					<?php } ?>
                </div>
            </div>
        </div>
        <!-- END ICON WINDOW -->
		<?php
	}

	/**
	 * Generates HTML for “Add New” button
	 *
	 * @return string
	 *
	 * @since 1.0.0
	 */
	private function getAddNewButton() {
		return '<a href="javascript:;" class="page-title-action button button-secondary add_new_reaction">' . _x( 'Add new', 'Button label', 'da-reactions' ) . '</a>';
	}

	/**
	 * Sanitizes Data and saves reactions to their own table
	 *
	 * @param null $data
	 *
	 * @return null|void
	 *
	 * @since 1.0.0
	 */
	public function sanitizeData( $data = null ) {

		if ( ! $data ) {
			return;
		}

		Data::disableAllReactions();

		foreach ( $data as $ID => $reaction ) {

			$reaction_id = Data::updateOrCreateReaction( $ID, $reaction );

			if ( ! empty( $reaction['image'] ) ) {

				libxml_use_internal_errors( true );
				$sxe = simplexml_load_string( $reaction['image'] );
				if ( $sxe ) {
					$reaction['file_name'] = FileSystem::saveSvgImage( $reaction['image'], sanitize_title( $reaction['label'] ) . '-' . $reaction_id );
				} else {
					$reaction['file_name'] = FileSystem::saveMediaImage( $reaction['image'], sanitize_title( $reaction['label'] ) . '-' . $reaction_id );
				}

				Data::updateOrCreateReaction( $reaction_id, $reaction );
			}
		}

		Data::clearDisabledReactions();

		return null;
	}

}
