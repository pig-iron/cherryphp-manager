<?php
return array(
    'mysql'=>array(
        '0'=>array(
            'dblocal' =>  'localhost',
            'dbport'  =>  '3306',
            'dbuser'  =>  'root',
            'dbpass'  =>  '123',
            'dbname'  =>  'rogmgr',
        ),
    ),
    'redis'=>array(
        '0'=>array(
			'host'=>'10.225.2.48',
            'port'=>'6359',
		),
    ),
    'zookeeper'=>array(
        '0'=>array(
			'ZOOKEEPER_HOST' => '10.215.2.211:221,10.215.2.211:222,10.215.2.211:223',
			'ZK_SERVER_PATH' => '/westM/kukuhero/server',
			'ZK_MAIL_PATH'   => '/westM/kukuhero/mail',
		),
    ),
    'aws'=>array(
        '0'=>array(
            'key'    => 'aaaaaaaaaaaa',
            'secret' => 'aaaaaaaaaaaaaaaaaaaaaaa',
            'region' => 'apasdsoutheastasdasdasd',
            'bucket' =>'apfasfasf',
        ),
    ),
	'define'=>array(
		'APP_TPL'     =>'view',//必须 定义模板目录
		'APP_PATH'    =>'/www/rogmgr/',//必须 定义APP根目录
		'APP_PORT'    =>'8008',//必须 定义APP端口号
		'ERROR404'    =>'view/html/404.html',//必须 定义404错误页地址
		'PAGE'        =>10,
		'GMPORT'      =>'GsssPort',
		'SERVICE_IP'  =>'service_ip',
	),
    'charset'=>'utf8',//必须 定义字符集
);