<?php
return [
	'yun'=>[//阿里云短信
		'access_key_id'        => 'xxxxxx',//
		'access_key_secret'    => 'xxxxxx',//
		'common_sign_name'     => '支付宝',//普通模板签名
		'spread_sign_name'     => '支付宝',//推广模板签名
		'template_code'        => [
			'register' => 'SMS_35650882',//模板code让一个变量来替换
		]
	],
	'api'=>[//云市场短信
		'api_app_key'           => '',//
		'api_app_secret'        => '',//
		'api_sign_name'         => '',//普通模板签名
		'api_template_code'     => [
			'register' => 'SMS_35650882',//模板code让一个变量来替换
		]
	],
	'note'=>[//短信发送API
		'access_key_id'        => 'xxxxxx',//
		'access_key_secret'    => 'xxxxxx',//
		'common_sign_name'     => '支付宝',//普通模板签名
		'template_code'        => [
			'register' => 'SMS_35650882',//模板code让一个变量来替换
		]
	]
];