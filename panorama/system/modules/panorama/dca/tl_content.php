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
 * @copyright  Stefan Melz © 2011 
 * @author     Stefan Melz, Stefan Beutler 
 * @package    panorama 
 * @license    GNU 
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_content']['palettes']['panorama'] = '{type_legend},type,{Panorama},panorama,{expert_legend:hide},guests,cssID,space';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['panorama'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_content']['panorama_id'],
	'inputType'		=> 'select',
	'foreignKey'	=> 'tl_panorama.title',
	'eval'			=> array('multiple'=>false)
);
?>
