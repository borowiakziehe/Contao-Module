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

$GLOBALS['TL_DCA']['tl_panorama'] = array
(

  'config' => array
  (
    'dataContainer'		=>	'Table',
    'table'				=>	array('tl_panorama'),
    'switchToEdit'		=>	true
  ),

  'list' => array
  (
    'sorting'	=>	array
    (
    	'mode'			=>	1, 					/* EintrŠge werden nach definiertem Feld sortiert, in diesem Fall "title" */
    	'fields'		=>	array('title'),
    	'flag'			=>	1,					/* Wie soll sortiert werden. 1 = nach Anfangsbuchstaben sortieren, aufsteigend */
    	'panelLayout'	=>	'search,limit'		/* Suche und Filter integrieren */
    ),
    'label'		=> array
    (
    	'fields'		=>	array('title'),		/* "title" aus der Datenbank lesen und ausgeben */
    	'format'		=> '%s'
    ),
    'global_operations'	=> array				/* Die Funktion "Mehrere bearbeiten" einfŸgen */
    (
    	'all'	=> array
    	(
    		'label'			=> &$GLOBALS['TL_LANG']['MSC']['all'],
    		'href'			=>	'act=select',
    		'class'			=>	'header_edit_all',
    		'attributes'	=>	'onclick="Backend.getScrollOffset();"'
    	)
    ),
    'operations'	=> array
    (
    	'edit' => array
    	(
    		'label'				=>	&$GLOBALS['TL_LANG']['tl_panorama']['edit'],
    		'href'				=>	'act=edit',
    		'icon'				=>	'edit.gif',
    	),
    	'copy' => array
      	(
      	  	'label'             =>	&$GLOBALS['TL_LANG']['tl_panorama']['copy'],
      	  	'href'              => 	'act=copy',
      	  	'icon'              => 	'copy.gif',
      	),	
      	'delete' => array
      	(
      	  'label'               => 	&$GLOBALS['TL_LANG']['tl_panorama']['delete'],
      	  'href'                => 	'act=delete',
      	  'icon'                => 	'delete.gif',
      	  'attributes'          => 	'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
      	),
      	'show' => array
      	(
      	  'label'               => 	&$GLOBALS['TL_LANG']['tl_panorama']['show'],
      	  'href'                => 	'act=show',
      	  'icon'                => 	'show.gif'
      	)
    )
  ),

  'palettes' => array
  (
    'default'			=>	'{title_legend},title,description,image,width,height'
  ),

  'fields' => array
  (
    'title'			=>	array
    (
    	'label'				=>	&$GLOBALS['TL_LANG']['tl_panorama']['title'],
    	'inputType'			=>	'text',
    	'search'			=>	true,
    	'eval'				=> 	array('mandatory'=>true, 'maxLength'=>64)
    ),
  //  'description'	=>	array
  //  (
  //  	'label'				=> 	&$GLOBALS['TL_LANG']['tl_panorama']['description'],
  //  	'inputType'			=>	'textarea',
  //  	'eval'				=>	array('rte' => 'tinyFlash')
  //  ),
    'image'			=>	array
    (
    	'label'				=>	&$GLOBALS['TL_LANG']['tl_panorama']['image'],
    	'inputType'			=>	'fileTree',
    	'eval'				=>	array('files'=>true, 'filesOnly'=>true, 'fieldType'=>'radio', 'mandatory'=>true, 'extensions'=> 'ppan')
    ),
    'width'			=>	array
    (
    	'label'				=>	&$GLOBALS['TL_LANG']['tl_panorama']['width'],
    	'inputType'			=>	'text',
    	'eval'				=>	array('mandatory'=>true, 'maxLength'=>64, 'tl_class'=>'w50', 'rgxp'=>'digit')
    ),
    'height'			=>	array
    (
    	'label'				=>	&$GLOBALS['TL_LANG']['tl_panorama']['height'],
    	'inputType'			=>	'text',
    	'eval'				=>	array('mandatory'=>true, 'maxLength'=>64, 'tl_class'=>'w50', 'rgxp'=>'digit')
    ),
  )
);

?>