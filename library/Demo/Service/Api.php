<?php

class Demo_Service_Api
{
	protected $gateway;
	protected $appkey;
	protected $secretKey;

	public function __construct()
	{
		$config = Tii::get('demo.apidao', []);

		Tii::validator($config, [
			'appkey' => 'not_empty',
			'secret_key' => 'not_empty',
		]);

		$this->gateway = Tii::valueInArray($config, 'gateway', 'http://pub.apidao.com');
		$this->appkey = Tii::valueInArray($config, 'appkey');
		$this->secretKey = Tii::valueInArray($config, 'secret_key');
	}

	/**
	 * 调用接口
	 *
	 * @param $methodName
	 * @return array|mixed
	 */
	public function execute($methodName)
	{
		$args = func_get_args();
		$methodName = array_shift($args);

		$nonce = Tii_Math::random();
		$timestamp = Tii_Time::now();

		try {
			$response = Tii_Http::post($this->gateway, json_encode([
				'nonce' => $nonce,
				'appkey' => $this->appkey,
				'methodName' => $methodName,
				'timestamp' => $timestamp,
				'args' => $args,
				'signature' => Tii_Math::hashArr($this->secretKey, $timestamp, $nonce),
			]));

			$result = json_decode($response->data, true);

			if (json_last_error() !== JSON_ERROR_NONE) {
				throw new Tii_Exception(json_last_error_msg());
			}
		} catch (Exception $e) {
			$result = ['errcode' => $e->getCode(), 'errmsg' => $e->getMessage()];
		}

		return $result;
	}

	/**
	 * @param $name
	 * @param $arguments
	 * @return mixed
	 */
	public function __call($name, $arguments)
	{
		array_unshift($arguments, implode('.', explode('_', $name, 2)));
		return call_user_func_array([$this, 'execute'], $arguments);
	}
}