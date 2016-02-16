
$jmwsIdMyGadget->phoneBurgerIconThisDeviceLeft = FALSE;
$jmwsIdMyGadget->phoneBurgerIconThisDeviceRight = FALSE;

if ( $jmwsIdMyGadget->isPhone() )
{
	$jmwsIdMyGadget->usingJQueryMobile = TRUE;
	if ( $this->params->get('phoneNavOnPhone') )
	{
		if ( $this->countModules('phone-header-nav') )
		{
			$jmwsIdMyGadget->phoneHeaderNavThisDevice = TRUE;
		}
		if ( $this->countModules('phone-footer-nav') )
		{
			$jmwsIdMyGadget->phoneFooterNavThisDevice = TRUE;
		}
	}
	if ( $this->countModules('phone-burger-menu-left') &&
	     $this->params->get('phoneBurgerMenuLeftOnPhone') )
	{
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceLeft = TRUE;
	}
	if ( $this->countModules('phone-burger-menu-right') &&
	     $this->params->get('phoneBurgerMenuRightOnPhone') )
	{
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceRight = TRUE;
	}
}
else if ( $jmwsIdMyGadget->isTablet() )
{
	if ( $this->params->get('phoneNavOnTablet') )
	{
		if ( $this->countModules('phone-header-nav') )
		{
			$jmwsIdMyGadget->usingJQueryMobile = TRUE;
			$jmwsIdMyGadget->phoneHeaderNavThisDevice = TRUE;
		}
		if ( $this->countModules('phone-footer-nav') )
		{
			$jmwsIdMyGadget->usingJQueryMobile = TRUE;
			$jmwsIdMyGadget->phoneFooterNavThisDevice = TRUE;
		}
	}
	if ( $this->countModules('phone-burger-menu-left') &&
	     $this->params->get('phoneBurgerMenuLeftOnTablet') )
	{
		$jmwsIdMyGadget->usingJQueryMobile = TRUE;
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceLeft = TRUE;
	}
	if ( $this->countModules('phone-burger-menu-right') &&
	     $this->params->get('phoneBurgerMenuRightOnTablet') )
	{
		$jmwsIdMyGadget->usingJQueryMobile = TRUE;
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceRight = TRUE;
	}
}
else
{
	if ( $this->params->get('phoneNavOnDesktop') )
	{
		if ( $this->countModules('phone-header-nav') )
		{
			$jmwsIdMyGadget->usingJQueryMobile = TRUE;
			$jmwsIdMyGadget->phoneHeaderNavThisDevice = TRUE;
		}
		if ( $this->countModules('phone-footer-nav') )
		{
			$jmwsIdMyGadget->usingJQueryMobile = TRUE;
			$jmwsIdMyGadget->phoneFooterNavThisDevice = TRUE;
		}
	}
	if ( $this->countModules('phone-burger-menu-left') &&
	     $this->params->get('phoneBurgerMenuLeftOnDesktop') )
	{
		$jmwsIdMyGadget->usingJQueryMobile = TRUE;
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceLeft = TRUE;
	}
	if ( $this->countModules('phone-burger-menu-right') &&
	     $this->params->get('phoneBurgerMenuRightOnDesktop') )
	{
		$jmwsIdMyGadget->usingJQueryMobile = TRUE;
		$jmwsIdMyGadget->phoneBurgerIconThisDeviceRight = TRUE;
	}
}

