<?php
/**
 * Tii Configure
 *
 * @author Alacner Zhang <alacner@gmail.com>
 * @version $Id: tii.config.php 8362 2016-10-31 04:13:08Z alacner $
 */

return [
	'debug_mode' => true, //debug mode
	'timezone' => 'UTC',//Asia/Chongqing Asia/Shanghai Asia/Urumqi Asia/Hong_Kong Etc/GMT-8 Singapore Hongkong PRC
	'logger' => [
		'handler' => ['Tii_Logger_File'],//The default configuration using `tii.temp_dir'
		'priority' => Tii_Logger_Constant::ALL,
	],
	'temp_dir' => sys_get_temp_dir(), //Note: the cli and HTTP mode maybe inconsistent.
	'data_dir' => '/tii/data',//path to save permanent data
	'library' => array(
		'include' => array(
			realpath(dirname(__DIR__) . '/library/classes'),
		),
		'*' => realpath(dirname(__DIR__) . '/library'),
	),

	'auth_code_key' => Tii_Config::getIdentifier(),//for Tii_Security_Encryption

	'application' => [
		//'instance' => NULL, //instance
		'session' => [
			'start' => false, //session start?
			'handler' => NULL,//change handler?
		],
		'directory' => dirname(__DIR__) . '/application',//all in one, ${module}/[controllers|views|hooks|library]/*
		//'directory' => [//${module}/*
		//	'controllers' => '/path/to/controllers',
		//	'views' => '/path/to/views',
		//	'hooks' => '/path/to/hooks',
		//	'library' => '/path/to/library',
		//],
		//
		'module' => 'default',//default module name
		'controller' => 'index',//default controller name
		'action' => 'index',//default action name
		//
		'cookie' => [//cookie
			'path' => '/',
			'domain' => NULL,
			'secure' => false,
			'httponly' => false,
		],
		'server' => [
			'access' => [//@see
				'enable' => false,
				'rules' => [
					//'127.0.0.1/8' => true,//allow
					//'0.0.0.0/0' => false,//deny
				],
				'message' => 'Access to this resource on the server is denied!',
				'message_html' => <<<eot
<html>
<head>
<title>Service Unavailable</title>
</head>
<body bgcolor="#FFFFFF">
<table cellpadding="0" cellspacing="0" border="0" width="700" align="center" height="85%">
  <tr align="center" valign="middle">
    <td>
    <table cellpadding="10" cellspacing="0" border="0" width="80%" align="center" style="font-family: Verdana, Tahoma; color: #666666; font-size: 11px">
    <tr>
      <td valign="middle" align="center" bgcolor="#EBEBEB">
        <br /><b style="font-size: 16px">403 Forbidden</b>
        <br /><br />Access to this resource on the server is denied!
        <br /><br />
      </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
eot
			],
			'busy_error' => [//Only be used on Unix/Linux host
				'loadctrl' => 0,//5 ~ 10, 0 for no limit.
				'message' => "The server can't process your request due to a high load, please try again later.",
				'message_html' => <<<eot
<html>
<head>
<title>Service Unavailable</title>
</head>
<body bgcolor="#FFFFFF">
<table cellpadding="0" cellspacing="0" border="0" width="700" align="center" height="85%">
  <tr align="center" valign="middle">
    <td>
    <table cellpadding="10" cellspacing="0" border="0" width="80%" align="center" style="font-family: Verdana, Tahoma; color: #666666; font-size: 11px">
    <tr>
      <td valign="middle" align="center" bgcolor="#EBEBEB">
        <br /><b style="font-size: 16px">Service Unavailable</b>
        <br /><br />The server can't process your request due to a high load, please try again later.
        <br /><br />
      </td>
    </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
eot
			]
		],
		'rewrite' => [//rewrite input to other
			'http' => [//preg_replace, [pattern => replacement,...]
				//'*' => function($uri){return $uri;},//callable
				//'|^/$|' => '/path',
				//'|^/old_path/|' => '/new/path/to/',
			],
			'cli' => [],
		],
		'filters' => array(
			'*' => realpath(dirname(__DIR__) . '/hooks'),
		),
		'helper' => [
			'html' => [
				'base_url' => '',//base url for css or script
			],
			'csrf' => [
				'name' => '__csrf_token__',//default is __csrf_token__
			],
			'template' => [
				'filters' => [
					'|<!--{if (.+)}-->|U' => '<?php if (\1): ?>',
					'|<!--{else}-->|U' => '<?php ; else: ?>',
					'|<!--{elseif (.+)}-->|U' => '<?php ; elseif (\1): ?>',
					'|<!--{/if}-->|U' => '<?php endif; ?>',
					'|<!--{for (.+)}-->|U' => '<?php for (\1): ?>',
					'|<!--{/for}-->|U' => '<?php endfor; ?>',
					'|<!--{foreach (.+)}-->|U' => '<?php foreach (\1): ?>',
					'|<!--{/foreach}-->|U' => '<?php endforeach; ?>',
					'|<!--{while (.+)}-->|U' => '<?php while (\1): ?>',
					'|<!--{/while}-->|U' => '<?php endwhile; ?>',
					'|<!--{continue}-->|U' => '<?php continue; ?>',
					'|<!--{break}-->|U' => '<?php break; ?>',
					'|<!--{$(.+)=(.+)}-->|U' => '<?php $\1 = \2; ?>',
					'|<!--{$(.+)++}-->|U' => '<?php $\1++; ?>',
					'|<!--{$(.+)--}-->|U' => '<?php $\1--; ?>',
					'|<!--{$(.+)}-->|U' => '<?php echo $\1; ?>',
					'|<!--{/*}-->|U' => '<?php /*',
					'|<!--{*/}-->|U' => '*/ ?>',
					'|<!--{(.+)}-->|Us' => '<?php \1; ?>',
				],
			],
		],
	],
	//validator
	'validators' => [//Also inject rules use filter with name 'tii.validators'
		//'rule' => function($arr, $k, $arg1,...) { return true|false; },
	],
	//databases
	'database' => [
		'default' => [//default config
			'dsn' => [
				'host' => 'localhost',
				'port' => 3306,
				'dbname' => 'dbname',
			],
			'charset' => 'UTF8',//default is UTF8
			'username' => 'root',
			'passwd' => 'kernel',
		],
		//'other' => [],
	],
	//cache
	'cache' => [
		'chain' => ['memcache', 'apc', 'file'],//use Tii_Cache->setChain() to set chain
		'memcache' => [
			'server1' => ['localhost'],
		],
		'file' => [
			'directory' => sys_get_temp_dir(),//The default configuration using `tii.temp_dir'
			'gc_probality' => 1,//The GC PPM * execution probability
		],
	],
];