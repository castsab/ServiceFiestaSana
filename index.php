<?php

// Notificar solamente errores de ejecución
error_reporting(E_ERROR | E_WARNING | E_PARSE);

header ("Content-Type:text/json");

include_once 'Json.php';
$C_Json = new Json();

$json = '';
$service_name = $_POST['service_name'];

switch ($service_name) {
    
    case 'zones':
    {
        $json = $C_Json->getJsonZones();
    }
    break;
    
    case 'localitys':
    {
        $json = $C_Json->getJsonLocalitys();
    }
    break;

    case 'sites_zone':
    {
        $id = $_POST['id_zone'];
        $cond = 'ZONA_ID = '.$id.' ';
        $json = $C_Json->getJsonSites($cond);
    }
    break;

    case 'sites_locality':
    {
        $id = $_POST['id_locality'];
        $cond = 'LOCA_ID = '.$id.' ';
        $json = $C_Json->getJsonSites($cond);
    }
    break;
    
    case 'search_sites':
    {
        $find = $_POST['find'];
        $cond = "HEST_RAZONSOCIAL LIKE '%".$find."%' ";
        $json = $C_Json->getJsonSites($cond);
    }
    break;

    default:
    {
        
    }
    break;
}

echo $json;

?>

