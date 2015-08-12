<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Bootstrap
{
    
    public static function run(Request $peticion)
    {
        Session::set('SESS_CONTROLLER', $peticion->getControlador());
        $controller= $peticion->getControlador() . 'Controller';
        $rutaControlador= ROOT . 'controllers' . DS . $controller . '.php';
        $metodo= $peticion->getMetodo();
        $args= $peticion->getArgs();
        
        if(is_readable($rutaControlador)) //verifica si el archivo existe y tambien es valido
        {
            require_once $rutaControlador;
            $controller= new $controller; //instanciando clase del indexController
            
            if(is_callable(array($controller, $metodo)))
            {
                $metodo= $peticion->getMetodo();
            }
            else
            {
                $metodo='index';
            }
            
            if($args!=null)
            {
                call_user_func_array(array($controller, $metodo), $args); //en un arreglo enviamos nombre de clase y metodo que queremos llamar y parametros que queremos pasar
            }
            else
            {
                call_user_func(array($controller, $metodo));
            }
        }
        else
        {
            throw new Exception('Controller no encontrado: ' . $rutaControlador);
        }
        
    }
    
}