<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class bloqueoDTO
{
    private $_notas;
    
    private $_ERROR;
    private $_LINEA;
    private $_MSG;
    
    private $_codigo;
    private $_nombre;
    private $_id;
    private $_ciudad;
    private $_nota;
    private $_id_opc;
    private $_desde;
    private $_valor_hab;
    private $_tipo_hab;
    private $_nota_opc;
    private $_moneda;
    private $_itinerario_vuelo;
    private $_tramo;
    private $_planAl;
    private $_record_c;
    private $_precio_desde;


    private $_hoteles;
    private $_cod_hoteles;
    private $_pa;
    private $_th;
    private $_cod_th;
    private $_cat;
    
    private $_incluye;
    private $_pdf;
    
    private $_imagen;
    private $_noches;
    
    private $_chd1;
    private $_chd2;
    private $_file;
    
    private $_pdhotel;
    private $_pdtraslados;
    private $_pdtkt_aereo;
    private $_pdseguro;
    private $_pdplan;
    
    public function getPdhotel(){
        return $this->_pdhotel;
    }
    
    public function setPdhotel($f){
        $this->_pdhotel=$f;
    }
    
    public function getPdtraslados(){
        return $this->_pdtraslados;
    }
    
    public function setPdtraslados($f){
        $this->_pdtraslados=$f;
    }
    
    public function getPdtkt_aereo(){
        return $this->_pdtkt_aereo;
    }
    
    public function setPdtkt_aereo($f){
        $this->_pdtkt_aereo=$f;
    }
    
    public function getPdseguro(){
        return $this->_pdseguro;
    }
    
    public function setPdseguro($f){
        $this->_pdseguro=$f;
    }
    
    public function setPdplan($f){
        $this->_pdplan=$f;
    }
    
    
    public function getPdplan(){
        return $this->_pdplan;
    }
    
    public function getFile(){
        return $this->_file;
    }
    
    public function setFile($file){
        $this->_file=$file;
    }
    public function getChd1() {
        return $this->_chd1;
    }
    public function setChd1($chd) {
        $this->_chd1 = $chd;
    }
    
    public function getChd2() {
        return $this->_chd2;
    }
    public function setChd2($chd2) {
        $this->_chd2 = $chd2;
    }
    
    public function getNoches() {
        return $this->_noches;
    }
    public function setNoches($noches) {
        $this->_noches = $noches;
    }
    
    public function getImagen() {
        return $this->_imagen;
    }
    public function setImagen($img) {
        $this->_imagen = $img;
    }
    
    public function getPDF() {
        return $this->_pdf;
    }
    public function setPDF($pdf) {
        $this->_pdf = $pdf;
    }
    
    
    public function getRecordC(){
        return $this->_record_c;
    }
    public function setRecordC($record){
        $this->_record_c = $record;
    }
    
    public function getPrecioDesde(){
        return $this->_precio_desde;
    }
    public function setPrecioDesde($PrecioDesde){
        $this->_precio_desde = $PrecioDesde;
    }
    
    public function getTramo()
    {
        return $this->_tramo;
    }
    public function setTramo($tramo)
    {
        $this->_tramo=$tramo;
    }
    public function getPlanAl()
    {
        return $this->_planAl;
    }
    public function setPlanAL($PlanAli)
    {
        $this->_planAl=$PlanAli;
    }
    
    public function getItiVuelo()
    {
        return $this->_itinerario_vuelo;
    }
    public function setItiVuelo($iv)
    {
        $this->_itinerario_vuelo=$iv;
    }
    
    
    public function getMoneda()
    {
        return $this->_moneda;
    }
    public function setMoneda($moneda)
    {
        $this->_moneda=$moneda;
    }
    
    public function getTipoHab()
    {
        return $this->_tipo_hab;
    }
    public function setTipoHab($tipoHab)
    {
        $this->_tipo_hab=$tipoHab;
    }
    
    
    public function getNotaOpc()
    {
        return $this->_nota_opc;
    }
    public function setNotaOpc($nota)
    {
        $this->_nota_opc=$nota;
    }
    
    
    public function getValorHab()
    {
        return $this->_valor_hab;
    }
    public function setValorHab($vhab)
    {
        $this->_valor_hab=$vhab;
    }
    
    
    public function getDesde()
    {
        return $this->_desde;
    }
    public function setDesde($desde)
    {
        $this->_desde=$desde;
    }
    
    
    public function getIncluye()
    {
        return $this->_incluye;
    }
    public function setIncluye($inc)
    {
        $this->_incluye=$inc;
    }
    
    
    public function getCat()
    {
        return $this->_cat;
    }
    public function setCat($cat)
    {
        $this->_cat=$cat;
    }
    
    
    public function getCodTH()
    {
        return $this->_cod_th;
    }
    public function setCodTH($cth)
    {
        $this->_cod_th=$cth;
    }
    
    
    public function getTH()
    {
        return $this->_th;
    }
    public function setTH($th)
    {
        $this->_th=$th;
    }
    
    
    public function getPA()
    {
        return $this->_pa;
    }
    public function setPA($pa)
    {
        $this->_pa=$pa;
    }
    
    
    public function getHoteles()
    {
        return $this->_hoteles;
    }
    public function setHoteles($h)
    {
        $this->_hoteles=$h;
    }
    
    
    public function getCodHoteles()
    {
        return $this->_cod_hoteles;
    }
    public function setCodHoteles($ch)
    {
        $this->_cod_hoteles=$ch;
    }
    
    
    public function getIdOpc()
    {
        return $this->_id_opc;
    }
    public function setIdOpc($id)
    {
        $this->_id_opc=$id;
    }
    
    
    public function getNota()
    {
        return $this->_nota;
    }
    public function setNota($nota)
    {
        $this->_nota=$nota;
    }
    
    
    public function getLINEA()
    {
        return $this->_LINEA;
    }
    public function setLINEA($linea)
    {
        $this->_LINEA=$linea;
    }
    
    public function getMSG()
    {
        return $this->_MSG;
    }
    public function setMSG($msg)
    {
        $this->_MSG=$msg;
    }
    
    public function getERROR()
    {
        return $this->_ERROR;
    }
    public function setERROR($error)
    {
        $this->_ERROR=$error;
    }
    
    public function getCiudad()
    {
        return $this->_ciudad;
    }
    public function setCiudad($ciu)
    {
        $this->_ciudad=$ciu;
    }
    
    
    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        $this->_id=$id;
    }
    
    public function setCodigo($cod)
    {
        $this->_codigo=$cod;
    }
    public function getCodigo()
    {
        return $this->_codigo;
    }
    
    public function setNombre($nombre)
    {
        $this->_nombre=$nombre;
    }
    public function getNombre()
    {
        return $this->_nombre;
    }
    
    
    
    
    
    public function setNotas($notas)
    {
        $this->_notas=$notas;
    }
    public function getNotas()
    {
        return $this->_notas;
    }
}