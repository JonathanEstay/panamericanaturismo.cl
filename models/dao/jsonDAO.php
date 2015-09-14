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
                
                $objetosUser[] = $data;
            }
            return $objetosUser;
        } else {
            return false;
        }
    }

    public function updatePagos($status=false,$hash=false ,$monto=false ,$num_file = false){
        
        $sql="SELECT * FROM pagos_travelclub WHERE  num_file=".$num_file."AND hash=".$hash;
        
        
        $datos = $this->_db->consulta($sql);
        if($this->_db->numRows($datos) > 0){
            
            $sql = "UPDATE pagos_travelclub SET "
                            . "status ='$status',"
                            . "monto=$monto,"
                            . "tipo='1',"
                            . "fecha_pago=GETDATE() "
                            . "WHERE "
                            . "num_file =" .$num_file
                            ."AND hash=".$hash;
            
            $datos = $this->_db->consulta($sql);
            
        }else{
            $datos = false;
        }
        return $datos;
    }

}
