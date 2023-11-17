<?php
$nombreProductos = $_POST["nombreProductos"];
$unidades = $_POST["unidades"];
$precios = $_POST["precios"];

$datos=array();
$ingresos = array();
$porcentaje=array();
$ingresoAcumulativo=array();
$porcentajeAcumulativo=array();


for($i=0; $i <count($nombreProductos);$i++){
    $ingresos[$i]= $unidades[$i]*$precios[$i];
}

//ordena los arrays de acuerdo a los ingresos xd
array_multisort($ingresos, SORT_DESC, $nombreProductos, $unidades, $precios);

$datos['ingresos'] = $ingresos;
$datos['nombres'] = $nombreProductos;
$datos['unidades'] = $unidades;
$datos['precios'] = $precios;

for($j=0; $j< count($nombreProductos); $j++){

    $porcentaje[$j] = ($ingresos[$j]/array_sum($ingresos))*100;
    if($j < 1){
        $porcentajeAcumulativo[$j]= $porcentaje[$j];
        $ingresoAcumulativo[$j]=$ingresos[$j];
    }
    else{
        $porcentajeAcumulativo[$j]= $porcentaje[$j] + $porcentajeAcumulativo[$j-1];
        $ingresoAcumulativo[$j]=$ingresos[$j]+$ingresoAcumulativo[$j-1];
    }

}


$datos['porcentaje']=$porcentaje;
$datos['ingresoAcumulativo'] = $ingresoAcumulativo;
$datos['porcentajeAcumulativo']=$porcentajeAcumulativo;
$datos['totalesIngresos']= array_sum($ingresos);
$datos['totalesPorcentaje']= array_sum($porcentaje);


echo json_encode($datos, JSON_UNESCAPED_UNICODE);
?>