<?php
/**
 * Class DashboardWidget
 * @package DaReactions\Widgets
 *
 * Generates widgets for blogs and network dashboards
 *
 * @since 1.0.0
 */

namespace DaReactions\Widgets;

use DaReactions\Data;
use DaReactions\FileSystem;
use DaReactions\Options;
use DaReactions\Utils;

/**
 * Class DashboardWidget
 * @package DaReactions\Widgets
 *
 * Generates widgets for blogs and network dashboards
 *
 * @since 1.0.0
 */
class DashboardWidget {

	/**
	 * @var string $plugin_name
	 * The name of the plugin
	 *
	 * @since 1.0.0
	 */
	private $plugin_name;

	/**
	 * DashboardWidget constructor.
	 *
	 * @param string $plugin_name
	 */
	public function __construct( $plugin_name ) {
		$this->plugin_name = $plugin_name;

	}

	/**
	 * Adds widget to blog dashboard
	 * Attached to wp_dashboard_setup hook
	 *
	 * @since 1.0.0
	 */
	public function addDashboardWidgets() {

		// Total reactions widget
		wp_add_dashboard_widget(
			'da-reactions_dashboard_widget_total_reactions',
			_x( 'Total reactions', 'Dashboard widget title', 'da-reactions' ),
			array( $this, 'renderDashboardWidgetTotalReactions' )
		);

		// Reactions by content type widget
		wp_add_dashboard_widget(
			'da-reactions_dashboard_widget_reactions_by_content_type',
			_x( 'Reactions by content type', 'Dashboard widget title', 'da-reactions' ),
			array( $this, 'renderDashboardWidgetReactionsByContentType' )
		);
	}


	/**
	 * Renders the widget “Reactions by Content Type
	 *
	 * @since 1.0.0
	 */
	public function renderDashboardWidgetReactionsByContentType() {

		$general_options = Options::getInstance( 'general' );

		$registered_post_types = get_post_types(
			array(
				'public' => true
			),
			'objects'
		);

		$chart_data = array(
			'labels'   => array(),
			'datasets' => array(
				array(
					'data'            => array(),
					'backgroundColor' => array()
				)
			)
		);

		$count_comments = false;

		foreach ( $registered_post_types as $label => $registered_post_type ) {
			if ( $general_options->getOption( "post_type_$label" ) === 'on' ) {
				$chart_data['labels'][]                         = $label;
				$chart_data['datasets'][0]['data'][]            = Data::getTotalReactionsForContentType( $registered_post_type->name );
				$chart_data['datasets'][0]['backgroundColor'][] = Utils::generateColorFromString( $label );
			}
			if ( $general_options->getOption( "post_type_${label}_comments" ) === 'on' ) {
				$count_comments = true;
			}
		}
		if ( $count_comments ) {
			$chart_data['labels'][]                         = __( 'Comments', 'da-reactions' );
			$chart_data['datasets'][0]['data'][]            = Data::getTotalReactionsForContentType( 'comment' );
			$chart_data['datasets'][0]['backgroundColor'][] = Utils::generateColorFromString( 'comment' );
		}
		?>
        <canvas
                class="graph-canvas"
                id="da_reactions_widget_reactions_by_content_type"
                width="400"
                height="400"
                data-chart_data="<?= esc_attr( json_encode( $chart_data ) ); ?>"
        >
            Your browser does not support canvas.
        </canvas>
		<?php
	}

	/**
	 * Renders the “Total Reactions Widget”
	 *
	 * @since 1.0.0
	 */
	public function renderDashboardWidgetTotalReactions() {

		$general_options = Options::getInstance( 'general' );
		$color_generator = $general_options->getOption( "chart_colors" );

		$data = Data::getAllContentReactions();

		$chart_data = array(
			'labels'   => array(),
			'datasets' => array(
				array(
					'data'            => array(),
					'backgroundColor' => array()
				)
			)
		);

		for ( $i = 0; $i < count( $data ); $i ++ ) {
			$chart_data['labels'][]              = $data[ $i ]->label;
			$chart_data['datasets'][0]['data'][] = $data[ $i ]->total;
			switch ( $color_generator ) {
				case 'random':
					$chart_data['datasets'][0]['backgroundColor'][] = Utils::generateColorFromString( $data[ $i ]->label );
					break;
				case 'default':
					$chart_data['datasets'][0]['backgroundColor'][] = Utils::getDefaultColorByIndex( $i );
					break;
				default:
					$chart_data['datasets'][0]['backgroundColor'][] = $data[ $i ]->color;
					break;
			}

		}
		?>
        <canvas
                class="graph-canvas"
                id="da_reactions_widget_total_reactions"
                width="400"
                height="400"
                data-chart_data="<?= esc_attr( json_encode( $chart_data ) ); ?>"
        >
            Your browser does not support canvas.
        </canvas>
		<?php
	}

	/**
	 * Renders widget for network dashboard
	 *
	 * @since 1.0.0
	 */
	public function renderNetworkDashboardWidget() {
		$blogs = get_sites();
		?>
        <table class="widefat">
            <thead>
            <tr>
                <th><?php _e( 'Blog', 'da-reactions' ); ?></th>
                <th><?php _e( 'Reactions', 'da-reactions' ); ?></th>
                <th><?php _e( 'Statistics', 'da-reactions' ); ?></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th><?php _e( 'Blog', 'da-reactions' ); ?></th>
                <th><?php _e( 'Reactions', 'da-reactions' ); ?></th>
                <th><?php _e( 'Statistics', 'da-reactions' ); ?></th>
            </tr>
            </tfoot>
            <tbody>
			<?php
			foreach ( $blogs as $blog ) {
				switch_to_blog( $blog->blog_id );

				$general_options = Options::getInstance( 'general' );
				$color_generator = $general_options->getOption( "chart_colors" );

				$reactions  = Data::getAllReactions();
				$statistics = Data::getAllContentReactions();
				$chart_data = array();

				$total = 0;
				for ( $i = 0; $i < count( $statistics ); $i ++ ) {

					switch ( $color_generator ) {
						case 'random':
							$chart_data_color = Utils::generateColorFromString( $statistics[ $i ]->label );
							break;
						case 'default':
							$chart_data_color = Utils::getDefaultColorByIndex( $i );
							break;
						default:
							$chart_data_color = $statistics[ $i ]->color;
							break;
					}


					$chart_data[] = array(
						'label' => $statistics[ $i ]->label,
						'total' => $statistics[ $i ]->total,
						'color' => $chart_data_color
					);
					$total        += $statistics[ $i ]->total;
				}
				?>
                <tr>
                    <td><?php echo get_bloginfo( 'name' ); ?></td>
                    <td><?php
						foreach ( $reactions as $reaction ) {
							$image_file_path = FileSystem::getImageUrl( $reaction->file_name );
							?>
                            <img src="<?= $image_file_path; ?>" width="14" alt="<?= $reaction->label; ?>"
                                 title="<?= $reaction->label; ?>"/>
							<?php
						}
						?></td>
                    <td>
                        <div class="chart network_blog_reactions_percent_chart">
							<?php
							if ( $total > 0 ) {
								foreach ( $chart_data as $data ) {
									?>
                                <div style="background-color: <?= $data['color']; ?>; width: <?= $data['total'] / $total * 100; ?>%;"
                                     title="<?= $data['label']; ?>" class="percent_div_with_tooltip"></div><?php
								}
							} else {
								_e( 'No data to display.', 'da-reactions' );
							}
							?>
                        </div>
                    </td>
                </tr>
				<?php
				restore_current_blog();
			}
			?>
            </tbody>
        </table>
		<?php
	}
}
