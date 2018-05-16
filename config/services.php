<?php

return [
	'services' => [
		'mailgun' => [
			'domain' => getenv('MAILGUN_DOMAIN'),
	        'secret' => getenv('MAILGUN_SECRET'),
		],
		'facebook' => [
			'client_id' 	=> getenv('FB_CLIENT_ID'),
			'client_secret' => getenv('FB_CLIENT_SECRET'),
			'redirect_uri' 	=> getenv('FB_REDIRECT_URL'),
		],
		'google' => [
			'client_id' 	=> getenv('GOOGLE_CLIENT_ID'),
			'client_secret' => getenv('GOOGLE_CLIENT_SECRET'),
			'redirect_uri' 	=> getenv('GOOGLE_REDIRECT_URL'),
		],
		'github' => [
			'client_id' 	=> getenv('GITHUB_CLIENT_ID'),
			'client_secret' => getenv('GITHUB_CLIENT_SECRET'),
			'redirect_uri' 	=> getenv('GITHUB_REDIRECT_URL'),
		],
		'braintree' => [
	        'environment'   => '',
	        'merchant_id' 	=> '',
	        'public_key' 	=> '',
	        'private_key' 	=> '',
		],
	],
];