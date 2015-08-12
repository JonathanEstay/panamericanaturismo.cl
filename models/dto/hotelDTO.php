<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class hotelDTO
{
    private $_codigo;
    private $_hotel;
    private $_pais;
    private $_ciudad;
    private $_fono;
    private $_direc;
    private $_cat;
    private $_descrip;
    
    private $_ope;
    private $_nota;
    private $_restaurante;
    private $_bar;
    private $_cafeteria;
    private $_s_habitacion;
    private $_busness_center;
    private $_internet_hotel;
    private $_estacionamiento;
    private $_piscina_cub;
    private $_piscina_des;
    private $_gym;
    private $_spa;
    private $_tenis;
    private $_guarderia;
    private $_salas_reunion;
    private $_jardin;
    private $_discapacitados;
    private $_boutique;
    private $_acondicionado;
    private $_calefaccion;
    private $_no_fuma;
    private $_caja_fuerte;
    private $_mini_bar;
    private $_television;
    private $_tv_cable;
    private $_inter_hab;
    private $_secador_pelo;
    private $_barra_seguridad;
    private $_lavanderia;
    private $_telefono;
    private $_img_encabezado;
    private $_img_contenido;
    private $_img_contenido2;
    private $_img_contenido3;
    private $_img_contenido4;
    private $_mini_img_encabezado;
    private $_mini_img_contenido;
    private $_mini_img_contenido2;
    private $_mini_img_contenido3;
    private $_mini_img_contenido4;
    private $_lat;
    private $_lon;
    private $_child_free;
    private $_prepago;
    private $_dias_prepago;
    private $_comag;
    private $_sweb;
    
    
    public function getSitioWeb()
    {
        return $this->_sweb;
    }
    public function setSitioWeb($sw)
    {
        $this->_sweb=$sw;
    }
    
    
    public function setComag($comag)
    {
        $this->_comag=$comag;
    }
    public function getComag()
    {
        return $this->_comag;
    }
    
    
    public function setDiasP($dp)
    {
        $this->_dias_prepago=$dp;
    }
    public function getDiasP()
    {
        return $this->_dias_prepago;
    }
    
    
    public function setPrepago($prep)
    {
        $this->_prepago=$prep;
    }
    public function getPrepago()
    {
        return $this->_prepago;
    }


    public function setChildF($cfree)
    {
        $this->_child_free=$cfree;
    }
    public function getChildF()
    {
        return $this->_child_free;
    }
    
    
    public function setLon($lon)
    {
        $this->_lon= $lon;
    }
    public function getLon()
    {
        return $this->_lon;
    }
    
    
    public function setLat($lat)
    {
        $this->_lat=$lat;
    }
    public function getLat()
    {
        return $this->_lat;
    }

    
    public function setMiniImgCont4($img)
    {
        $this->_mini_img_contenido4=$img;
    }
    public function getMiniImgCont4()
    {
        return $this->_mini_img_contenido4;
    }
    
    
    public function setMiniImgCont3($img)
    {
        $this->_mini_img_contenido3=$img;
    }
    public function getMiniImgCont3()
    {
        return $this->_mini_img_contenido3;
    }
    
    
    public function setMiniImgCont2($img)
    {
        $this->_mini_img_contenido2=$img;
    }
    public function getMiniImgCont2()
    {
        return $this->_mini_img_contenido2;
    }
    
    
    public function setMiniImgCont($img)
    {
        $this->_mini_img_contenido=$img;
    }
    public function getMiniImgCont()
    {
        return $this->_mini_img_contenido;
    }
    
    
    public function setMiniImgEnc($img)
    {
        $this->_mini_img_encabezado=$img;
    }
    public function getMiniImgEnc()
    {
        return $this->_mini_img_encabezado;
    }
    
    
    public function setImgCont4($img)
    {
        $this->_img_contenido4=$img;
    }
    public function getImgCont4()
    {
        return $this->_img_contenido4;
    }
    
    
    public function setImgCont3($img)
    {
        $this->_img_contenido3=$img;
    }
    public function getImgCont3()
    {
        return $this->_img_contenido3;
    }
    
    
    public function setImgCont2($img)
    {
        $this->_img_contenido2=$img;
    }
    public function getImgCont2()
    {
        return $this->_img_contenido2;
    }
    
    
    public function setImgCont($img)
    {
        $this->_img_contenido=$img;
    }
    public function getImgCont()
    {
        return $this->_img_contenido;
    }
    
    
    public function setImgEnc($img)
    {
        $this->_img_encabezado=$img;
    }
    public function getImgEnc()
    {
        return $this->_img_encabezado;
    }
    
    
    public function setTelefono($fono)
    {
        $this->_telefono=$fono;
    }
    public function getTelefono()
    {
        return $this->_telefono;
    }
    
    
    public function setLavanderia($lavan)
    {
        $this->_lavanderia=$lavan;
    }
    public function getLavanderia()
    {
        return $this->_lavanderia;
    }

    

    public function setBarraSeg($bs)
    {
        $this->_barra_seguridad=$bs;
    }
    public function getBarraSeg()
    {
        return $this->_barra_seguridad;
    }
    
    
    public function setSecador($spelo)
    {
        $this->_secador_pelo=$spelo;
    }
    public function getSecador()
    {
        return $this->_secador_pelo;
    }
    
    
    public function setInterHab($ihab)
    {
        $this->_inter_hab=$ihab;
    }
    public function getInterHab()
    {
        return $this->_inter_hab;
    }
    
    
    public function setTvCable($cable)
    {
        $this->_tv_cable= $cable;
    }
    public function getTvCable()
    {
        return $this->_tv_cable;
    }
    
    
    public function setTV($tv)
    {
        $this->_television=$tv;
    }
    public function getTV()
    {
        return $this->_television;
    }
    
    
    public function setMiniBar($mbar)
    {
        $this->_mini_bar=$mbar;
    }
    public function getMiniBar()
    {
        return $this->_mini_bar;
    }
    
    
    public function setCajaFuerte($caja)
    {
        $this->_caja_fuerte=$caja;
    }
    public function getCajaFuerte()
    {
        return $this->_caja_fuerte;
    }
    
    
    public function setNoFuma($nofuma)
    {
        $this->_no_fuma=$nofuma;
    }
    public function getNoFuma()
    {
        return $this->_no_fuma;
    }
    
    
    public function setCalefaccion($cal)
    {
        $this->_calefaccion=$cal;
    }
    public function getCalefaccion()
    {
        return $this->_calefaccion;
    }
    
    
    public function setAcondicionado($acon)
    {
        $this->_acondicionado=$acon;
    }
    public function getAcondicionado()
    {
        return $this->_acondicionado;
    }
    
    
    public function setBoutique($bou)
    {
        $this->_boutique=$bou;
    }
    public function getBoutique()
    {
        return $this->_boutique;
    }
    
    
    public function setDiscapacitados($disca)
    {
        $this->_discapacitados=$disca;
    }
    public function getDiscapacitados()
    {
        return $this->_discapacitados;
    }
    
    
    public function setJardin($jardin)
    {
        $this->_jardin=$jardin;
    }
    public function getJardin()
    {
        return $this->_jardin;
    }
    
    
    public function setSalasReu($reunion)
    {
        $this->_salas_reunion=$reunion;
    }
    public function getSalasReu()
    {
        return $this->_salas_reunion;
    }
    
    
    public function setGuarderia($guard)
    {
        $this->_guarderia=$guard;
    }
    public function getGuarderia()
    {
        return $this->_guarderia;
    }
    
    
    public function setTenis($tenis)
    {
        $this->_tenis=$tenis;
    }
    public function getTenis()
    {
        return $this->_tenis;
    }
    
    
    public function setSpa($spa)
    {
        $this->_spa=$spa;
    }
    public function getSpa()
    {
        return $this->_spa;
    }
    
    
    public function setGym($gym)
    {
        $this->_gym=$gym;
    }
    public function getGym()
    {
        return $this->_gym;
    }
    
    
    public function setPiscinaDes($pdes)
    {
        $this->_piscina_des=$pdes;
    }
    public function getPiscinaDes()
    {
        return $this->_piscina_des;
    }
    
    
    public function setPiscinaCub($pcub)
    {
        $this->_piscina_cub=$pcub;
    }
    public function getPiscinaCub()
    {
        return $this->_piscina_cub;
    }
    
    
    public function setEstaciona($est)
    {
        $this->_estacionamiento=$est;
    }
    public function getEstaciona()
    {
        return $this->_estacionamiento;
    }
    
    
    public function setInterHotel($ihotel)
    {
        $this->_internet_hotel=$ihotel;
    }
    public function getInterHotel()
    {
        return $this->_internet_hotel;
    }
    
    
    public function setBusiness($bus)
    {
        $this->_busness_center=$bus;
    }
    public function getBusiness()
    {
        return $this->_busness_center;
    }
    
    
    public function setServHab($shab)
    {
        $this->_s_habitacion=$shab;
    }
    public function getServHab()
    {
        return $this->_s_habitacion;
    }
    
    
    public function setCafeteria($caf)
    {
        $this->_cafeteria=$caf;
    }
    public function getCafeteria()
    {
        return $this->_cafeteria;
    }
    
    
    public function setBar($bar)
    {
        $this->_bar=$bar;
    }
    public function getBar()
    {
        return $this->_bar;
    }
    
    
    public function setRestaurante($res)
    {
        $this->_restaurante=$res;
    }
    public function getRestaurante()
    {
        return $this->_restaurante;
    }
    
    
    public function setNota($nota)
    {
        $this->_nota=$nota;
    }
    public function getNota()
    {
        return $this->_nota;
    }
    
    
    public function setOpe($ope)
    {
        $this->_ope=$ope;
    }
    public function getOpe()
    {
        return $this->_ope;
    }
    
    
    public function setDescrip($desc) {
        $this->_descrip = $desc;
    }
    public function getDescrip() {
        return $this->_descrip;
    }

    
    public function setCat($cat)
    {
        $this->_cat=$cat;
    }
    public function getCat()
    {
        return $this->_cat;
    }

    
    public function setDirec($dir)
    {
        $this->_direc=$dir;
    }
    public function getDirec()
    {
        return $this->_direc;
    }
    
    
    public function setFono($fono)
    {
        $this->_fono=$fono;
    }
    public function getFono()
    {
        return $this->_fono;
    }
    
    
    public function setCiudad($ciu)
    {
        $this->_ciudad=$ciu;
    }
    public function getCiudad()
    {
        return $this->_ciudad;
    }
    
    
    public function setPais($pais)
    {
        $this->_pais=$pais;
    }
    public function getPais()
    {
        return $this->_pais;
    }
    
    
    public function setHotel($hotel)
    {
        $this->_hotel=$hotel;
    }
    public function getHotel()
    {
        return $this->_hotel;
    }
    
    
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
}