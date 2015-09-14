<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : lunes, 14 de septiembre de 2015
 */
class jsonDTO {
    private $_user;
    private $_pass;
    private $_id_agen_exter;
    private $_date;
    private $_num_file;
    private $_status;
    
    public function setNum($num) {
        $this->_num_file=$num;
    }
    public function getNum() {
        return $this->_num_file;
    }
    
    public function setStatus($status) {
        $this->_status=$status;
    }
    public function getStatus() {
        return $this->_status;
    }
    
    public function setDate($date) {
        $this->_date=$date;
    }
    public function getDate() {
        return $this->_date;
    }
    
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
    
    public function setIdAgenExter($id){
        $this->_id_agen_exter=$id;
    }
    
    public function getIdAgentExter() {
        return $this->_id_agen_exter;
    }
    
}
