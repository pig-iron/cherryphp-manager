<?php
return array(
    'mysql'=>array(
        '0'=>array(
            'dblocal' =>  'XXXX',
            'dbport'  =>  'XXXX',
            'dbuser'  =>  'XXXX',
            'dbpass'  =>  'XXXX',
            'dbname'  =>  'XXXX',
        ),
    ),
    'redis'=>array(
        '0'=>array(
		'host'=>'XXXX',
        	'port'=>'XXXX',
	),
    ),
    'zookeeper'=>array(
        '0'=>array(
			'ZOOKEEPER_HOST' => 'XXXX:XXX,XXXX:XXX,XXXX:XXX',
			'ZK_SERVER_PATH' => '/XXXX/XXXX/XXXX',
			'ZK_MAIL_PATH'   => '/XXXX/XXXX/XXXX',
		),
    ),
    'aws'=>array(
        '0'=>array(
            'key'    => 'XXXX',
            'secret' => 'XXXX',
            'region' => 'XXXX',
            'bucket' => 'XXXX',
        ),
    ),
	'define'=>array(
		'APP_TPL'     =>'view',//必须 定义模板目录
		'APP_PATH'    =>'/XXXX/XXXX/',//必须 定义APP根目录
		'APP_PORT'    =>'XXXX',//必须 定义APP端口号
		'ERROR404'    =>'view/html/404.html',//必须 定义404错误页地址
		'PAGE'        =>10,
		'GMPORT'      =>'XXXX',
		'SERVICE_IP'  =>'XXXX',
	),
    'charset'=>'utf8',//必须 定义字符集
);
