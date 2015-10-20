<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class Session
{
    public static function init()
    {   
        session_start();
    }
    
    public static function destroy($clave = false)
    {
        if($clave)
        {
            if(is_array($clave))
            {
                $cntArr= count($clave);
                for($i=0; $i<$cntArr; $i++)
                {
                    if(isset($_SESSION[$clave[$i]]))
                    {
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            }
            else
            {
                if(isset($_SESSION[$clave]))
                {
                    unset($_SESSION[$clave]);
                }
            }
        }
        else
        {
            session_destroy();
        }
    }
    
    
    public static function set($clave, $valor)
    {
        if(!empty($clave))
            $_SESSION[$clave] = $valor;
    }
    
    
    public static function get($clave)
    {
        if(isset($_SESSION[$clave]))
            return $_SESSION[$clave];
    }
    
    
    public static function acceso($level)
    {
        if(!Session::get('Autenticado'))
        {
            header('Location: ' . BASE_URL . 'error/access/8080');//antes 5050
            exit;
        }
        
        Session::tiempo();
        
        //if(Session::getLevel($level) > Session::getLevel(Session::get('level')))
        if(Session::getLevel($level) < Session::getLevel(Session::get('level')))
        {
            header('Location: ' . BASE_URL . 'error/access/8080');// antes 5050
            exit;
        }
    }
    
    
    public static function accesoView($level)
    {
        if(!Session::get('Autenticado'))
        {
            return false;
        }
        
        //if(Session::getLevel($level) > Session::getLevel(Session::get('level')))
        if(Session::getLevel($level) < Session::getLevel(Session::get('level')))
        {
            return false;
        }
        
        return true;
    }
    
    
    public static function getLevel($level)
    {
        /*$role['Admin'] = 3;
        $role['Especial'] = 2;
        $role['Usuario'] = 1;*/
        $role['Admin'] = 1;
        $role['Especial'] = 2;
        $role['Usuario'] = 3;
        
        if(!array_key_exists($level, $role))
        {
            throw new Exception('Error de acceso');
        }
        else 
        {
            return $role[$level];
        }
    }
    
    
    public static function accesoEstricto(array $level, $noAdmin = false)
    {
        if(!Session::get('Autenticado'))
        {
            header('Location: ' . BASE_URL . 'error/access/8080'); // antes 5050
            exit;
        }
        
        Session::tiempo();
        
        if($noAdmin == false)
        {
            if(Session::get('level') == 'Admin')
            {
                return;
            }
        }
        
        if(count($level))
        {
            if(in_array(Session::get('level'), $level)){
                return;
            }
        }
        
        header('Location: ' . BASE_URL . 'error/access/8080'); //antes 5050
        exit;
    }
    
    
    
    public static function accesoEstrictoView(array $level, $noAdmin = false)
    {
        if(!Session::get('Autenticado'))
        {
            return false;
        }
        
        if($noAdmin == false)
        {
            if(Session::get('level') == 'Admin')
            {
                return true;
            }
        }
        
        if(count($level))
        {
            if(in_array(Session::get('level'), $level)){
                return true;
            }
        }
        
        return false;
    }
    
    
    public static function tiempo()
    {
        if(!Session::get('tiempo') || !defined('APP_SESSION_TIME'))
        {
            throw new Exception('No se ha definido el tiempo de sesion');
        }
        
        if(APP_SESSION_TIME == 0)
        {
            return;
        }
        
        if((time() - Session::get('tiempo')) > (APP_SESSION_TIME * 60))
        {
            
            Session::destroy(Controller::destroyArray());
            header('Location: ' . BASE_URL . 'error/access/8080');
        }
        else
        {
            Session::set('tiempo', time());
        }
    }
    
    public static function accForm($level)
    {
        if(!Session::get('Autenticado'))
        {
            header('Location: ' . BASE_URL . 'login/logForm');
            exit;
        }
	
	Session::tiempo();
    }
} 