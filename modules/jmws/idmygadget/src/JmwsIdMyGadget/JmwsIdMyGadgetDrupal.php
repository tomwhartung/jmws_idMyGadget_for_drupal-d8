<?php
/**
 * Creates an object of the desired idMyGadget subclass and uses it for device detection.
 * NOTE:
 * *IF* we can keep all the Drupal-specific code here,
 * *THEN* we can reuse the rest of the code in this project for joomla and wordpress (and...?)
 */
require_once 'JmwsIdMyGadget.php';
require_once 'HamburgerMenuIconHtmlJs.php';

class JmwsIdMyGadgetDrupal extends JmwsIdMyGadget
{
	/**
	 * Translated version of the radio button choices defined (as static) in the parent class
	 */
	public $translatedRadioChoices = array();

	/**
	 * Constructor: for best results, install and use a gadgetDetector other than the default
	 */
	public function __construct( $gadgetDetectorString=null, $debugging=FALSE, $allowOverridesInUrl=TRUE )
	{
	//	error_log( 'Creating a JmwsIdMyGadgetDrupal object for detector "' . $gadgetDetectorString . '" - note we want to do this only once!' );
		$this->idMyGadgetDir = IDMYGADGET_MODULE_DIR;
		parent::__construct( $gadgetDetectorString, $debugging, $allowOverridesInUrl );
		$this->translateStaticArrays();
	}

	/**
	 * For development only! Consider removing when code is stable.
	 * Displaying some values that can help us make sure we haven't inadvertently
	 * broken something while we are actively working on this.
	 * If something breaks, the sooner we know it the better!
	 * @return string
	 */
	public function getSanityCheckString( $extra='' )
	{
		$returnValue = '';
		$returnValue .= parent::getSanityCheckString( $extra );

		return $returnValue;
	}

	/**
	 * Based on the current device, access the device-dependent options set in the admin console
	 * and use them to generate most of the markup for the heading
	 * @return string Markup for site heading (logo, name, title, and description, each of which is optional)
	 */
	public function getLogoNameTitleDescriptionHtml( $front_page='' )
	{
		global $base_url;
		$siteName = Drupal::config('system.site')->get('name');
		$config = \Drupal::config('idmygadget.settings');

		if ( $front_page === '' )
		{
			$front_page = $base_url;
		}

		$logoNameTitleDescription = '';  // the return value of this method
		$logoFile = '';
		$logoImgSrc = $base_url . '/sites/default/files/';
		$siteTitle = '';
		$siteSlogan = '';
		$nameTitleSloganOpen = '<div id="name-and-slogan" class="name-and-slogan">';
		$nameTitleSloganClose = '</div><!-- #name-and-slogan .name-and-slogan -->';
		$logoAnchorTagOpen = '<a href="' . $front_page . '" title="' . t('Home') . '" rel="home" id="logo">';
		$logoAnchorTagClose = '</a>';
		$textAnchorTagOpen = '<a href="' . $front_page . '" title="' . t('Home') . '" rel="home">';
		$textAnchorTagClose = '</a>';

		if ( $this->isPhone() )
		{
			$logoFile = $config->get( 'idmygadget_logo_file_phone' );
			$siteTitle = $config->get( 'idmygadget_site_title_phone' );
			$siteSlogan = $config->get('idmygadget_site_slogan_phone');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-phone" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-phone">';
			if ( $config->get('idmygadget_show_site_name_phone') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[$config->get('idmygadget_site_name_element_phone')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-phone">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[$config->get('idmygadget_site_title_element_phone')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-phone">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-phone -->';
			if ( strlen($siteSlogan) > 0 )
			{
				$siteSloganElement = parent::$validElements[$config->get('idmygadget_site_slogan_element_phone')];
				$logoNameTitleDescription .= '<' . $siteSloganElement . ' id="site-slogan" class="site-description-phone">';
				$logoNameTitleDescription .= $siteSlogan;
				$logoNameTitleDescription .= '</' . $siteSloganElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}
		else if ( $this->isTablet() )
		{
			$logoFile = $config->get( 'idmygadget_logo_file_tablet' );
			$siteTitle = $config->get('idmygadget_site_title_tablet');
			$siteSlogan = $config->get('idmygadget_site_slogan_tablet');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-tablet" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-tablet">';
			if ( $config->get('idmygadget_show_site_name_tablet') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[$config->get('idmygadget_site_name_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-tablet">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[$config->get('idmygadget_site_title_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-tablet">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-tablet -->';
			if ( strlen($siteSlogan) > 0 )
			{
				$siteSloganElement = parent::$validElements[$config->get('idmygadget_site_slogan_element_tablet')];
				$logoNameTitleDescription .= '<' . $siteSloganElement . ' id="site-slogan" class="site-description-tablet">';
				$logoNameTitleDescription .= $siteSlogan;
				$logoNameTitleDescription .= '</' . $siteSloganElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}
		else
		{
			$logoFile = $config->get( 'idmygadget_logo_file_desktop' );
			$siteTitle = $config->get('idmygadget_site_title_desktop');
			$siteSlogan = $config->get('idmygadget_site_slogan_desktop');
			$logoNameTitleDescription .= $nameTitleSloganOpen;  // NOTE: includes logo; see README.md
			if ( strlen($logoFile) > 0 )
			{
				$logoImgSrc .= $logoFile;
				$logoNameTitleDescription .= $logoAnchorTagOpen;
				$logoNameTitleDescription .= '<img src="' . $logoImgSrc . '" class="logo-file-desktop" alt="' . $siteName . '" />';
				$logoNameTitleDescription .= $logoAnchorTagClose;
			}
			$logoNameTitleDescription .= '<div class="site-name-title-desktop">';
			if ( $config->get('idmygadget_show_site_name_desktop') )   // NOTE: 'No' must be the zeroeth elt
			{
				$siteNameElement = parent::$validElements[$config->get('idmygadget_site_name_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteNameElement . ' id="site-name" class="site-name-desktop">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteName;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteNameElement . '>';
			}
			if ( strlen($siteTitle) > 0 )
			{
				$siteTitleElement = parent::$validElements[$config->get('idmygadget_site_title_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteTitleElement . ' class="site-title-desktop">';
				$logoNameTitleDescription .= $textAnchorTagOpen;
				$logoNameTitleDescription .= $siteTitle;
				$logoNameTitleDescription .= $textAnchorTagClose;
				$logoNameTitleDescription .= '</' . $siteTitleElement . '>';
			}
			$logoNameTitleDescription .= '</div><!-- .site-name-title-desktop -->';
			if ( strlen($siteSlogan) > 0 )
			{
				$siteSloganElement = parent::$validElements[$config->get('idmygadget_site_slogan_element_desktop')];
				$logoNameTitleDescription .= '<' . $siteSloganElement . ' id="site-slogan" class="site-description-desktop">';
				$logoNameTitleDescription .= $siteSlogan;
				$logoNameTitleDescription .= '</' . $siteSloganElement . '>';
			}
			$logoNameTitleDescription .= $nameTitleSloganClose;
		}

		return $logoNameTitleDescription;
	}

  /**
	 * Translate the static radioChoices array to get the non-static array translatedRadioChoices
	 */
	protected function translateStaticArrays()
	{
		foreach( parent::$radioChoices as $aChoice )
		{
			array_push( $this->translatedRadioChoices, t($aChoice) );
		}
	}
	/**
	 * Return a boolean indicating whether we want the jQuery Mobile Phone Nav on this device
	 */
	protected function getPhoneNavOnThisDevice()
	{
		$phoneNavOnThisDevice = FALSE;
		$config = \Drupal::config('idmygadget.settings');

		if ( $this->isPhone() )
		{
			$phoneNavOnThisDevice = $config->get('idmygadget_phone_nav_on_phones');
		}
		else if ( $this->isTablet() )
		{
			$phoneNavOnThisDevice = $config->get('idmygadget_phone_nav_on_tablets');
		}
		else
		{
			$phoneNavOnThisDevice = $config->get('idmygadget_phone_nav_on_desktops');
		}

		return $phoneNavOnThisDevice;
	}
	/**
	 * Return a boolean indicating whether we want the hamburger menu icon
	 *   (left or right or both) on this device
	 */
	protected function getHamburgerIconOnThisDevice($leftOrRight=HamburgerMenuIcon::LEFT)
	{
		$hamburgerIconOnThisDevice = FALSE;
		$config = \Drupal::config('idmygadget.settings');

		if ( $this->isPhone() )
		{
			$hamburgerIconOnThisDevice = $config->get('idmygadget_hamburger_nav_' . $leftOrRight . '_on_phones');
		}
		else if ( $this->isTablet() )
		{
			$hamburgerIconOnThisDevice = $config->get('idmygadget_hamburger_nav_' . $leftOrRight . '_on_tablets');
		}
		else
		{
			$hamburgerIconOnThisDevice = $config->get('idmygadget_hamburger_nav_' . $leftOrRight . '_on_desktops');
		}

		return $hamburgerIconOnThisDevice;
	}
	/**
	 * Return the index of the jQuery Mobile Data Theme Letter
	 */
	protected function getJqmDataThemeIndex()
	{
		$config = \Drupal::config('idmygadget.settings');
		$jqmDataThemeIndex = $config->get('idmygadget_jqm_data_theme');
		return $jqmDataThemeIndex;
	}
}
