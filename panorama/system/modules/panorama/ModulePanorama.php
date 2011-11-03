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

class ModulePanorama extends ContentElement
{
	protected $strTemplate = 'mod_panorama';
	
	private $strPlugin = 'plugins/panorama/swfkrpano.js';
	
	protected function compile()
	{
/*##################################			
				DB Abfrage			
##################################*/			
		if($this->panorama > 0 && TL_MODE == 'FE')											// Wenn Panorama-Element vorhanden und im Frontend
		{
			$panorama_result = $this->Database->prepare('Select id,title,image,width,height from tl_panorama where id = ?')->execute($this->panorama);
/*##################################			
				Frontend JS hinzufuegen			
##################################*/								
			if (!is_array($GLOBALS['TL_JAVASCRIPT'])) 
			{
				$GLOBALS['TL_JAVASCRIPT'] = array($this->strPlugin);
			} 
			elseif (!in_array($this->strPlugin, $GLOBALS['TL_JAVASCRIPT'])) 
			{
				$GLOBALS['TL_JAVASCRIPT'][] = $this->strPlugin;
			}		
/*##################################			
				XML DATEI ERZEUGEN			
##################################*/			
			$dateipfad = "plugins/panorama/xml/panorama_".$panorama_result->id.".xml"; 		// Dateipfad der XML-Datei
			//XML Inhalt generieren							
			$str  = "<krpano showerrors='false' version='1.0.8'>\n\n";
			$str .= "  <view fovtype='DFOV' fov='90' fovmin='60' fovmax='120' hlookat='180' vlookat='0' />\n";
			$str .= "  <control touchfriction='0.89' zoomtocursor='true' />\n\n";
			$str .= "  <image type='CUBESTRIP'>\n";
			$str .= "    <cubestrip url='../../../".$panorama_result->image."' />\n";		// Relativer Bild-Pfad zur XML-Datei
			$str .= "    <left strip='1' rotate='0' flip='' />\n";
			$str .= "    <front strip='2' rotate='0' flip='' />\n";
			$str .= "    <right strip='3' rotate='0' flip='' />\n";
			$str .= "    <back strip='4' rotate='0' flip='' />\n";
			$str .= "    <up strip='5' rotate='90' flip='' />\n";
			$str .= "    <down strip='6' rotate='-90' flip='' />\n";
			$str .= "  </image>\n\n";
			$str .=	"  <tstamp>".$this->tstamp."</tstamp>\n\n";						// Zeitstempel des tl_content-Elements in die XML-Datei einfügen
			$str .= "</krpano>";
			//XML existenz abfragen und ggf. mit Timestamp vergleichen
			if (file_exists($dateipfad))
			{
				$xml_file = simplexml_load_file($dateipfad);								// XML-Datei laden
				if($xml_file->tstamp == $this->tstamp)										// Zeitstempel von XML-Datei und tl_content-Element vergleichen
				{
					// Mache nichts, da Zeitstempel übereinstimmen und keine Änderungen vorgenommen wurden
				}
				
				else // Zeitstempel stimmen nicht überein
				{
			    	@$handler = fopen($dateipfad, "w+");										// Dateistream öffnen
			    	@fwrite($handler, $str);													// Dateistream mit XML-Inhalten füllen
			    	@fclose($handler);
		    		(file_exists($dateipfad)) ? $error = false : $error = true;	//Falls nicht geklappt
				}
			}
			else // Falls XML-Datei noch nicht existiert
			{
		    	@$handler = fopen($dateipfad, "w+");											// Dateistream öffnen
		    	@fwrite($handler, $str);														// Dateistream mit XML-Inhalten füllen
		    	@fclose($handler);															// Dateistream schließen
		    	(file_exists($dateipfad)) ? $error = false : $error = true;	//Falls nicht geklappt
		    }
/*##################################			
				Script generieren und an Frontend uebergeben			
##################################*/			
		    	$script 	= 	"<script type='text/javascript'>\n";
		    	$script	.=	"var panorama=createswf('plugins/panorama/krpano.swf', 'krpanoSWFObject', '";
		    	$script	.=	$panorama_result->width;
		    	$script	.=	"', '";
		    	$script	.=	$panorama_result->height;
		    	$script	.=	"' );\n";
		    	$script	.=	"panorama.addVariable('xml', '";
		    	$script	.=	$dateipfad;
		    	$script	.=	"');\n";
		    	$script	.=	"panorama.addParam('wmode','transparent');\n";
		    	$script	.=	"panorama.embed('panorama";
		    	$script	.=	$panorama_result->id;
		    	$script	.=	"');\n";
		    	$script	.=	"</script>";
		    	//an Globales Template uebergeben
		    	$GLOBALS['TL_MOOTOOLS'][] = $script;
/*##################################			
				variablen verarbeiten			
##################################*/			
		    	//css
		    	$cssID	= $this->cssID;
		    	$margin = $this->space;
		    	
/*##################################			
				Daten an Template uebergeben			
##################################*/			
			$this->Template->css		 		= $cssID[1];
			$this->Template->id			 		= $cssID[0];
			$this->Template->marginfirst 		= $margin[0];
			$this->Template->marginlast 		= $margin[1];
			$this->Template->panoramaId 		= $this->CssID;
			$this->Template->panoramaId 		= $panorama_result->id;
			$this->Template->panoramaTitle 		= $panorama_result->title;
			$this->Template->panoramaImage 		= $panorama_result->image;
			$this->Template->panoramaWidth 		= $panorama_result->width;
			$this->Template->panoramaHeight 	= $panorama_result->height;
			$this->Template->panoramaPath 		= dirname($panorama_result->image);
			$this->Template->dateipfad 			= $dateipfad;
			$this->Template->js					= $script;
			$this->Template->failure			= $error;		
		}	
	}
}
?>