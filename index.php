<?php
// error_reporting(E_ALL^E_NOTICE);
// xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
error_reporting(E_ALL);
//error_reporting(null);
require(dirname($_SERVER['SCRIPT_FILENAME']).'/cherryphp/Cherry.php');
$config="";
Cherry::Prepare($config)->Execute();
