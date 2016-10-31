<?php
/**
 * 更多请登录 http://www.wanpucs.com/user.html 查看API文档
 */

class Default_IndexController extends Tii_Application_Controller_Abstract
{
	public function indexAction()
	{
		var_dump(Demo_Service::api()->execute('runtime'));
		var_dump(Demo_Service::api()->runtime());
	}
}