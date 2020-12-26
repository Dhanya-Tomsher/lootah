<?php
/**
 * Class I18n
 * @package DaReactions
 *
 * Manage Internazionalization tasks
 *
 * @since 1.0.0
 */

namespace DaReactions;

/**
 * Class I18n
 * @package DaReactions
 *
 * Manage Internazionalization tasks
 *
 * @since 1.0.0
 */
class I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function loadPluginTextdomain() {


		load_plugin_textdomain(
			'da-reactions',
			false,
			DA_REACTIONS_DIRECTORY_NAME . '/languages/'
		);

	}


}
