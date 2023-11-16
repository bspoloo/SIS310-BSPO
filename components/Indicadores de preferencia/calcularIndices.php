<?php
$nombresProducto =$_POST["nombresProducto"];
$ingresos =$_POST["ingresos"];
$costosProduccion =$_POST["costosProduccion"];
$costosFijos =$_POST["costosFijos"];
$costosAdministrativos =$_POST["costosAdministrativos"];

$indices = array();
$costosVariables = array();
$utilidades = array();
$rentabilidadVentas = array();
$indiceComercial =array();
$contribucionUtilidad =array();
$totales =array();


$indices['nombres']= $nombresProducto;
$indices['ingresos']= $ingresos;
$indices['costosProduccion']= $costosProduccion;
$indices['costosFijos']= $costosFijos;
$indices['costosAdministrativos']= $costosAdministrativos;

for($i=0; $i< count($nombresProducto); $i++){

    $costosVariables[$i]= $costosProduccion[$i] - $costosFijos[$i];
    $utilidades[$i]= $ingresos[$i] - $costosProduccion[$i] -$costosFijos[$i]- $costosAdministrativos[$i];
    $rentabilidadVentas[$i] = $utilidades[$i]/$ingresos[$i];
    $indiceComercial[$i] =$ingresos[$i]/array_sum($ingresos);
    $contribucionUtilidad[$i]=($ingresos[$i] - $costosVariables[$i])/ $ingresos[$i];
    
}
$indices['costosVariables']= $costosVariables;
$indices['utilidades']= $utilidades;
$indices['rentabilidadVentas']= $rentabilidadVentas;
$indices['indiceComercial']= $indiceComercial;
$indices['contribucionUtilidad']= $contribucionUtilidad;

$totales = [array_sum($ingresos),
            array_sum($costosProduccion),
            array_sum($costosFijos),
            array_sum($costosAdministrativos),
            array_sum($costosVariables),
            array_sum($utilidades),
            array_sum($rentabilidadVentas),
            array_sum($indiceComercial),
            array_sum($contribucionUtilidad) ];
$indices['totales']=$totales;

echo json_encode($indices, JSON_UNESCAPED_UNICODE);
?>