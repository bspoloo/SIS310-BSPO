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
    $rentVent = $_GET["rentVent"];
    $indeComer= $_GET["indeComer"];
    $contUti= $_GET["contUti"];
  
    $arrayNombres = explode(",", $nombres);
    $arrayRent = explode(",", $rentVent);
    $arrayInd = explode(",", $indeComer);
    $arrayCont = explode(",", $contUti);

    

    // foreach($arrayNombres as $i){
    //     echo $i;
    // }
    $maxRent =max($arrayRent);
    $maxInd =max($arrayInd);
    $maxCont =max($arrayCont);



    

    ?>
    <div class="">
        <h1>Costos Variables</h1>
        <p>Los costos variables son aquellos gastos empresariales que cambian en proporción
            directa con la producción o nivel de actividad de una empresa. Estos costos aumentan o
            disminuyen a medida que la cantidad de producción o ventas varía. Algunos ejemplos comunes de costos variables incluyen materiales directos
            utilizados en la fabricación de productos, mano de obra directa por
            hora (en ciertos casos), costos de envío que varían según la cantidad de
            productos enviados y comisiones de ventas basadas en el volumen de ventas.</p>
        <h3>¿como se calculan los costos variables?</h3>
        <p>Los costos variables se caluculan mediante la resta de los <b>costos de produccion- los costos fjios</b>, esto se hace para cada producto con sus respectivos costos</p>
        <h1>Utilidades</h1>
        <p>Las utilidades, también conocidas como ganancias o beneficios, son la diferencia positiva entre 
            los ingresos obtenidos por una empresa o individuo y los costos y gastos incurridos en la producción o venta de bienes o servicios.

            En el contexto empresarial, las utilidades se calculan restando los costos totales (que incluyen 
            tanto los costos variables como los costos fijos) de los ingresos totales. Si los ingresos son mayores que los costos, la 
            empresa genera una utilidad. Por otro lado, si los costos superan los ingresos, la empresa incurre en pérdidas.

            Las utilidades son una medida fundamental del éxito financiero de una empresa y se utilizan para 
            reinvertir en el negocio, distribuir entre los accionistas como dividendos, pagar deudas, realizar expansiones o mejorar las operaciones, entre otros fines.</p>

        <h3>¿como se calculan las utilidades de cada producto?</h3>
        <p>Las utilidades se calculan mediante la resta de los<b>Ingresos-Costos(suma total de cada costo, sin incluir los costos variables)</b>, esto haciendolo para cada producto.</p>

        <h1>Rentabilidad de ventas</h1>
        <p>
        La rentabilidad de ventas, también conocida como margen de beneficio operativo o margen de beneficio sobre las ventas, es un indicador financiero que muestra la
         eficiencia con la que una empresa genera ganancias a partir de sus ventas. Se calcula dividiendo el beneficio operativo (o utilidad operativa) entre los ingresos totales por ventas y se expresa como un porcentaje.

        El beneficio operativo se obtiene restando los costos operativos (costos de producción, gastos de ventas, gastos administrativos, etc.) de los ingresos totales de 
        la empresa antes de impuestos e intereses.

        Este indicador es crucial para evaluar la eficiencia con la que una empresa convierte sus ventas en ganancias. Una rentabilidad de ventas más alta indica que la 
        empresa es más eficiente en la generación de beneficios a partir de sus ventas, lo que puede ser un signo de una gestión sólida y procesos eficientes. Sin embargo, 
        este valor puede variar significativamente entre diferentes industrias y empresas, por lo que es importante comparar la rentabilidad de ventas dentro de la misma industria 
        o sector para una evaluación más precisa.</p>
            
        <h3>¿como se calcula la rentabilidad de ventas?</h3>
        <p>se calcula mediante la formula basica <b>Utilidad/Ingresos*100%(de cada producto)</b></p>
        <h3>analisis:</h3>
        <p>Si tomando en cuenta que la rentabilidad de ventas son las utilidades obtenidas por la venta de ese producto, el producto <b><?php echo $arrayNombres[array_search($maxRent, $arrayRent)];?></b>
        cuenta con <b><?php echo $arrayRent[array_search($maxRent, $arrayRent)]?>%</b> de rentabilidad, por lo tanto de cada ingreso el <b><?php echo $arrayRent[array_search($maxRent, $arrayRent)]?>%</b> es la utilidad</p>
        
        <h1>Comerciabilidad del producto</h1>
        <p>
        La comerciabilidad del producto se refiere a la capacidad de un producto para ser vendido o comercializado con éxito en el mercado. 
        Se trata de evaluar qué tan atractivo y deseable es un producto para los consumidores, así como la capacidad de la empresa para venderlo y obtener ganancias, o en 
        otros terminos, seria aquel producto que genera mas ingresos</p>
            
        <h3>¿como se calcula la comerciabilidad del producto?</h3>
        <p>este se calcula a travez de los <b>Ingresos/Total de ingresos</b></p>
        <h3>analisis:</h3>
        <p>tomando en cuenta que la comerciabilidad del producto es el indice comercial donde es aquel que genera mayor parte de los ingresos, 
        por lo tanto el producto <b><?php echo $arrayNombres[array_search($maxInd, $arrayInd)];?></b> con un indice comercial de <b><?php echo $arrayInd[array_search($maxInd, $arrayInd)];?>%</b>,
        como consecuencia si se busca mejorar los ingresos, es mas conveniente aumentar la produccion del producto <b><?php echo $arrayNombres[array_search($maxInd, $arrayInd)];?></b>
        </p>

        <h1>Contribucion a la utilidad</h1>
        <p>
        La contribución a la utilidad es un concepto financiero que representa la cantidad de ingresos que 
        contribuye a cubrir los costos fijos y a generar utilidades después de cubrir los costos variables de una empresa.
        </p>
        <h3>¿como se calcula la contribucion a la utilidad?</h3>
        <p>tiene la formula basica <b>(Ingresos-costos variables)/ingresos</b> Esta métrica es valiosa porque muestra cuánto de cada venta contribuye directamente a la cobertura 
        de los costos fijos y, posteriormente, a generar utilidades. Cuanto mayor sea la contribución a la utilidad por cada unidad vendida, mayor será la capacidad de la empresa para cubrir sus costos fijos y generar ganancias.
        Es importante tener en cuenta que la contribución a la utilidad no incluye los costos fijos, como el alquiler, los salarios del 
        personal administrativo, los costos de depreciación, entre otros. Estos costos fijos deben ser cubiertos por la contribución a la utilidad después de que se hayan pagado los costos variables.</p>
        <h3>analisis:</h3>

        <p>tomando en cuenta que la contribucion a la utilidad, es el sobrante con respecto a los costos variables, este exeso debe ser suficiente para curbir los costos fijos de las utilidades,
            el producto <b><?php echo $arrayNombres[array_search($maxCont, $arrayCont)];?></b> es el que mas contribuye a cubrir el exceso con un margen de contribucion de <b><?php echo $arrayCont[array_search($maxCont, $arrayCont)];?>%</b>
        </p>

    </div>

</body>

</html>