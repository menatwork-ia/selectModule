<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
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
 *
 * @copyright  MEN AT WORK 2013
 * @package    selectModule
 * @license    GNU/LGPL
 * @filesource
 */
class SelectModuleRunonce
{
    public function run()
    {
        $objModules = \Contao\Database::getInstance()
            ->prepare('SELECT id, sm_wizard FROM tl_module WHERE type = \'selectmodule\'')
            ->execute();

        while ($row = $objModules->fetchAssoc()) {
            $tmp = \Contao\StringUtil::deserialize($row['sm_wizard'], true);

            foreach ($tmp as $k => $v) {
                if (\is_numeric($v['module'])) {
                    $tmp[$k]['module'] = $v['module'] . '-module';
                }
            }

            \Contao\Database::getInstance()
                ->prepare('UPDATE tl_module SET sm_wizard = ? WHERE id = ?')
                ->execute(\serialize($tmp), $row['id']);
        }
    }
}

$objSelectModuleRunonce = new SelectModuleRunonce();
$objSelectModuleRunonce->run();
