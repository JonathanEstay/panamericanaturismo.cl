<?php

/*
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Lunes, 14 de septiembre de 2015
 */

/**
 * Description of jsonDAO
 *
 * @author Tsyacom-pc
 */
class jsonDAO extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function consultarUser($user) {
        
        $sql = "SELECT * FROM usuarios_h2h WHERE usuario='$user'";

        $datos = $this->_db->consulta($sql);
        
        
        if ($this->_db->numRows($datos) > 0){
            
            $user = $this->_db->fetchAll($datos);
            
            $objetosUser = array();
            
            foreach ($user as $us){
                
                $data = new jsonDTO;
                
                $data->setUser(trim($us['usuario']));
                $data->setPass(trim($us['clave']));
                $data->setIdAgenExter(trim($us['id_agen_externo']));
                $data->setUrlApi(trim($us['url_api']));
                
                $objetosUser[] = $data;
            }
            return $objetosUser;
        } else {
            return false;
        }
    }

    public function updatePagos($status=false, $hash=false, $monto=false, $num_file=false){
        
        $sql="SELECT * FROM pagos_h2h WHERE num_file =".$num_file." AND hash ='".$hash."'";
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos) > 0) {
            
            $sql = "UPDATE pagos_h2h SET "
                    . "status ='$status',"
                    . "monto=$monto,"
                    . "tipo='1',"
                    . "fecha_pago=GETDATE() "
                    . "WHERE "
                    . "num_file =" .$num_file
                    . " AND hash ='".$hash."'";
                    //. " AND status = ''";
            
            $this->_db->consulta($sql);
            
            $sql ="SELECT * FROM pagos_h2h WHERE num_file=".$num_file." AND hash='".$hash."' ";
            $res = $this->_db->consulta($sql);
            $data = $this->_db->fetchAll($res);
            
            
            $sql='SELECT num_rese FROM numero';
            $num=$this->_db->consulta($sql);
            $num_file=$this->_db->fetchAll($num);

            

            $sql ='UPDATE NUMERO SET num_rese =num_rese+1';
            $this->_db->consulta($sql);

            foreach ($data as $da) {
                $datos = new jsonDTO;
                $datos->setDate(trim($da['fecha_pago']));
                $datos->setStatus(trim($da['status']));
                $datos->setNum(trim($num_file[0]['num_rese']));
            }
        
        } else {
            $datos = false;
        }
        
        return $datos;
    }

    
    public function nuevoPago($num_file, $hash) {
        $sql = "INSERT INTO pagos_h2h (num_file, hash, fecha_r)"
            . " VALUES (" . $num_file . ", '" . $hash . "', GETDATE())";
        $this->_db->consulta($sql);
        
        
        $sql="SELECT num_file FROM pagos_h2h WHERE num_file = " . $num_file;
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos) > 0){
            return true;
        } else {
            return false;
        }
    }
    
    
    public function payConfirm($externalId, $hash) {
        $sql="SELECT TOP 1 status FROM pagos_h2h WHERE num_file = " . $externalId . " AND hash = '" . $hash . "'";
        $datos = $this->_db->consulta($sql);
        
        if ($this->_db->numRows($datos) > 0) {
            $pagos = $this->_db->fetchAll($datos);
            $objetosPago = array();
            
            foreach ($pagos as $pay) {
                $data = new jsonDTO;
                $data->setStatus(trim($pay['status']));
                
                $objetosPago[] = $data;
            }
            
            return $objetosPago;
            
        } else {
            return false;
        }
    }
    
    
    public function logJSON($num_file, $json, $origen) {
        $sql = "INSERT INTO log_json (num_file, fecha, detalle, origen)"
            . " VALUES ($num_file , GETDATE(), '$json', '$origen')";
        $this->_db->consulta($sql);
        
        return true;
    }
    
    
    public function getAgencyId() {
        //DISTINTO A VACIO POR DON EDUARDO
        $sql = "SELECT id_agen_externo FROM usuarios_h2h WHERE id_agen_externo <> ''";
        $datos = $this->_db->consulta($sql);
        
        if ($this->_db->numRows($datos) > 0) {
            $user = $this->_db->fetchAll($datos);
            $objetosUser = array();
            
            foreach ($user as $us) {
                $data = new jsonDTO;
                $data->setIdAgenExter(trim($us['id_agen_externo']));
                
                $objetosUser[] = $data;
            }
            
            return $objetosUser;
            
        } else {
            return false;
        }
    }
}
