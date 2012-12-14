<?php
if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  MEN AT WORK 2012
 * @package    selectModule
 * @license    GNU/LGPL
 * @filesource
 */
/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['selectmodule'] = '{title_legend},name,type;{config_legend},sm_wizard;{search_legend},sm_searchable;';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard'] = array
    (
    'label'                             => &$GLOBALS['TL_LANG']['tl_module']['sm_wizard'],
    'exclude'                           => true,
    'inputType'                         => 'multiColumnWizard',
    'eval' => array(
        'columnFields' => array(
            'language' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sm_language'],
                'inputType'             => 'select',
                'options'               => $this->getLanguages(),
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
            'module' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['sm_module'],
                'exclude'               => true,
                'inputType'             => 'select',
                'options_callback'      => array('SelectModule_module', 'options_callback'),
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
        )
    )
);

$GLOBALS['TL_DCA']['tl_module']['fields']['sm_searchable'] = array
(
    'label'                             => &$GLOBALS['TL_LANG']['tl_module']['sm_searchable'],
    'exclude'                           => true,
    'inputType'                         => 'checkbox'
);

// Set chosen if we have a contao version 2.11
if(version_compare(VERSION, "2.11", ">="))
{
    $GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard']['eval']['columnFields']['language']['eval']['chosen'] = true;
	$GLOBALS['TL_DCA']['tl_module']['fields']['sm_wizard']['eval']['columnFields']['module']['eval']['chosen'] = true;
}

class SelectModule_module extends Backend
{

    public function __construct()
    {
        parent::__construct();

        $this->import("Database");
    }

    public function options_callback($objWidget)
    {

        $arrModules = array();

        if (strlen($objWidget->currentRecord) != 0)
        {
            $arrModules = $this->Database->prepare("SELECT id, name FROM tl_module WHERE pid=(SELECT pid FROM tl_module WHERE id=?) ORDER BY name asc")->execute($objWidget->currentRecord)->fetchAllAssoc();
	    $arrForms = $this->Database->prepare("SELECT id, title FROM tl_form ORDER BY title asc")->execute($objWidget->currentRecord)->fetchAllAssoc();
        }

        $arrReturn = array();

        foreach ($arrModules as $key => $value)
        {
            $arrReturn[$value["id"].'-module'] = $value["name"];
        }
	
	foreach ($arrForms as $key => $value)
        {
            $arrReturn[$value["id"].'-form'] = $value["title"];
        }

	asort($arrReturn);

        return $arrReturn;
    }

}
?>
