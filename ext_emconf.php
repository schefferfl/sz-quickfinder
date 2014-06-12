<?php

########################################################################
# Extension Manager/Repository config file for ext: "sz_indexed_search"
#
# Auto generated by Extension Builder 2014-03-20
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Indexed Search Extend',
	'description' => 'Adds autocomplete to indexed search',
	'category' => 'plugin',
	'author' => 'Dennis Römmich',
	'author_email' => 'dennis.roemmich@sunzinet.com',
	'author_company' => 'sunzinet AG',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '2.0.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5',
			'indexed_search'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>