<?php

/* 
 * Proyecto : Euroandino.net
 * Autor    : Tsyacom Ltda.
 * Fecha    : Miercoles, 10 de octubre de 2014
 */

class validar{
    
    public function formUrl() {
        
        if(Session::get('sess_Url_Form')){
                      
            switch (Session::get('sess_Url_Form')) {
                case 'd7bd9a0de578cc436d7a77d07954882d':
                    return'http://www.terra.com/';
                    break;

                case '14efdce76d3988f65ffbe2f700dd79bc':
                    return'https://www.youtube.com/embed/XGSy3_Czz8k?autoplay=1';
                    break;
            }
        }
        
    }
}
