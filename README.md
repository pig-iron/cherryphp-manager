# Getting start
cherrymanager web management system

Nginx config
```nginx
  server {
    listen       8004;
    server_name  localhost;
	root   /usr/local/server/www/cherrymanager/;
    index  index.html index.htm index.php;

	access_log /usr/local/server/nginx160/logs/adex.log main;		
    location / {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        if (!-e $request_filename){
            rewrite (.*) /index.php last;
        }
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        include        fastcgi_params;

	}

	location ~ .*\.(gif|jpg|jpeg|png|bmp|swf|js|css|woff|ttf|woff2|otf)$ {
		if (-f $request_filename){
			expires 1d;
			break;
		}
	}
    error_page   500 502 503 504  /50x.html;
    location = /50x.html {
        root   html;
    }
}

```

# How to Hello world
## step1.
edit /router.php
```php
<?php
return array(
    'login'                => array('mcp\login', '', ''),
    'index'                => array('mcp\main', 'index', ''),
    'authorization'        => array('mcp\authorization', '', ''),
    'logout'               => array('mcp\login','logout',''),
    'getkv'                => array('mcp\login','get_kv',''),//测试权限对应关系列表
    'log'                  => array('mcp\log', 'index', ''),
    'logact'               => array('mcp\log', '', ''),
    'helloworld'           => array('mcp\helloworld', 'index', ''),
);
```
append "'helloworld' => array('mcp\helloworld', 'index', '')," in this file.
array(controller path, action, params)

## step2.
create /mcp/helloworld.php
```php
<?php
namespace mcp;
class helloworld extends \cherryphp\CherryView
{
    private static $rules;
	public function __construct()
	{
        self::$rules=\module\mauthrules::authtoken();
	}
	
	public function index($params)
	{
		echo "helloworld";
	}
}
```

## step3.
in browse http://your IP/helloworld
