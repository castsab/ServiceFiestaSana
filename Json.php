<?php

include_once 'Search.php';

class Json extends Search {
    
    public function getConvertArray($array) {
        return json_encode($array,JSON_PRETTY_PRINT);
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
                
                $a_sites[$i][$row['ID_ENTIDAD']]['ID_ENTIDAD'] = $row['ID_ENTIDAD'];
                $a_sites[$i][$row['ID_ENTIDAD']]['ENTIDAD'] = $a_visit['NOMBRE_ENTIDAD'];
                $a_sites[$i][$row['ID_ENTIDAD']]['ID_VISITA'] = $row['ID_VISITA'];
                $a_sites[$i][$row['ID_ENTIDAD']]['status'] = utf8_encode($a_visit['ESTADO_VISITA']);
                $a_sites[$i][$row['ID_ENTIDAD']]['titulo'] = utf8_encode($a_visit['NOMBRE_ENTIDAD']);
                $a_sites[$i][$row['ID_ENTIDAD']]['concepto'] = utf8_encode($a_visit['CONCEPTO_VISITA']);
                
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