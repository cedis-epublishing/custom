<?php

import('lib.pkp.classes.plugins.ThemePlugin');

class CustomThemePlugin extends ThemePlugin {
	
	/**
	 * @copydoc ThemePlugin::isActive()
	 */
	public function isActive() {
		if (defined('SESSION_DISABLE_INIT')) return true;
		return parent::isActive();
	}
	

	public function init() {
		
		$this->setParent('defaultthemeplugin');
		
		$this->removeOption('typography');
		$this->removeOption('useHomepageImageAsHeader');

		// size logo small screens
		$this->addOption('sizeLogoSmallScreen', 'text', array(
			'label' => 'plugins.themes.custom.option.sizeLogoSmall',
			'description' => 'plugins.themes.custom.option.sizeLogoSmallDescription'
		));

		// size logo large screens
		$this->addOption('sizeLogoLargeScreen', 'text', array(
			'label' => 'plugins.themes.custom.option.sizeLogoLarge',
			'description' => 'plugins.themes.custom.option.sizeLogoLargeDescription'
		));

		$this->addOption('colourFooter', 'colour', array(
			'label' => 'plugins.themes.custom.option.colourFooterLabel',
			'description' => 'plugins.themes.custom.option.colourFooterDescription',
			'default' => '#bfbfbf',
		));
		
		$this->addOption('colourText', 'colour', array(
			'label' => 'plugins.themes.custom.option.colourTextLabel',
			'description' => 'plugins.themes.custom.option.colourTextDescription',
			'default' => '#2c2c2c',
		));
		
		
/////////////////////////////


		$sizeLogoSmallScreen = 0;
		if (is_numeric($this->getOption('sizeLogoSmallScreen'))) {
			$sizeLogoSmallScreen = intval($this->getOption('sizeLogoSmallScreen'));
		}
		$sizeLogoSmallScreenMargin = $sizeLogoSmallScreen + 20;	

		$sizeLogoLargeScreen = 0;
		if (is_numeric($this->getOption('sizeLogoLargeScreen'))) {
			$sizeLogoLargeScreen = intval($this->getOption('sizeLogoLargeScreen'));
		}
		$sizeLogoLargeScreenMargin = $sizeLogoLargeScreen + 20;

						
		$colourFooter = $this->getOption('colourFooter');
		$colourText = $this->getOption('colourText');

		
////////////////////////////////////////////////////////////////////////////////////		

		$additionalLessVariables = array();
		
		$additionalLessVariables[] = '@custom-size-logo-ls: '.$sizeLogoLargeScreen.'px;';
		$additionalLessVariables[] = '@custom-size-logo-ss: '.$sizeLogoSmallScreen.'px;';		
		$additionalLessVariables[] = '@custom-size-logo-ls-margin: '.$sizeLogoLargeScreenMargin.'px;';
		$additionalLessVariables[] = '@custom-size-logo-ss-margin: '.$sizeLogoSmallScreenMargin.'px;';
		$additionalLessVariables[] = '@text: ' .$colourText.';';		
		$additionalLessVariables[] = '@custom-colour-footer: ' . $colourFooter . ';';
		
		if (!$this->isColourDark($colourFooter)) {
			$additionalLessVariables[] = '@custom-colour-text-footer: '.$colourText.';';
		} else {
			$additionalLessVariables[] = '@custom-colour-text-footer: #fff;';			
		}		
		
		$this->modifyStyle('stylesheet', array('addLess' => array('styles/custom.less')));
		if (!empty($additionalLessVariables)) {
			$this->modifyStyle('stylesheet', array('addLessVariables' => join($additionalLessVariables)));
		}
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.themes.custom.name');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.themes.custom.description');
	}

}

?>