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
                
                $objetosUser[] = $data;
            }
            return $objetosUser;
        } else {
            return false;
        }
    }

    public function updatePagos($status=false,$hash=false ,$monto=false ,$num_file = false){
        
        $sql="SELECT * FROM pagos_h2h WHERE  num_file=".$num_file."AND hash=".$hash;
        
        
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos) > 0){
            
            $sql = "UPDATE pagos_h2h SET "
                            . "status ='$status',"
                            . "monto=$monto,"
                            . "tipo='1',"
                            . "fecha_pago=GETDATE() "
                            . "WHERE "
                            . "num_file =" .$num_file
                            ."AND hash=".$hash;
            
            $this->_db->consulta($sql);
        $sql ="SELECT * FROM pagos_h2h WHERE num_file=".$num_file." AND hash=".$hash;
        
        $res = $this->_db->consulta($sql);
        
        $sql='SELECT num_rese FROM numero';
        
        $num=$this->_db->consulta($sql);
        
        $num_file=$this->_db->fetchAll($num);
        
        $data = $this->_db->fetchAll($res);
        
        $sql ='UPDATE NUMERO SET num_rese =num_rese+1';
        
        $this->_db->consulta($sql);
        
        foreach ($data as $da){
            $datos = new jsonDTO;
            $datos->setDate(trim($da['fecha_pago']));
            $datos->setStatus(trim($da['status']));
            $datos->setNum(trim($num_file[0]['num_rese']));
        }
        
        }else{
            $datos = false;
        }
        return $datos;
    }

}
