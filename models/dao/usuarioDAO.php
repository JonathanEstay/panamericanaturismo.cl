<?php

/* 
 * Proyecto : panamericanaturismo.cl
 * Autor    : Tsyacom Ltda.
 * Fecha    : Viernes, 24 de julio de 2015
 */

class usuarioDAO extends Model
{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getUsuarios($usuario)
    {
        $sql='SELECT *, (case when fecpass < getdate() then "1" else "0" end) as cambio_pass
                FROM usuarios U
                JOIN agenc_na AN ON (AN.id=U.id_agen)
                WHERE U.clave="'.$usuario.'"';
        
        //echo $sql;
        
        $datos= $this->_db->consulta($sql);
        
        if($this->_db->numRows($datos)>0)
        {
            $userArray = $this->_db->fetchAll($datos);
            $objetosUser = array();
            $userObj = new usuarioDTO();
            
            foreach ($userArray as $usdb)
            {
                $userObj->setClave(trim($usdb['clave']));
                $userObj->setPassword(trim($usdb['pasword']));
                $userObj->setCambioPass(trim($usdb['cambio_pass']));
                
                $userObj->setNombre(trim($usdb['nombre']));
                $userObj->setCodigo(trim($usdb['codigo']));
                
                $userObj->setDoctoD(trim($usdb['dctod']));
                $userObj->setDoctoH(trim($usdb['dctoh']));
                
                $userObj->setAgencia(trim($usdb['agencia']));
                $userObj->setIdAgen(trim($usdb['id_agen']));
                
                $userObj->setMarkup(trim($usdb['markup']));
                $userObj->setFechaPass(trim($usdb['fecpass']));
                
                $userObj->setDepto(trim($usdb['depto']));
                $userObj->setAtipoa(trim($usdb['atipoa']));
                
                $userObj->setRut(trim($usdb['rut']));
                $userObj->setEmail(trim($usdb['email']));
                $userObj->setEmailOpera(trim($usdb['email_opera']));

                
                $objetosUser[]=$userObj;
            }
            
            return $objetosUser;
        }
        else
        {
            return false;
        }
        
    }
    
    public function sp_perfilClave($user, $prg)
    {
        //STORED PROCEDURE
        $sql="exec SP_PERFIL_CLAVE_PRG '".$user."','".$prg."' ";
        //echo $sql;
        
        $datos= $this->_db->consulta($sql);
        if($this->_db->numRows($datos)>0)
        {
            return $this->_db->fetchAll($datos);
        }
        else
        {
            return false;
        }

    }
    
    public function getTcambio($atipo = ''){
        
        if($atipo == ''){
            
            $sql = "SELECT TOP 1 cambio FROM tcambio WHERE getdate() between fechad AND fechah";
            
        }else{
        
            $sql = "SELECT TOP 1 cambio FROM tcambio WHERE getdate() between fechad AND fechah and atipoa='$atipo'";
        }
        
        
        $datos = $this->_db->consulta($sql);
        
        if($this->_db->numRows($datos)>0)
        {
            $userArray=$this->_db->fetchAll($datos);
            
           $objusuario = new usuarioDTO();
           foreach ($userArray as $usdb){
           
           $objusuario->setTipoCambio(trim($usdb['cambio']));
           }
           
           return $objusuario;
           
        }  
        else
        {
            $objusuario = new usuarioDTO();
            
            $objusuario->setTipoCambio(0);
            
          return $objusuario;  
        }
        
    }
    public function getPaisTc($ciudad) {
        $sql='select p.nombre from pais p inner join ciudad c on p.codigo = c.codigop where c.nombre ="'. $ciudad.'"';
        
        $datos = $this->_db->consulta($sql);
        $pais=$this->_db->fetchAll($datos);
        
        if(trim($pais[0][0])==='CHILE'){
            return 'N';
        }else{
            return 'E';
        }
    }
    
    public function getPaisTcProg($ciudad) {
        $sql='select p.nombre from pais p inner join ciudad c on p.codigo = c.codigop where c.codigo ="'. $ciudad.'"';
        
        $datos = $this->_db->consulta($sql);
        $pais=$this->_db->fetchAll($datos);
        
        if(trim($pais[0][0])==='CHILE'){
            return 'N';
        }else{
            return 'E';
        }
    }
    
    
}

?>