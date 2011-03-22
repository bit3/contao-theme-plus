<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Layout Additional Sources
 * Copyright (C) 2011 Tristan Lins
 *
 * Extension for:
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
 * @copyright  InfinitySoft 2010,2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Layout Additional Sources
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_settings']['additional_sources_combination'] = array('Vereinigung', 'Wählen Sie hier ob und welche Dateien vereinigt werden sollen.');
$GLOBALS['TL_LANG']['tl_settings']['combine_all']                    = 'Alle (lokale und externe Quellen)';
$GLOBALS['TL_LANG']['tl_settings']['combine_local']                  = 'Nur lokale Dateien (keine externe Quellen)';
$GLOBALS['TL_LANG']['tl_settings']['combine_none']                   = 'Dateien nicht vereinigen';
$GLOBALS['TL_LANG']['tl_settings']['yui_cmd']                  = array('YUI-Compressor Befehle', 'Der auzuführende YUI-Compressor Befehl. Z.B. <em>yui-compressor</em> oder <em>/usr/local/bin/yui-compressor</em>.');
$GLOBALS['TL_LANG']['tl_settings']['yui_compression_disabled'] = array('YUI Komprimierung deaktivieren', 'YUI Komprimierung für CSS und JS Dateien deaktivieren.');
$GLOBALS['TL_LANG']['tl_settings']['gz_compression_disabled']  = array('GZip Komprimierung deaktivieren', 'GZip Komprimierung für CSS und JS Dateien deaktivieren.');


/**
 * Legend
 */
$GLOBALS['TL_LANG']['tl_settings']['additional_source_legend'] = 'Zusätzliche Layoutdateien Einstellungen';

?>
