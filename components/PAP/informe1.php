<?php
session_start();

$titulo = "zxsd";
$trabajadores = '';

switch ($_SESSION["datos"]) {
    case 1:
        $titulo = "Inventario 0";
        $trabajadores = "los trabajadores se obtienen de acuerdo a la demanda por dia de cada mes, esto para satisfacer la demanda en esos meses.";
        break;
    case 2:
        $titulo = "Fuerza de trabajo constante";
        $trabajadores = "<p>los trabajadores se obtienen a traves de la formula <b>(total de la demanda)/(total de unidad por trabajador)</b></p>
        <p>Los cuales serian ".ceil(array_sum($_SESSION["pap"]["demanda"])/array_sum($_SESSION["pap"]["unidadTrabajador"]))." trabajadores constantes para cada mes.</p>";
        break;
    case 3:
        $titulo = "Fuerza de trabajo minima con subcontratacion";
        break;
    case 4:
        $titulo = "Contratar y despedir de a acuerdo a la necesidad mensual exacta";
        break;
    case 5:
        $titulo = "Fuerza de trabajo constante con horas extra";
        break;
}


// echo json_encode($general, JSON_UNESCAPED_UNICODE);
?>

<h1><?php echo $titulo ?></h1>

<h5>Para las horas en promedio producidas por trabajador</h5>
<p>Primero se hace la divicion entre las <b>Horas trabajadas al dia y horas producicas por unidad </b>
    lo cual nos da unas <b><?php echo $_SESSION['uniProd'] ?></b> en general</p>
<h5>Para la unidad por trabajador</h5>
<p>Se refiere a la <b>cantidad de undidades que produce cada trabajador por mes</b>
<p>
    <b>lo cual nos da para cada mes:</b></p>
</p>
<table>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td><?php echo $_SESSION['pap']['unidadTrabajador'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>


<h5>Para la Demanda por dia</h5>
<p>Se refiere a la <b>cantidad de unidades que se proucien en ese dia por mes</b>
<p>
    <b>lo cual nos da para cada mes:</b>
</p>
<table>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td><?php echo $_SESSION['pap']['demandaDia'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>

<h5>Para Trabajadores requeridos</h5>
<p>Se refiere a la <b>cantidad trabajadores necesarios para satisfacer la demanda en ese mes</b><p>

    <p><?php echo $trabajadores?></p>

    <b>lo cual nos da  trabajadores necesarios para cada mes para cada mes:</b></p>
</p>
<table>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td><?php echo $_SESSION['pap']['trabRequeridos'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>

<h5>Para Trabajadores disponibles Contratados y despedidos</h5>
<p>Se refiere a la <b>cantidad trabajadores necesarios para satisfacer la demanda en ese mes:</b><p>

<ol>
    <li><b>Trabajadores disponibles:</b> se refiere a las de trabajadores con los que se cuenta en el mes actual</li>
    <li><b>Trabajadores Contratados:</b> se refiere a la cantidad de trabajadores que deben ser contratados para satisfacer los trabajadores necesarios en ese mes</li>
    <li><b>Trabajadores despedidos:</b> se refiere a la cantida de los trabajadores despedidos en ese mes, esto para satisfacer los trabajadores requerido</li>
    <li><b>Trabajadores Empleados:</b> se refiere a los trabajadores empleados en cada mes, simplemente es igual a los trabajores requeridos</li>

</ol>
    <b>lo cual nos da lo siguiente:</b></p>
</p>
<table>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class="bg-blue"><?php echo $_SESSION['pap']['trabRequeridos'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class="bg-yellow"><?php echo $_SESSION['pap']['trabDisponibles'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class="bg-green"><?php echo $_SESSION['pap']['trabContratados'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class="bg-red"><?php echo $_SESSION['pap']['trabDespedidos'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class="bg-orange"><?php echo $_SESSION['pap']['trabEmpleados'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>

<h5>Para Produccion en horario normal, Horas normal necesarias, horas en horario normal, y horas extra necesarias</h5>
<p>los tiempos que llevan a producir una cierta cantidad<p>

<ol>
    <li><b>Produccion en horario normal:</b> se refiere a las unidades producidas en ese mes..</li>
    <li><b>Horas en horario normal necesarias:</b> Se refiere a la cantidad de horas que se necesitan para producir una cantidad en un cierto tiempo <b>(Demanada)*(hora para producir ese producto).</b></li>
    <li><b>Horas en horario normal:</b> se refiere al tiempo que se necesita para producir las unidades producidas en ese mes.</li>
    <li><b>Horas extra:</b> Aqui se refier a, si la cantidad de horas necesarias es superior a las horas normal necesarias, entonces se necesitarian esas horas extra para satisfacer el tiempo de produccion de la demanda esperada.</li>

</ol>
    <b>lo cual nos da lo siguiente:</b></p>
</p>
<table>
    <tr>
        <th>Meses</th>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Produccion en horario normal</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['produccionHrNormal'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Horas en horario normal necesarias</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['hrNormalNecesaria'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Horas en horario normal</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['horaHorarioNormal'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Horas extra</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['horaExtraNecesaria'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>

<h5>Para unidades producidas, inventario, unidades subcontratadas</h5>
<p>los tiempos que llevan a producir una cierta cantidad<p>

<ol>
    <li><b>Unidades producidas:</b> se refiere a las unidades producidas en total por de la unidad por trabajador en los dias de produccion de un mes en especicifico <b>Dias * unidad/trabajador</b></li>
    <li><b>Inventario:</b> Se refiere a cuanto se pued cubrir en un un mes mas el inventario anterior a un mes<b>Unidades producidas - Demanda + inventario anterior</b></li>
    <li><b>Unidades subcontratadas:</b>Esto es parte de las alternativas, puede o no ser elegida, se refiere a que si en el inventario hay retraso, se contrate estos productos para alcanzar la demanda en esos meses.</li>


</ol>
    <b>lo cual nos da lo siguiente:</b></p>
</p>
<table>
    <tr>
        <th>Meses</th>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Unidades producidas</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['unidadesProducidas'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Inventario</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['inventario'][$i] ?></td>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Unidades Subcontratadas</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['unidadesProducidas'][$i] ?></td>
        <?php }
        ?>
    </tr>
</table>



<h5>Para Los costos, aqui se calculan todos los costos para contratacion, despido, Mo hr normal, horas extra, subcontratacion, almacenamiento, rotura y unidades producidads</h5>
<p>El calculo para estos costos es simplemente multiplicar lo mencionado anteriormente por sus costos respectivos</p>
<b>lo cual nos da lo siguiente:</b></p>

<table>
    <tr>
        <th>Meses</th>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <th><?php echo $_SESSION['pap']['meses'][$i] ?></th>
        <?php }
        ?>
        <th>Total</th>
    </tr>
    <tr>
        <td>Costo de contratacion</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoContratacion'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoContratacion']?></td>
    </tr>
    <tr>
        <td>Costo de despido</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoDespido'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoDespido']?></td>
    </tr>
    <tr>
        <td>Costo MO hora normal</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoMOhrNormal'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalcostoMOhrNormal'] ?></td>
    </tr>
    <tr>
        <td>Costo de horas extra</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoHoraExtra'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoHoraExtra']?></td>
    </tr>
    <tr>
        <td>Costo de subcontratacion</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoSubcontratacion'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoSubcontratacion']?></td>
    </tr>
    <tr>
        <td>Costo de almacenamiento</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoAlmacenamiento'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoAlmacenamiento'] ?></td>

    </tr>
    <tr>
        <td>Costo de rotura o retraso</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoRotura'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoRotura'] ?></td>
    </tr>
    <tr>
        <td>Costo de unidades producidas</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costoUnidadProducida'][$i] ?></td>
        <?php }
        ?>
        <td><?php echo $_SESSION['pap']['totales']['totalCostoUnidadProducida'] ?></td>
    </tr>

    <tr>
        <td>Total</td>
        <?php
        for ($i = 0; $i < count($_SESSION['pap']['meses']); $i++) { ?>
            <td class=""><?php echo $_SESSION['pap']['costosTotales'][$i] ?></td>
        <?php }
        ?>
        <td class="bg-green"><?php echo $_SESSION['pap']['totales']['totalGeneral']?>$</td>
    </tr>
</table>
<h4>Por lo tanto:</h4>
<p>haciendo los calculos se llega a la conclucion de que la altrnativa de <b><?php echo $titulo?></b> genera costos de <b><?php  echo $_SESSION['pap']['totales']['totalGeneral'] ?>$</b></p>
