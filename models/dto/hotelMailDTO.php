<?php

class hotelMailDTO{
    private $_nombre;
    private $_direccion;
    private $_ciudad;
    private $_nomPax;
    private $_file;
    private $_pax_s;
    private $_pax_d;
    private $_pax_t;
    private $_pax_q;
    private $_pax_c;
    private $_pax_ca;
    private $_pax_c2;
    private $_tipoH;
    private $_htl;
    private $_pa;
    private $_in_;
    private $_out;
    private $_hoteles;
    private $_totPax;
    private $_dia;
    private $_codigo;
    private $_glosa;
    private $_prove;
    private $_hora;
    private $_vuelo;
    private $_convenio;
    private $_horaDia;
    private $_email;
    
    
    function getEmail() {
        return $this->_email;
    }

    function setEmail($_email) {
        $this->_email = $_email;
    }

        function getHoraDia() {
        return $this->_horaDia;
    }

    function setHoraDia($_horaDia) {
        $this->_horaDia = $_horaDia;
    }

        function getConvenio() {
        return $this->_convenio;
    }

    function setConvenio($_convenio) {
        $this->_convenio = $_convenio;
    }

        
    function getHora() {
        return $this->_hora;
    }

    function getVuelo() {
        return $this->_vuelo;
    }

    function setHora($_hora) {
        $this->_hora = $_hora;
    }

    function setVuelo($_vuelo) {
        $this->_vuelo = $_vuelo;
    }

    function getProve() {
        return $this->_prove;
    }

    function setProve($_prove) {
        $this->_prove = $_prove;
    }

    function getGlosa() {
        return $this->_glosa;
    }

    function setGlosa($_glosa) {
        $this->_glosa = $_glosa;
    }

        
    function getCodigo() {
        return $this->_codigo;
    }

    function setCodigo($_codigo) {
        $this->_codigo = $_codigo;
    }

    function getDia() {
        return $this->_dia;
    }

    function setDia($_dia) {
        $this->_dia = $_dia;
    }

        function getTotPax() {
        return $this->_totPax;
    }

    function setTotPax($_totPax) {
        $this->_totPax = $_totPax;
    }

        function getHoteles() {
        return $this->_hoteles;
    }

    function setHoteles($_hoteles) {
        $this->_hoteles = $_hoteles;
    }

        function getIn_() {
        return $this->_in_;
    }

    function getOut() {
        return $this->_out;
    }

    function setIn_($_in_) {
        $this->_in_ = $_in_;
    }

    function setOut($_out) {
        $this->_out = $_out;
    }

    function getPa() {
        return $this->_pa;
    }

    function setPa($_pa) {
        $this->_pa = $_pa;
    }

        function getHtl() {
        return $this->_htl;
    }

    function setHtl($_htl) {
        $this->_htl = $_htl;
    }

        function getTipoH() {
        return $this->_tipoH;
    }

    function setTipoH($_tipoH) {
        $this->_tipoH = $_tipoH;
    }

        function getPax_s() {
        return $this->_pax_s;
    }

    function getPax_d() {
        return $this->_pax_d;
    }

    function getPax_t() {
        return $this->_pax_t;
    }

    function getPax_q() {
        return $this->_pax_q;
    }

    function getPax_c() {
        return $this->_pax_c;
    }

    function getPax_ca() {
        return $this->_pax_ca;
    }

    function getPax_c2() {
        return $this->_pax_c2;
    }

    function setPax_s($_pax_s) {
        $this->_pax_s = $_pax_s;
    }

    function setPax_d($_pax_d) {
        $this->_pax_d = $_pax_d;
    }

    function setPax_t($_pax_t) {
        $this->_pax_t = $_pax_t;
    }

    function setPax_q($_pax_q) {
        $this->_pax_q = $_pax_q;
    }

    function setPax_c($_pax_c) {
        $this->_pax_c = $_pax_c;
    }

    function setPax_ca($_pax_ca) {
        $this->_pax_ca = $_pax_ca;
    }

    function setPax_c2($_pax_c2) {
        $this->_pax_c2 = $_pax_c2;
    }

    function getFile() {
        return $this->_file;
    }

    function setFile($_file) {
        $this->_file = $_file;
    }

        
    function getNomPax() {
        return $this->_nomPax;
    }

    function setNomPax($_nomPax) {
        $this->_nomPax = $_nomPax;
    }

    function getNombre() {
        return $this->_nombre;
    }

    function getDireccion() {
        return $this->_direccion;
    }

    function getCiudad() {
        return $this->_ciudad;
    }

    function setNombre($_nombre) {
        $this->_nombre = $_nombre;
    }

    function setDireccion($_direccion) {
        $this->_direccion = $_direccion;
    }

    function setCiudad($_ciudad) {
        $this->_ciudad = $_ciudad;
    }


}