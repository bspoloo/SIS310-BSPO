<?php
$pronosticos = $_GET["pronosticos"];
?>

<form class="form2" method="post" id="form_datosp">
<table id="table_pronosticos">
    <tr>
        <th>Periodo</th>
        <th>Demanda</th>
        <th>Pronosticos</th>
    </tr>
    <?php
    for($i=0;$i<$pronosticos;$i++){?>
        <tr>
            <td type="text" placeholder="Periodo" name="periodo[]"><?php echo $i+1 ?></td>
            <td><input type="number" name="demanda[]"></td>
            <td type="number" name="pronostico[]"></td>
        </tr>
    <?php }
    ?>
    
</table>
<input type="button" value="Calcular Pronosticos" onclick="calcularPronosticos()">
</form>