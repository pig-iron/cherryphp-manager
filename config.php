<?php
return array(
    'mysql'=>array(
        '0'=>array(
            'dblocal' =>  'localhost',
            'dbport'  =>  '3306',
            'dbuser'  =>  'root',
            'dbpass'  =>  'unicorn',
            'dbname'  =>  'cherrymanager',
        ),
    ),

	'define'=>array(
		'APP_TPL'     => 'view',//必须 定义模板目录
		'APP_PATH'    => '/www/2016/aa/hw/',//必须 定义APP根目录
		'APP_PORT'    => '80',//必须 定义APP端口号
		'ERROR404'    => 'view/html/404.html',//必须 定义404错误页地址
		'PAGE'        => 10,
        	'SALT'        => '%@*%1241jsg', //用户加密串
	),
    'charset' => 'utf8',//必须 定义字符集
);
