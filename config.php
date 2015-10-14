<?php
return array(
    'mysql'=>array(
        '0'=>array(
            'dblocal' =>  'localhost',
            'dbport'  =>  '3306',
            'dbuser'  =>  'root',
            'dbpass'  =>  'unicorn',
            'dbname'  =>  'rogmgr',
        ),
    ),
    'redis'=>array(
        '0'=>array(
			'cachehost'=>'10.5.121.124','cacheport'=>'12000',
		),
    ),
    'zookeeper'=>array(
        '0'=>array(
			'ZOOKEEPER_HOST' => '10.235.2.211:2181,10.235.2.211:2182,10.235.2.211:2183',
			'ZK_SERVER_PATH' => '/westM/kukuhero/server',
			'ZK_MAIL_PATH'   => '/westM/kukuhero/mail',
		),
    ),
	'define'=>array(
		'APP_TPL'     =>'view',//必须 定义模板目录
		'APP_PATH'    =>'/www/rogmgr/',//必须 定义APP根目录
		'APP_PORT'    =>'8008',//必须 定义APP端口号
		'ERROR404'    =>'view/html/404.html',//必须 定义404错误页地址
		'PAGE'        =>10,
		'GMPORT'      =>'GMPort',
		'SERVICE_IP'  =>'service_ip',
	),
    'charset'=>'utf8',//必须 定义字符集
);