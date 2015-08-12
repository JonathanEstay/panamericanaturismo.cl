<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

function autoloadCore($class) { 
    if(file_exists(APP_PATH . ucfirst(strtolower($class)) . '.php')) {
        include_once APP_PATH . $class . '.php'; 
        //echo APP_PATH . $class . '.php' . '<br>'; 
    }
}

function autoloadLibs($class) { 
    if(file_exists(ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php')) {
        include_once ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php'; 
    }
}

 spl_autoload_register('autoloadCore');
 spl_autoload_register('autoloadLibs');