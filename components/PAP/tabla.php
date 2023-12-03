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
$dias_por_mes = array(
    31, // Enero
    28, // Febrero (en años no bisiestos)
    31, // Marzo
    30, // Abril
    31, // Mayo
    30, // Junio
    31, // Julio
    31, // Agosto
    30, // Septiembre
    31, // Octubre
    30, // Noviembre
    31  // Diciembre
);


$mes1 = $_GET["mes1"];
$mes2 = $_GET["mes2"];

$mesesTotal = array();

// echo $mes1 . " Y " . $mes2;

?> 


<form  action="javascript:calcularPAP()" class="" id="form_demandaPAP">

<table>
    <div>Datos necesarios</div>
    <tr>
        <th>Dato</th>
        <th>Valor</th>
    </tr>
    <tr>
        <td><b>trabajdores iniciales</b></td>
        <td><input type="number" name="trabIniciales" id="trabIniciales" value=0 min=0 step="any" required></td>
    </tr>
    <tr>
        <td><b>Horas para producir una unidad</b></td>
        <td><input type="number" name="horasUnidad" id="horasUnidad" value=0 min=0.000001 step="any"  max=24 required></td>
    </tr>
    <tr>
        <td><b>Horas trabajadas al dia</b></td>
        <td><input type="number" name="horasDia" id="horasDia" value=0 min=0 step="any" max=24 required></td>
    </tr>
    <tr>
        <td><b>Unidades producidas en promedio por trabajador</b></td>
        <td><input type="number" name="unidadesProducidas" id="unidadesProducidas" value=0 step="any" min=0 required></td>
    </tr>
</table>
<br>
<table>
    <div>Costos necesarios</div>
    <tr>
        <th>Dato</th>
        <th>Valor</th>
    </tr>

    <tr>
        <td><b>Costo unitario de produccion</b></td>
        <td><input type="number" name="costoProduccion" id="costoProduccion" value=0 min=0 step="any" required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de contratacion</b></td>
        <td><input type="number" name="costoContratacion" id="costoContratacion" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de despido</b></td>
        <td><input type="number" name="costoDespido" id="costoDespido" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de hora extra</b></td>
        <td><input type="number" name="costoHoraExtra" id="costoHoraExtra" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de subcontratacion</b></td>
        <td><input type="number" name="costoSubcontratacion" id="costoSubcontratacion" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de almacenamiento</b></td>
        <td><input type="number" name="costoAlmacenamiento" id="costoAlmacenamiento" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo unitario de rotura</b></td>
        <td><input type="number" name="costoRotura" id="costoRotura" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo de mano de obra</b></td>
        <td><input type="number" name="costoMO" id="costoMO" value=0 step="any" min=0 required></td>
    </tr>
    <tr>
        <td><b>Costo de mano de obra por hora</b></td>
        <td><input type="number" name="costoMOhr" id="costoMOhr" value=0 step="any" min=0 required></td>
    </tr>
</table>
<br>
<table>
    <tr>
        <th>Mes</th>
        <?php

        for ($i = $mes1; $i <= $mes2; $i++) { ?>
            <th><?php echo $meses[$i] ?></th>
        <?php }
        ?>
    </tr>
    <tr>
        <td>Demanda esperada</td>
        <?php
        for ($i = $mes1; $i <= $mes2; $i++) { ?>

            <td><input type="number" name="demandas[]" id="demanda<?php echo $i?>" min=1 required></td>

        <?php }
        ?>
    </tr>
    <tr>
        <td>Dias de produccion</td>
        <?php
        for ($i = $mes1; $i <= $mes2; $i++) { ?>

            <td><input type="number" name="dias[]" id="dia<?php echo $i?>"  min=1 max=<?php echo $dias_por_mes[$i]?> required></td>
            <input type="hidden" name="mesesTotal[]" value="<?php echo $meses[$i] ?>">
        <?php }
        ?>
    </tr>
</table> 

<div class="opciones_PAP">

<label for="alternativasPAP">Selccione una alternativa</label>
    <select name="alternativasPAP" id="alternativasPAP">
        <option value=1>Inventario 0</option>
        <option value=2>Fuerza de trabajo constante</option>s
        <option value=3>Fuerza de trabajo mínima y subcontratación</option>
        <option value=4>Contratar y despedir de acuerdo a la necesidad mensual exacta</option>
        <option value=5>Fuerza de trabajo constante con horas extras</option>
    </select>
   
    <input type="submit" value="Generar"> 

</div>

</form>



<script src="/script/script_PAP.js"></script>

<?php


?>