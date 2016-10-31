<?php
/**
 * web entry
 *
 * @author Alacner Zhang <alacner@gmail.com>
 * @version $Id: index.php 8362 2016-10-31 04:13:08Z alacner $
 */

$_directories = [
	dirname(__FILE__) . '/../configs/local/configuration.php',// local first
	dirname(__FILE__) . '/../configs/configuration.php',
];

foreach ($_directories as $_file) {
	if (is_file($_file)) {
		require_once $_file;
		break;
	}
}
unset($_directories, $_file);

if (!class_exists('Tii_Version')) {//check framework has already loaded
	trigger_error("The tii framework not loaded correctly", E_USER_ERROR);
}

//session start
if (Tii::get('tii.application.session.start', false)) {
	Tii_Application_Session::start(Tii::get('tii.application.session.handler', NULL));
}

Tii_Application::run();