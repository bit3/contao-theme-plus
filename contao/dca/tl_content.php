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


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['script_source'] = '{type_legend},type;{script_source_legend},script_source';


/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['script_source'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['script_source'],
    'exclude'          => true,
    'inputType'        => 'checkbox',
    'options_callback' => array('Bit3\Contao\ThemePlus\DataContainer\Content', 'getJavaScripts'),
    'eval'             => array('mandatory' => true,
                                'multiple'  => true,
                                'tl_class'  => 'clr'),
    'sql'              => 'blob NULL'
);
