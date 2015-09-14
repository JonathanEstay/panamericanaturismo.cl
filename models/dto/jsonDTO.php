<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : lunes, 14 de septiembre de 2015
 */
class jsonDTO {
    private $_user;
    private $_pass;
    
    public function setUser($user) {
        $this->_user=$user;
    }
    public function getUser() {
        return $this->_user;
    }
    
    public function setPass($pass){
        $this->_pass=$pass;
    }
    
    public function getPass() {
        return $this->_pass;
    }
}
