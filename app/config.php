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
		'forum_url'			=> 'x',                                        //you forum
		'social_url'		=> 'x',
		// admin account info
		'adminName'			=> 'admin',
		'adminPassword'		=> '123',
		'admin_email'		=> 'admin@admin.com',			// the email for admin account (set it before setup)
		'email' 			=> 'admin@admin.com',			// the email for others (like activation, forget password, ..etc)
		'installkey' 			=> 'install',
		'calltatar' 			=> 'tatar'
	),
	'plus'			=> array (
		'packages'	=> array (
			array ( 
				'name'		=> 'Package A',
				'gold'		=> 30,
				'cost'		=> 1.49,
				'currency'	=> 'usd', //type USD to show in dollar and EUR to make in euro
				'image'		=> 'package_a.jpg'
			),
			array ( 
				'name'		=> 'Package B',
				'gold'		=> 100,
				'cost'		=> 3.99,
				'currency'	=> 'usd', //type USD to show in dollar and EUR to make in euro
				'image'		=> 'package_b.jpg'
			),
			array ( 
				'name'		=> 'Package C',
				'gold'		=> 250,
				'cost'		=> 7.99,
				'currency'	=> 'usd', //type USD to show in dollar and EUR to make in euro
				'image'		=> 'package_c.jpg'
			),
			array ( 
				'name'		=> 'Package D',
				'gold'		=> 600,
				'cost'		=> 15.99,
				'currency'	=> 'usd', //type USD to show in dollar and EUR to make in euro
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
				'currency'		=> 'usd' //type USD to make in dollar and EUR to make in euro
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
				'currency'		=> 'usd' //type USD to make in dollar and EUR to make in euro
			),
			'paypal'	=> array (
				'testMode'		=> false,
				'name'			=> 'PayPal',
				'image'			=> 'paypal_solution_graphic-US.gif',
				'merchant_id'	=> 'Sokifilou@gmail.com',
				'currency'		=> 'EUR' //type USD to make in dollar and EUR to make in euro
			)
		)
	)
);
