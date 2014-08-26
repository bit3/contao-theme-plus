<?php

/**
 * Theme+ - Theme extension for the Contao Open Source CMS
 *
 * Copyright (C) 2013 bit3 UG <http://bit3.de>
 *
 * @package    Theme+
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @link       http://www.themeplus.de
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Bit3\Contao\ThemePlus\DataContainer;

/**
 * Class Stylesheet
 */
class Stylesheet extends File
{

	/**
	 * @var \BackendUser
	 */
	protected $User;

	/**
	 * Check permissions to edit the table
	 */
	public function checkPermission()
	{
		if ($this->User->isAdmin) {
			return;
		}

		if (!$this->User->hasAccess('theme_plus_stylesheet', 'themes')) {
			$this->log(
				'Not enough permissions to access the style sheets module',
				'tl_theme_plus_stylesheet checkPermission',
				TL_ERROR
			);
			$this->redirect('contao/main.php?act=error');
		}
	}

	public function rememberType($varValue)
	{
		\Session::getInstance()->set('THEME_PLUS_LAST_CSS_TYPE', $varValue);

		return $varValue;
	}

	public function getAsseticFilterOptions()
	{
		return $this->buildAsseticFilterOptions('css');
	}

	public function listFile($row)
	{
		return $this->listFileFor($row, 'theme_plus_stylesheets');
	}

	public function loadLayouts($value, $dc)
	{
		return $this->loadLayoutsFor('theme_plus_stylesheets', $dc);
	}

	public function saveLayouts($value, $dc)
	{
		return $this->saveLayoutsFor('theme_plus_stylesheets', $value, $dc);
	}
}