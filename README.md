# Getting start
cherrymanager web management system

Nginx config

one domain one wwwroot：
```nginx
server {
    listen       8008;
    server_name  localhost;
    root   /www/2016/aa/hw;
    index  index.html index.htm index.php;
    
    access_log /usr/local/server/nginx160/logs/adex.log main;
    location / {
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        if (!-e $request_filename){
            rewrite (.*) /index.php last;
        }
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO        '';
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

one domain multiple wwwroot:
```nginx
server {
    listen       80;
    server_name  localhost;

    location / {
        root   /www;
        index  index.html index.htm index.php;
    }

    location ~ /2016/aa/hw/.*/?.*\.(gif|jpg|jpeg|png|bmp|swf|js|css|woff|ttf|woff2|otf)$ {
        root    /www;
        allow all;
    }
    location ~ /2016/aa/hw/.*/?$ {
        root    /www;
        index   index.php index.html index.htm;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        if (!-e $request_filename){
                rewrite ^/(.*)$ /2016/aa/hw/index.php last;
        }
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO        /2016/aa/hw;
        include        fastcgi_params;
    }
    
    location ~ /2016/bb/hw/.*/?.*\.(gif|jpg|jpeg|png|bmp|swf|js|css|woff|ttf|woff2|otf)$ {
            root    /www;
            allow all;
    }
    location ~ /2016/bb/hw/.*/?$ {
        root    /www;
        index   index.php index.html index.htm;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        if (!-e $request_filename){
                rewrite ^/(.*)$ /2016/bb/hw/index.php last;
        }
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param  PATH_INFO        /2016/bb/hw;
        include        fastcgi_params;
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
    
	public function __construct()
	{
        
	}
	
	public function index($params)
	{
		echo "helloworld";
	}
}
```

## step3.
in browse http://your IP/helloworld
