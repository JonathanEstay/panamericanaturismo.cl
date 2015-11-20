<?php

/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 10 de octubre de 2014
 */
class functionsController extends Controller {
    
    public function index() {
        
    }
    public function validacorreo($email) {
        
        $re = Functions::validaCorreo($email);
        if($re){
            echo '1';
        }else{
            echo '0';
        }
    }

}
