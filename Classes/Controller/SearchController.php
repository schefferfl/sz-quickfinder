<?php
namespace Sunzinet\SzIndexedSearch\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Dennis Römmich <dennis.roemmich@sunzinet.com>, sunzinet AG
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Sunzinet\SzIndexedSearch\Domain\Model\CustomSearch;
use Sunzinet\SzIndexedSearch\Domain\Repository\SearchRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class SearchController
 *
 * @package sz_indexed_search
 * @license http://www.gnu.org/licenses/gpl.html
 * GNU General Public License, version 3 or later
 */
class SearchController extends ActionController {

	/**
	 * searchRepository
	 *
	 * @var \Sunzinet\SzIndexedSearch\Domain\Repository\SearchRepository
	 */
	protected $searchRepository;

	/**
	 * @var CustomSearch $csObj
	 */
	protected $csObj;

	/**
	 * injectSearchRepository
	 *
	 * @param SearchRepository $searchRepository
	 * @return void
	 */
	public function injectSearchRepository(SearchRepository $searchRepository) {
		$this->searchRepository = $searchRepository;
	}

	/**
	 * Only show the SearchForm
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('searchPid', $this->settings['searchPid']);
	}

	/**
	 * autocomplete action
	 *
	 * @param string $searchString
	 * @return void
	 */
	public function autocompleteAction($searchString) {
		$customSearchArray = $this->settings['customSearch'];

		$results = array();

		foreach ($customSearchArray as $sectionName => $customSearch) {
			$this->buildModelFromTyposcript($customSearch, $searchString);

			if (!$this->csObj->getScript()) {
				$results[$sectionName] = $this->searchRepository->customSearch($this->csObj, $this->settings);
			} else {
				require_once($this->csObj->getScript());
				$userFunc = $this->objectManager->get('sz_indexed_search_user_func');
				$results[$sectionName] = $userFunc->main($this->settings, $customSearch['params']);
			}
		}

		$this->view->assign('searchString', $searchString);
		$this->view->assign('results', $results);
	}

	/**
	 * Goes foward to IndexedSearch
	 *
	 * @param string $string The string
	 * @return void
	 */
	public function searchAction($string) {
		$params = array('search' => array('searchWords' => $string, 'searchParams' => $string, 'sword' => $string));
		$this->forward('search', 'Search', 'IndexedSearch', $params);
	}

	/**
	 * Fill the Model from TypoScript values
	 *
	 * @param array $typoscript TypoScript settings
	 * @param string $searchString The string
	 * @return void
	 */
	protected function buildModelFromTyposcript($typoscript, $searchString) {
		/** @var $csObj CustomSearch */
		$csObj = $this->objectManager->get(CustomSearch::class);
		if ($typoscript['script']) {
			$csObj->setScript($typoscript['script']);
		}
		$csObj->setTable($typoscript['model'])
			->setSearchFields(explode(',', str_replace(' ', '', $typoscript['searchFields'])))
			->setSearchString($searchString)
			->setMaxResults($typoscript['max_results']);

		$this->csObj = $csObj;
	}

}
