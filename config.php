<?php
return array(
    'mysql'=>array(
        '0'=>array(
            'dblocal' =>  'XX',
            'dbport'  =>  'XX',
            'dbuser'  =>  'XX',
            'dbpass'  =>  'XX',
            'dbname'  =>  'XX',
        ),
    ),
    'redis'=>array(
        '0'=>array(
			'host'=>'XXX',
            'port'=>'XX',
		),
        '1'=>array(
			'host'=>'XX',
            'port'=>'XX',
		),
    ),
    'zookeeper'=>array(
        '0'=>array(
			'ZOOKEEPER_HOST' => 'XX',
			'ZK_SERVER_PATH' => 'XX',
			'ZK_MAIL_PATH'   => 'XX',
		),
    ),
    'aws'=>array(
        '0'=>array(
            'key'    => 'XX',
            'secret' => 'XX',
            'region' => 'XX',
            'bucket' =>'XX',
        ),
    ),
    'mongodb' =>array(
        '0'=>array(
            'dblocal'   =>"XX",
            'dbname'    =>"XX",
            'collection'=>array(
                'mail' =>"XX",
                'char' =>"XX",
                'forum'=>"XX",
            ),
        )
    ),
	'define'=>array(
		'APP_TPL'     =>'XX',//必须 定义模板目录
		'APP_PATH'    =>'XX',//必须 定义APP根目录
		'APP_PORT'    =>'XX',//必须 定义APP端口号
		'ERROR404'    =>'XX',//必须 定义404错误页地址
		'PAGE'        =>XX,
		'GMPORT'      =>'XX',
		'SERVICE_IP'  =>'XX',
        'SALT'        =>'XX',
	),
    'charset'=>'utf8',//必须 定义字符集
);
