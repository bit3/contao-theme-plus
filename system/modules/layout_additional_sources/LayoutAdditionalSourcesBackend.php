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
 * Class LayoutAdditionalSourcesBackend
 * 
 * Adding additional sources to the page layout.
 * 
 * @copyright  InfinitySoft 2011
 * @author     Tristan Lins <tristan.lins@infinitysoft.de>
 * @package    Layout Additional Sources
 */
class LayoutAdditionalSourcesBackend extends System
{
	/**
	 * Hook
	 * 
	 * @param string $strContent
	 * @param string $strTemplate
	 */
	public function hookParseBackendTemplate($strContent, $strTemplate)
	{
		if ($strTemplate == 'be_welcome')
		{
			$this->loadLanguageFile('layout_additional_sources');
			$strMessage = '';
			
			if (	!$GLOBALS['TL_CONFIG']['additional_sources_hide_cssmin_message']
				&&	$GLOBALS['TL_CONFIG']['additional_sources_css_compression'] == 'none')
			{
				if ($this->Input->post('activate_cssmin'))
				{
					$this->Config->update("\$GLOBALS['TL_CONFIG']['additional_sources_css_compression']", 'cssmin');
					$this->reload();
				}
				
				if (file_exists(TL_ROOT . '/system/libraries/CssMinimizer.php'))
				{
					$strMessage .= sprintf('<form method="post" action="contao/main.php">
	<input type="hidden" name="activate_cssmin" value="1"/>
	<p class="tl_update">
		%s<br/>
		<input type="submit" value="%s" />
	</p>
</form>',
							$GLOBALS['TL_LANG']['layout_additional_sources']['cssMinimizer'][3],
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['cssMinimizer'][4]));
				}
				else
				{
					$strMessage .= sprintf('<form method="post" action="contao/main.php?do=repository_manager&install=extension">
	<input type="hidden" name="repository_action" value="install"/>
	<input type="hidden" name="repository_stage" value="0"/>
	<input type="hidden" name="repository_extension" value="cssMinimizer"/>
	<p class="tl_update">
		%s<br/>
		<input type="submit" value="%s" /> <input type="button" value="%s" onclick="window.open(\'http://de.contaowiki.org/Layout_additional_sources#YUI_Komprimierung\');" /><br/>
	</p>
</form>',
							$GLOBALS['TL_LANG']['layout_additional_sources']['cssMinimizer'][0],
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['cssMinimizer'][1]),
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['cssMinimizer'][2]));
				}
			}
			
			if (	!$GLOBALS['TL_CONFIG']['additional_sources_hide_jsmin_message']
				&&	$GLOBALS['TL_CONFIG']['additional_sources_js_compression'] == 'none')
			{
				if ($this->Input->post('activate_dep'))
				{
					$this->Config->update("\$GLOBALS['TL_CONFIG']['additional_sources_js_compression']", 'dep');
					$this->reload();
				}
				if ($this->Input->post('activate_jsmin'))
				{
					$this->Config->update("\$GLOBALS['TL_CONFIG']['additional_sources_js_compression']", 'jsmin');
					$this->reload();
				}
				
				if (file_exists(TL_ROOT . '/system/libraries/JsMinimizer.php'))
				{
					$strMessage .= sprintf('<form method="post" action="contao/main.php">
	<input type="hidden" name="activate_jsmin" value="1"/>
	<p class="tl_update">
		%s<br/>
		<input type="submit" value="%s" />
	</p>
</form>',
							$GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][4],
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][5]));
				}
				else if (file_exists(TL_ROOT . '/system/libraries/DeanEdwardsPacker.php'))
				{
					$strMessage .= sprintf('<form method="post" action="contao/main.php">
	<input type="hidden" name="activate_dep" value="1"/>
	<p class="tl_update">
		%s<br/>
		<input type="submit" value="%s" />
	</p>
</form>',
							$GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][6],
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][7]));
				}
				else
				{
					$strMessage .= sprintf('<form method="post" action="contao/main.php?do=repository_manager&install=extension">
	<input type="hidden" name="repository_action" value="install"/>
	<input type="hidden" name="repository_stage" value="0"/>
	<input type="hidden" name="repository_extension" value="jsMinimizer"/>
	<p class="tl_update">
		%s<br/>
		<input type="submit" value="%s" /> <input type="submit" value="%s" onclick="this.form.elements.repository_extension.value = \'DeanEdwardsPacker\';" /> <input type="button" value="%s" onclick="window.open(\'http://de.contaowiki.org/Layout_additional_sources#YUI_Komprimierung\');" /><br/>
	</p>
</form>',
							$GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][0],
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][1]),
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][2]),
							specialchars($GLOBALS['TL_LANG']['layout_additional_sources']['jsMinimizer'][3]));
				}
			}
		
			if (strlen($strMessage))
			{
				$intPos = strpos($strContent, '</h2>', strpos($strContent, '<div id="tl_messages">')) + 5;
				$strLeft = substr($strContent, 0, $intPos);
				$strRight = substr($strContent, $intPos);
				$strContent = $strLeft . $strMessage . $strRight;
			}
		}
		
		return $strContent;
	}
}
?>