<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package SelectModule
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'SelectModuleHelper' => 'system/modules/selectModule/SelectModuleHelper.php',
	'SelectModule'       => 'system/modules/selectModule/SelectModule.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'sm_default' => 'system/modules/selectModule/templates',
));
