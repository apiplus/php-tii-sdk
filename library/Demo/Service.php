<?php
/**
 * Servcie class
 *
 * Class Demo_Service
 */
final class Demo_Service extends Tii_Service
{
	/**
	 * @return Tii_Cache_Abstract
	 */
	public static function getCache()
	{
		return Tii::object('Tii_Cache');
	}
} 