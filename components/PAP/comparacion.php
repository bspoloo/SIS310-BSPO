<?php
session_start();

$alternativa = ["Inventario 0", "Fuerza de trabajo constante","Fuerza de trabjo minima y subcontratacion", "Contratar y despedir de acuerdo a la mensualidad exacta","Fuerza de trabajo constante con con horas extra"];
$total = array();

for($i=0; $i<5; $i++){
    $total[$i] = $_SESSION["alternativas"][$i]["totales"]["totalGeneral"] ; 
}

$pos =array_search(min($total),$total); ;


?>
<h3>Se presenta una comparacion general de las 5 alternativas:</h3>
<ol>
    <li>Inventario 0</li>
    <li>Fuerza de trabajo constante</li>
    <li>Fuerza de trabjo minima y subcontratacion</li>
    <li>Contratar y despedir de acuerdo a la mensualidad exacta</li>
    <li>Fuerza de trabajo constante con con horas extra</li>
</ol>
<table>
    <tr>
        <th>alternativa</th>
        <th>Costo total</th>
    </tr>
    <tr>
        <td>Inventario 0</td>
        <td>
            <?php echo $total[0]?>$
        </td>
    </tr>
    <tr>
        <td>Fuerza de trabajo constante</td>
        <td>
            <?php echo $total[1]?>$
        </td>
    </tr>
    <tr>
        <td>Fuerza de trabjo minima y subcontratacion</td>
        <td>
            <?php echo $total[2] ?>$
        </td>
    </tr>
    <tr>
        <td>Contratar y despedir de acuerdo a la mensualidad exacta</td>
        <td>
            <?php echo $total[3]?>$
        </td>
    </tr>
    <tr>
        <td>Fuerza de trabajo constante con con horas extra</td>
        <td>
            <?php echo $total[4]?>$
        </td>
    </tr>
</table>

<h4>Por lo tanto:</h4>
<p>la mejor alternativa es <b><?php echo $alternativa[$pos]?></b> que genera menores costos de <b><?php echo $total[$pos]?>$</b></p>