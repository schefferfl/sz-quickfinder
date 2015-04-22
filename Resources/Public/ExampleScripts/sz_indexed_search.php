<?php

/**
 * Description of the phpfile 'sz_indexed_search.php'
 *
 * @author Björn Christopher Bresser <bjoern.bresser@sunzinet.com>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class sz_indexed_search_user_func {


	protected $settings = array();


	/**
	 * Construct
	 */
	public function __construct() {
		$this->initialize();
	}

	/**
	 * @param bool $settings
	 * @param array $params Prameter given by the TypoScript
	 * @return array
	 */
	public function main($settings = FALSE, $params = array()) {
		$result = array();

		return $result;
	}

	/**
	 * Initializes database and realurl configuration
	 * @return void
	 */
	protected function initialize() {

	}
}
