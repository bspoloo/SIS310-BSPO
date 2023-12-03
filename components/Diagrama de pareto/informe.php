<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $nombres = $_GET["nombres"];
    $porcentaje = $_GET["porcentaje"];
    $porcentajeAc = $_GET["porcentajeAc"];

    $arrayNombres = explode(",", $nombres);
    $arrayPorc = explode(",", $porcentaje);
    $arrayPorcAc = explode(",", $porcentajeAc);

    $cercano = encontrarMasCercano($arrayPorcAc, 80);

    $posicion =  array_search($cercano, $arrayPorcAc);
    // echo "el valor mas cercano es:".$cercano;



    function encontrarMasCercano($array, $valorObjetivo)
    {
        $valorMasCercano = null;
        $distanciaMasCercana = INF;

        foreach ($array as $elemento) {
            $distanciaActual = abs($elemento - $valorObjetivo); // Calcular la distancia del elemento al valor objetivo

            if ($distanciaActual < $distanciaMasCercana) {
                $distanciaMasCercana = $distanciaActual;
                $valorMasCercano = $elemento;
            }
        }

        return $valorMasCercano;
    }


    ?>
    <div class="">
        <h1>Analisis</h1>
        <p>respetando el <b>80/20 donde 80% de los efectos provienen del 20% de las causas, el caso de los sistemas de procesos y porduccion 
            este concepto seria un poco diferente,
                aproximadamente el 80% de los resultados proviene del 20% de las causas.</b>
        </p>
        <p>
            el producto mas cercano al 80% de todo el porcentaje acumulativo es <b><?php echo $arrayNombres[$posicion] ?></b>, lo cual quiere decir que debemos priorizar ese producto y
             sus productos por encima de el los cuales serian:
        </p>

        <ul>
            <?php
            for($i=0; $i<=$posicion; $i++){?>
                <li><b><?php echo $arrayNombres[$i] ?></b> con un porcentaje acumulativo de <?php echo $arrayPorcAc[$i]?>%</li>
            <?php }
            ?>
        </ul>
        <p>ya que esos productos son productos con los cuales debemos concentrar nuestros recursos a esos productos ya que son nuestros recursos mas relevantes</p>

    </div>



</body>

</html>