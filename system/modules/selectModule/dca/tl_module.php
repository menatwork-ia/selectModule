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
 * @copyright  MEN AT WORK 2011
 * @package    selectModule
 * @license    GNU/LGPL
 * @filesource
 */
/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['selectmodule'] = '{title_legend},name,type;{config_legend},selectmodule_wizard';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['selectmodule_wizard'] = array
    (
    'label' => &$GLOBALS['TL_LANG']['tl_module']['selectmodule_wizard'],
    'exclude' => true,
    'inputType' => 'multiColumnWizard',
    'eval' => array(
        'tl_class'                      => 'clr',
        'columnFields' => array(
            'language' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['selectmodule_language'],
                'inputType'             => 'select',
                'options'               => $this->getLanguages(),
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
            'module' => array(
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['selectmodule_module'],
                'exclude'               => true,
                'inputType'             => 'select',
                'options_callback'      => array('SelectModule_module', 'options_callback'),
                'eval'                  => array('mandatory' => true, 'style' => 'width:300px', 'includeBlankOption' => true)
            ),
        )
    )
);

class SelectModule_module extends Backend
{

    public function __construct()
    {
        parent::__construct();

        $this->import("Database");
    }

    public function options_callback($foo)
    {        
        $arrModules = array();
        
        if(strlen($foo->currentRecord) != 0)
        {
            $arrModules = $this->Database->prepare("SELECT id, name FROM tl_module WHERE pid=(SELECT pid FROM tl_module WHERE id=?) ORDER BY name asc")->execute($foo->currentRecord)->fetchAllAssoc();
        }
        
        $arrReturn = array();
        
        foreach ($arrModules as $key => $value)
        {
            $arrReturn[$value["id"]] = $value["name"];
        }
        
        return $arrReturn;
    }

}
?>
