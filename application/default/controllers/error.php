<?php

class Default_ErrorController extends Tii_Application_Controller_ErrorAbstract
{
	public function errorAction()
	{
		if (Tii_Config::isDebugMode()) {
			$this->setRender('debug_mode');
		}
	}
}