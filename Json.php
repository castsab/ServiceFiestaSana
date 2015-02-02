<?php

include_once 'Search.php';

class Json extends Search {
    
    public function getConvertArray($array) {
        return json_encode($array,JSON_PRETTY_PRINT);
    }
    
    public function getConsultNameEntityDistrital($id_entidad){
        
        $ent_distrital = "";
        
        switch ($id_entidad) {
                    
            case '3':{
                $ent_distrital = "Bomberos";
            }break;

            case '5':{
                $ent_distrital = "Salud";
            }break;

            case '6':{
                $ent_distrital = "Ambiente";
            }break;

            case '19':{
                $ent_distrital = "Gobierno";
            }break;

            case '22':{
                $ent_distrital = "Camara";
            }break;

            case '23':{
                $ent_distrital = "Sayco";
            }break;

            default:{
                $ent_distrital = $id_entidad;
            }break;
                
        }
        
        return $ent_distrital;
    }
    
    public function getJsonCampaign(){
        
        $a_campaign = array();
        
        $rs = $this->getCampaign();

        $i = 0;

        while ($rw = oci_fetch_array($rs,OCI_ASSOC)) {

            $a_campaign[$i]['CAMP_ID'] = $rw['CAMP_ID'];
            $a_campaign[$i]['CAMP_NOMBRE'] = utf8_encode($rw['CAMP_NOMBRE']);
            $a_campaign[$i]['CAMP_URL_IMAGEN'] = utf8_encode($rw['CAMP_URL_IMAGEN']);
            $a_campaign[$i]['CAMP_DESCRIPCION'] = utf8_encode($rw['CAMP_DESCRIPCION']);
            
            $i++;
        }

        return $this->getConvertArray($a_campaign);
    }
    
    public function getJsonZones(){
        
        $a_zones = array();
        
        $rs = $this->getZones();

        $i = 0;

        while ($rw = oci_fetch_array($rs,OCI_ASSOC)) {

            $a_zones[$i]['ZONA_ID'] = $rw['ZONA_ID'];
            $a_zones[$i]['ZONA_NOMBRE'] = utf8_encode($rw['ZONA_NOMBRE']);

            $i++;
        }

        return $this->getConvertArray($a_zones);
    }
    
    public function getJsonLocalitys(){
        
        $a_zones = array();
        
        $rs = $this->getLocalitys();

        $i = 0;

        while ($rw = oci_fetch_array($rs,OCI_ASSOC)) {

            $a_zones[$i]['ID_LOCALIDAD'] = $rw['ID_LOCALIDAD'];
            $a_zones[$i]['NOMBRE_LOCALIDAD'] = utf8_encode($rw['NOMBRE_LOCALIDAD']);

            $i++;
        }

        return $this->getConvertArray($a_zones);

    }
    
    public function getJsonSites($cond){
        
        $rs = '';
        $rw = '';
        $a_sites = array();
        
        $a_zones_site = array();
        
        $rs = $this->getSites($cond);
        
        $i = 0;

        while ($rw = oci_fetch_array($rs,OCI_ASSOC)) {
            
            $a_sites[$i]['NUMERO_MATRICULA'] = utf8_encode($rw['NUMERO_MATRICULA']);
            $a_sites[$i]['Nombre'] = utf8_encode($rw['RAZON_SOCIAL']);
            $a_sites[$i]['Direccion'] = utf8_encode($rw['DIRECCION_COMERCIAL']);
            $a_sites[$i]['Telefono'] = utf8_encode($rw['TELEFONO']);
            $a_sites[$i]['Url'] = utf8_encode($rw['PAGINA_WEB']);
            $a_sites[$i]['Email'] = utf8_encode($rw['EMAIL']);
            $a_sites[$i]['id_zona'] = $rw['ID_ZONA'];
            $a_sites[$i]['Zona'] = utf8_encode($rw['NOMBRE_ZONA']);
            $a_sites[$i]['id_localidad'] = $rw['ID_LOCALIDAD'];
            $a_sites[$i]['Localidad'] = utf8_encode($rw['Localidad']);
            $a_sites[$i]['Latitud'] = $rw['COORDENADA_X'];
            $a_sites[$i]['Longitud'] = $rw['COORDENADA_Y'];
            
            //------------------------------------------------
            $rss = '';

            $rss = $this->getSearchVisitByEntity($rw['NUMERO_MATRICULA'],$cond);

            $j = 0;

            while ($row = oci_fetch_array($rss,OCI_ASSOC)) {
                
                $a_visit = $this->getConceptVisitByEntity($row['ID_VISITA']);
                
                $a_visit['ESTADO_VISITA'] = ($a_visit['ESTADO_VISITA'] == 'CUMPLE')?'true':'false';
                
                $ent_distrital = $this->getConsultNameEntityDistrital($row['ID_ENTIDAD']);
                
                $a_sites[$i][$ent_distrital]['ID_ENTIDAD'] = $row['ID_ENTIDAD'];
                $a_sites[$i][$ent_distrital]['ENTIDAD'] = $a_visit['NOMBRE_ENTIDAD'];
                $a_sites[$i][$ent_distrital]['ID_VISITA'] = $row['ID_VISITA'];
                $a_sites[$i][$ent_distrital]['status'] = utf8_encode($a_visit['ESTADO_VISITA']);
                $a_sites[$i][$ent_distrital]['titulo'] = utf8_encode($a_visit['NOMBRE_ENTIDAD']);
                $a_sites[$i][$ent_distrital]['concepto'] = utf8_encode($a_visit['CONCEPTO_VISITA']);
                
                $j++;
            }
            //------------------------------------------------
            
            $i++;
        }
        
        
        /*echo '<pre>';
        print_r($a_zones_site);
        echo '</pre><br>';*/
        
        return $this->getConvertArray($a_sites);

    }
    
}

?>