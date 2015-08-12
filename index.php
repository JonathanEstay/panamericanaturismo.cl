<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);
define('CHARSET', 'ISO-8859-1'); //UTF-8

//ini_set('mssql.charset', CHARSET);
session_name('p4naW3r1Can4');
session_cache_limiter('nocache');
date_default_timezone_set('America/Santiago');
//date_default_timezone_set('America/Argentina/Buenos_Aires');
header('Content-Type: text/html; charset=' . CHARSET);



try
{
    require_once APP_PATH . 'Autoload.php';
    require_once APP_PATH . 'Config.php';
    
    Session::init();
    
    $registry = Registry::getInstancia();
    $registry->_request = new Request();
    $registry->_db = new Database();
    //$registry->_acl = new Acl();
    
    

    Bootstrap::run($registry->_request);
}
catch (Exception $e)
{
    echo $e->getMessage();
}
?>