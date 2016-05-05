<?php
return array(
    'login'                => array('mcp\login', '', ''),
    'index'                => array('mcp\main', 'index', ''),
    'authorization'        => array('mcp\authorization', '', ''),
    'logout'               => array('mcp\login','logout',''),
    'getkv'                => array('mcp\login','get_kv',''),//测试权限对应关系列表
    'log'                  => array('mcp\log', 'index', ''),
    'logact'               => array('mcp\log', '', ''),
);
