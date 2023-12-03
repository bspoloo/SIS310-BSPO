<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

<div class="context">
    <h1>Plan agregado de produccion</h1>
    <center><img src="../images/plan-de-produccion-agregado.jpg" alt="plan agragado de produccion"></center>
    <br>
    <p>
    El Plan Agregado de Producción es la estrategia que una 
    empresa adopta antes de comenzar los procesos de fabricación de productos manufacturados. En este plan se determinan cuáles son los elementos necesarios (recursos humanos o materias primas) para producir la mercancía que se venderá a mayoristas o clientes finales.

    La visión y control global de cada uno de los eslabones que 
    intervienen en la cadena productiva permite disponer de una gestión 
    eficiente y total sobre los recursos del negocio. Esa perspectiva la aporta un software ERP con un módulo de producción que sea capaz de organizar todos los recursos productivos.
    </p>
    <h1>¿Qué es el Plan Agregado de Producción?</h1>
    <p>También denominado PAP por sus siglas en español, el Plan Agregado de Producción es el conjunto de estrategias que una planta de fabricación lleva a cabo para la elaboración del producto manufacturado. Tiene como misión y principal objetivo organizar todos los recursos de producción para hacer frente a la demanda de los clientes y para cumplir con las fechas de plazo de entrega de los pedidos.</p>

    <p>Se define como 'plan agregado' porque también contempla las categorías o familias de los productos. ¿Y qué es una familia? Es un grupo de productos que poseen unas características en común. Por ejemplo, artículos del mismo color, funcionalidad, etc.</p>

    <p>Esta planificación es a medio plazo, normalmente en torno a periodos entre seis y 18 meses. Para las gestiones a corto plazo entra en juego el Plan Maestro de Producción o MPS, según sus siglas en inglés Master Production Schedule. Vamos a ver cuáles son las diferencias entre ambos.</p>

    <h2>Plan Agregado vs. Plan Maestro de Producción</h2>
    <p>Una vez definido el PAP, ¿qué diferencia existe con el PMP o MPS? La principal diferencia radica en el periodo de planificación que abarcan. El plan agregado contempla periodos de entre medio año y 18 meses mientras que el plan maestro se centra en el corto plazo.</p>

    <p>La diferencia entre el plan agregado y el plan maestro de producción es que el segundo es sólo una división o parte en la que se puede desglosar el primero. El agregado plantea la producción a meses vista, normalmente a partir de los seis, mientras que el maestro se aplica a semanas o incluso días.</p>

    <p>En estos casos en los que el PMP se elabora para un grupo reducido de días es debido a que un elemento externo produzca un aumento o reducción considerable de la demanda. En este supuesto, hay que elaborar un plan maestro concreto para esta situación.</p>

    <p>Por ejemplo, una pastelería o fábrica de repostería durante el 6 de enero (roscón de reyes) y 1 de noviembre (buñuelos). En estas dos jornadas, todos los negocios del sector repostero tendrán que elaborar un PMP para ese pico de demanda provocado por una fiesta/costumbre nacional.</p>

    <h3>¿Cómo hacer el Plan Agregado en una empresa de fabricación de 1 a 12 meses?</h3>
    
    <p>para hacer un plan agregado de produccion lo primero que debe de tenerse en cuenta:</p>
    <ol>
        <li>Para que meses se desea calcular este plan.</li>
        <li>Tener las horas de trabajo y trabajadores con los que cuenta la empresa.</li>
        <li>Tener los costos necesariso para realizar este plan.</li>
    </ol>
    
    <p>A partir de los datos realizar</p>
    <ul>
        <li>Organizar los datos en una tabla</li>
        <li>Realizar los calculos necesarios para calcular la cantidad de mano de obra y en su caso(inventario 0, fuerza de trabajo constante ..etc).</li>
        <li>Realizar los calculos de los costos para cada caso.</li>
        <li>Realizar una comparacion para decidir que alternativa usar.</li>
    </ul>

    <h2>Pasos a seguir para realizar el Plan agregado de produccion:</h2>
    <br>
    <h3>Paso 1: Ingresa de que mes hasta que mes deseas calcular:</h3>
</div>

    <?php
    $meses = $meses = array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    ?>
    <div class="centered-content">

        <form class="form3" action="javascript:loadTablePAP('PAP/tabla.php')" method="get">
            <div>
                <div>Seleccione el mes inicial</div>
                <div>
                <select name="mes1" id="mes1">
                    <?php
                    for ($i = 0; $i < count($meses); $i++) { ?>
                        <option value=<?php echo $i ?>><?php echo $meses[$i] ?></option>
                    <?php }
                    ?>
                </select>
                </div>
                
            </div>
            <div>
                <div>Seleccione el mes final</div>
                <div>
                 <select name="mes2" id="mes2">
                    <?php
                    for ($i = 0; $i < count($meses); $i++) { ?>
                        <option value=<?php echo $i ?>><?php echo $meses[$i] ?></option>
                    <?php }
                    ?>
                </select>   
                </div>
                
            </div>
            <input type="submit" value="Enviar">
        </form>

    </div>
    <br>
    <div class="products_table" id="demanda_table">

    </div>
    <br>
    <div class="products_table" id="div_PAP">

    </div>

    <div class="informe" id="informe_PAP">
        
    </div>


    <script src="/script/script_PAP.js"></script>
</body>

</html>