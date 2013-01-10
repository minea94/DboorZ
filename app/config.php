<?php
$AppConfig = array (
	'db' 					=> array (
		'host'				=> 'monhost',
		'user'				=> 'user',
		'password'			=> 'pmotdepasse',
		'database'			=> 'basededonnees',
	),
	'page' 		=> array (
		'ar_title'			=> 'mon travian',
		'en_title'			=> 'mon travian',
		'meta-tag' 			=> '',
		'asset_version'		=> 'c4b7aaaadef'						// this is used to flush any old assets like css file or javascript
	),
	'system' 	=> array (
		'lang'				=> 'en',										// this is the default language, ar = for arabic, en = for english
		'forum_url'			=> 'x',                                        // ton fofo
		'social_url'		=> 'x',
		// admin account info
		'adminName'			=> 'admin',
		'adminPassword'		=> '123',
		'admin_email'		=> 'admin@admin.com',			// the email for admin account (set it before setup)
		'email' 			=> 'admin@admin.com',			// the email for others (like activation, forget password, ..etc)
		'installkey' 			=> 'installer',
		'calltatar' 			=> 'tatar'
	),
	'plus'			=> array (
		'packages'	=> array (
			array ( 
				'name'		=> 'Package A',
				'gold'		=> 30,
				'cost'		=> 1.49,
				'currency'	=> 'usd',
				'image'		=> 'package_a.jpg'
			),
			array ( 
				'name'		=> 'Package B',
				'gold'		=> 100,
				'cost'		=> 3.99,
				'currency'	=> 'usd',
				'image'		=> 'package_b.jpg'
			),
			array ( 
				'name'		=> 'Package C',
				'gold'		=> 250,
				'cost'		=> 7.99,
				'currency'	=> 'usd',
				'image'		=> 'package_c.jpg'
			),
			array ( 
				'name'		=> 'Package D',
				'gold'		=> 600,
				'cost'		=> 15.99,
				'currency'	=> 'usd',
				'image'		=> 'package_d.jpg'
			),
		),
		'payments' => array (
			'cashu'	=> array (
				'testMode'		=> FALSE,
				'name'			=> 'CashU',
				'image'			=> 'cashu.gif',
				'serviceName' 	=> '',
				'merchant_id'	=> '',
				'key'			=> '',
				'testKey'		=> '',
				'returnKey'		=> '',
				'currency'		=> 'usd'
			),
			'onecard'	=> array (
				'testMode'		=> FALSE,
				'name'			=> 'OneCard',
				'image'			=> 'onecard_logo.gif',
				'serviceName' 	=> '',
				'merchant_id'	=> '',
				'key'			=> '',
				'testKey'		=> '',
				'returnKey'		=> '',
				'currency'		=> 'usd'
			),
			'paypal'	=> array (
				'testMode'		=> false,
				'name'			=> 'PayPal',
				'image'			=> 'paypal_solution_graphic-US.gif',
				'merchant_id'	=> 'suport@extreemgaming.com',//rebhee62@gmail.com
				'currency'		=> 'USD'
			)
		)
	)
);