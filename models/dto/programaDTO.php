<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class programaDTO
{
    private $_ERROR;
    private $_LINEA;
    private $_MSG;
    
    private $_id;
    private $_id_opc;
    private $_codigo;
    private $_nombre;
    private $_desde;
    private $_hasta;
    private $_noches;
    private $_tipo_p;
    private $_cod_bloq;
    private $_espacios;
    private $_pais;
    private $_ciudad;
    private $_titulo;
    private $_epigrafe;
    private $_moneda;
    private $_tcambio;
    private $_valor_desde;
    private $_aereo;
    private $_hotel;
    private $_traslado;
    private $_allInclu;
    private $_rauto;
    private $_crucero;
    private $_asisten;
    private $_itinera;
    private $_imagen;
    private $_nota;
    private $_incluye;
    private $_descrip;
    private $_cat_estrella;
    private $_iata;
    private $_tramo;
    private $_pbhotel;
    private $_pdtraslados;
    private $_pdaereo;
    private $_pdseguro;
    private $_pdplana;
    private $_chedad1;
    private $_chedad2;
    private $_estado;
    
    public function setEstado($p) {
        $this->_estado=$p;
    }
    
    public function getEstado() {
        return $this->_estado;
    }
    public function setChedad1($p) {
        $this->_chedad1=$p;
    }
    public function getChedad1() {
        return $this->_chedad1;
    }
    public function setChedad2($p) {
        $this->_chedad2=$p;
    }
    public function getChedad2() {
        return $this->_chedad2;
    }
    public function setPbhotel($p){
        $this->_pbhotel = $p ;
    }
    
    public function getPbhotel(){
        return $this->_pbhotel ;
    }
    
    public function setPdtraslados($p){
        $this->_pdtraslados = $p ;
    }
    
    public function getPdtraslados(){
        return $this->_pdtraslados ;
    }
    
    public function setPdaereo($p){
        $this->_pdaereo = $p ;
    }
    
    public function getPdaereo(){
        return $this->_pdaereo ;
    }
    
    public function setPdseguro($p){
        $this->_pdseguro = $p ;
    }
    
    public function getPdseguro(){
        return $this->_pdseguro ;
    }
    
    public function setPdplana($p){
        $this->_pdplana = $p ;
    }
    
    public function getPdplana(){
        return $this->_pdplana ;
    }
    
    public function setTramo($t){
        $this->_tramo = $t;
    }
    public function getTramo() {
        return $this->_tramo;
    }
    
    public function getIata() {
        return $this->_iata;
    }
    public function setIata($iata) {
        $this->_iata = $iata;
    }
    
    public function getCatEstrella() {
        return $this->_cat_estrella;
    }
    public function setCatEstrella($cat) {
        $this->_cat_estrella = $cat;
    }
    
    public function getDescrip() {
        return $this->_descrip;
    }
    public function setDescrip($desc) {
        $this->_descrip = $desc;
    }
    
    public function getIncluye() {
        return $this->_incluye;
    }
    public function setIncluye($inc) {
        $this->_incluye = $inc;
    }
    
    public function getNota() {
        return $this->_nota;
    }
    public function setNota($nota) {
        $this->_nota = $nota;
    }
    
    public function getImagen() {
        return $this->_imagen;
    }
    public function setImagen($img) {
        $this->_imagen = $img;
    }
    
    public function getIti() {
        return $this->_itinera;
    }
    public function setIti($iti) {
        $this->_itinera = $iti;
    }
    
    public function getAsis() {
        return $this->_asisten;
    }
    public function setAsis($asis) {
        $this->_asisten = $asis;
    }
    
    public function getCrucero() {
        return $this->_crucero;
    }
    public function setCrucero($crucero) {
        $this->_crucero = $crucero;
    }
    
    public function getRAauto() {
        return $this->_rauto;
    }
    public function setRAuto($rauto) {
        $this->_rauto = $rauto;
    }
    
    public function getAllInclu() {
        return $this->_allInclu;
    }
    public function setAllInclu($all) {
        $this->_allInclu = $all;
    }
    
    public function getTraslado() {
        return $this->_traslado;
    }
    public function setTraslado($tras) {
        $this->_traslado = $tras;
    }
    
    public function getHotel() {
        return $this->_hotel;
    }
    public function setHotel($hotel) {
        $this->_hotel = $hotel;
    }
    
    public function getAereo() {
        return $this->_aereo;
    }
    public function setAereo($aereo) {
        $this->_aereo = $aereo;
    }
    
    public function getValorDesde() {
        return $this->_valor_desde;
    }
    public function setValorDesde($vdesde) {
        $this->_valor_desde = $vdesde;
    }
    
    public function getTcambio() {
        return $this->_tcambio;
    }
    public function setTcambio($tc) {
        $this->_tcambio = $tc;
    }
    
    public function getMoneda() {
        return $this->_moneda;
    }
    public function setMoneda($mon) {
        $this->_moneda = $mon;
    }
    
    public function getEpigrafe() {
        return $this->_epigrafe;
    }
    public function setEpigrafe($epi) {
        $this->_epigrafe = $epi;
    }
    
    public function getTitulo() {
        return $this->_titulo;
    }
    public function setTitulo($tit) {
        $this->_titulo = $tit;
    }
    
    public function getCiudad() {
        return $this->_ciudad;
    }
    public function setCiudad($ciu) {
        $this->_ciudad = $ciu;
    }
    
    public function getPais() {
        return $this->_pais;
    }
    public function setPais($pais) {
        $this->_pais = $pais;
    }
    
    public function getEspacios() {
        return $this->_espacios;
    }
    public function setEspacios($esp) {
        $this->_espacios = $esp;
    }
    
    public function getCodBloq() {
        return $this->_cod_bloq;
    }
    public function setCodBloq($cod) {
        $this->_cod_bloq = $cod;
    }
    
    public function getTipoP() {
        return $this->_tipo_p;
    }
    public function setTipoP($tipoP) {
        $this->_tipo_p = $tipoP;
    }
    
    public function getNoches() {
        return $this->_noches;
    }
    public function setNoches($noches) {
        $this->_noches = $noches;
    }
    
    public function getHasta() {
        return $this->_hasta;
    }
    public function setHasta($hasta) {
        $this->_hasta = $hasta;
    }
    
    public function getDesde() {
        return $this->_desde;
    }
    public function setDesde($desde) {
        $this->_desde = $desde;
    }
    
    public function getNombre() {
        return $this->_nombre;
    }
    public function setNombre($nombre) {
        $this->_nombre = $nombre;
    }
    
    public function getCodigo() {
        return $this->_codigo;
    }
    public function setCodigo($cod) {
        $this->_codigo = $cod;
    }
    
    public function getId() {
        return $this->_id;
    }
    public function setId($id) {
        $this->_id = $id;
    }
    
    public function getIdOpc() {
        return $this->_id_opc;
    }
    public function setIdOpc($id) {
        $this->_id_opc = $id;
    }
    
    public function getLINEA() {
        return $this->_LINEA;
    }
    public function setLINEA($linea) {
        $this->_LINEA = $linea;
    }
    
    public function getMSG() {
        return $this->_MSG;
    }
    public function setMSG($msg) {
        $this->_MSG = $msg;
    }
    
    public function getERROR() {
        return $this->_ERROR;
    }
    public function setERROR($error) {
        $this->_ERROR = $error;
    }
}