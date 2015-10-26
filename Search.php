<?php

include_once 'Connect.php';

class Search extends Connect {
    
    
    public function getCampaign() {

        $sql = 'select 
                    CAMP_ID As CAMP_ID,
                    CAMP_NOMBRE As CAMP_NOMBRE,
                    CAMP_URL_IMAGEN As CAMP_URL_IMAGEN,
                    CAMP_DESCRIPCION As CAMP_DESCRIPCION
               from 
                    T_CAMPANA 
               WHERE 
                    CAMP_ID=1 ';
        
        $rs = $this->getRun($sql);
        return $rs;
    }
    
    public function getZones() {

        $sql = 'select ZONA_ID As ZONA_ID,ZONA_NOMBRE As ZONA_NOMBRE from T_ZONA';
        $rs = $this->getRun($sql);
        return $rs;
    }
    
    public function getLocalitys() {

        $sql = 'select LOCA_ID As ID_LOCALIDAD,NOM_LOCALIDAD As NOMBRE_LOCALIDAD from T_LOCALIDADES';
        $rs = $this->getRun($sql);
        return $rs;
    }
    
    public function getSites($cond) {

        $sql = 'select 
                    ESTA_MATRICULA As NUMERO_MATRICULA,
                    HEST_RAZONSOCIAL As RAZON_SOCIAL,
                    HEST_DIRCOMERCIAL As DIRECCION_COMERCIAL,
                    HEST_TEL As TELEFONO,
                    HEST_MAIL As EMAIL,
                    ESTA_COORDENADA_X As COORDENADA_X,
                    ESTA_COORDENADA_Y As COORDENADA_Y,
                    ZONA_ID As ID_ZONA,
                    ZONA_NOMBRE As NOMBRE_ZONA,
                    LOCA_ID As ID_LOCALIDAD,
                    NOM_LOCALIDAD As NOMBRE_LOCALIDAD,
                    HEST_WEBPAGE As PAGINA_WEB
                from 
                    V_ESTAB_APP_MOVIL
                WHERE 
                    '.$cond.'
                    GROUP BY ESTA_MATRICULA,HEST_RAZONSOCIAL,HEST_DIRCOMERCIAL,HEST_TEL,HEST_MAIL,ESTA_COORDENADA_X,ESTA_COORDENADA_Y,ZONA_ID,ZONA_NOMBRE,LOCA_ID,NOM_LOCALIDAD,HEST_WEBPAGE
                    ORDER BY ESTA_MATRICULA DESC ';
        
        $rs = $this->getRun($sql);
        
        return $rs;
    }
    
    public function getSearchVisitByEntity($numero_matricula,$cond){
       
       $sql = 'select 
                    VISIT_ID As ID_VISITA,
                    ENTI_ID As ID_ENTIDAD
                from 
                    V_ESTAB_APP_MOVIL
                WHERE 
                    '.$cond.' And ESTA_MATRICULA='.$numero_matricula.' ';
       
        $rs = $this->getRun($sql);
        
        return $rs;
    }
    
    public function getConceptVisitByEntity($id_visita){
        
       $sql = 'select 
                    ENTI_NOM As NOMBRE_ENTIDAD,
                    COVI_NOM As ESTADO_VISITA,
                    CAVI_NOM As CONCEPTO_VISITA
                from 
                    V_ESTAB_APP_MOVIL
                WHERE 
                    VISIT_ID='.$id_visita.' AND ROWNUM  = 1 ';
                    
        $rs = $this->getRun($sql);
        
        return oci_fetch_array($rs,OCI_ASSOC);
    }
    
}
