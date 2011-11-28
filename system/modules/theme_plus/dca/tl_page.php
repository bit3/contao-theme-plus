<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Theme+
 * Copyright (C) 2010,2011 InfinitySoft <http://www.infinitysoft.de>
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
 * @copyright  2010,2011 InfinitySoft <http://www.infinitysoft.de>
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Theme+
 * @license    LGPL
 */


$this->loadDataContainer('tl_layout');

/**
 * Palettes
 */
foreach (array('regular', 'forward', 'redirect', 'root') as $strType)
{
	$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'theme_plus_include_files';
	$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'theme_plus_include_files_noinherit';
	
	$GLOBALS['TL_DCA']['tl_page']['palettes'][$strType] = preg_replace(
		'#({layout_legend:hide}.*);#U',
		'$1,theme_plus_include_files,theme_plus_include_files_noinherit;',
		$GLOBALS['TL_DCA']['tl_page']['palettes'][$strType]);
}
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['theme_plus_include_files'] = 'theme_plus_stylesheets,theme_plus_javascripts';
$GLOBALS['TL_DCA']['tl_page']['subpalettes']['theme_plus_include_files_noinherit'] = 'theme_plus_stylesheets_noinherit,theme_plus_javascripts_noinherit';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_include_files'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_include_files'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'long')
);
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_stylesheets'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_stylesheets'],
	'inputType'               => 'fancyCheckboxWizard',
	'options_callback'        => array('tl_page_theme_plus', 'getStylesheets'),
	'mixin_value_callback'    => array('tl_page_theme_plus', 'inheritStylesheets'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'long')
);
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_javascripts'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_javascripts'],
	'inputType'               => 'fancyCheckboxWizard',
	'options_callback'        => array('tl_page_theme_plus', 'getJavaScripts'),
	'mixin_value_callback'    => array('tl_page_theme_plus', 'inheritJavaScripts'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'long')
);
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_include_files_noinherit'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_include_files_noinherit'],
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'long')
);
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_stylesheets_noinherit'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_stylesheets_noinherit'],
	'inputType'               => 'fancyCheckboxWizard',
	'options_callback'        => array('tl_page_theme_plus', 'getStylesheets'),
	'mixin_value_callback'    => array('tl_page_theme_plus', 'inheritStylesheets'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'clr')
);
$GLOBALS['TL_DCA']['tl_page']['fields']['theme_plus_javascripts_noinherit'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['theme_plus_javascripts_noinherit'],
	'inputType'               => 'fancyCheckboxWizard',
	'options_callback'        => array('tl_page_theme_plus', 'getJavaScripts'),
	'mixin_value_callback'    => array('tl_page_theme_plus', 'inheritJavaScripts'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'clr')
);


/**
 * Class tl_page_theme_plus
 *
 */
class tl_page_theme_plus extends tl_layout_theme_plus
{
	public function getStylesheets()
	{
		return $this->getFiles('css', $this->inheritStylesheets($this->Input->get('id')));
	}
	
	
	public function getJavaScripts()
	{
		return $this->getFiles('js', $this->inheritJavaScripts($this->Input->get('id')));
	}
	
	
	public function inheritStylesheets()
	{
		return $this->inheritFiles('stylesheets');
	}
	
	
	public function inheritJavaScripts()
	{
		return $this->inheritFiles('javascripts');
	}
	
	
	public function inheritFiles($strType)
	{
		$arrFiles = array();
		
		$objPage = $this->getPageDetails($this->Input->get('id'));
		
		$objLayout = $this->Database
			->prepare("SELECT * FROM tl_layout WHERE id=?")
			->execute($objPage->layout);
		if ($objLayout->next())
		{
			$key = 'theme_plus_' . $strType;
			$arrFiles = array_merge(
				$arrFiles,
				deserialize($objLayout->$key, true)
			);
		}
		
		while ($objPage->pid > 0)
		{
			$objPage = $this->Database
				->prepare("SELECT * FROM tl_page WHERE id=?")
				->execute($objPage->pid);
			if ($objPage->next() && $objPage->theme_plus_include_files)
			{
				$key = 'theme_plus_' . $strType;
				$arrFiles = array_merge(
					$arrFiles,
					deserialize($objPage->$key, true)
				);
			}
		}
		
		return $arrFiles;
	}
}
