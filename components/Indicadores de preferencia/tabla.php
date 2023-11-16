<?php

$products = $_GET["products"];

?>
<form class="form2" method="post" id="form_datos">
<table border="1" id="indices_preferencia">
    <tr>
        <th>Variables</th>
        <?php
        for($i =0; $i<$products; $i++){?>
            <th>
                <input type="text" placeholder="Nombre del producto<?php echo ($i)?>" name="nombresProducto[]" id="nombreProducto<?php echo $i?>">
            </th>
        <?php }
        ?>
        <th>Total</th>
    </tr>
    <tr>
            <td>Ingresos</td>
            <?php
            for($i =0; $i<$products; $i++){?>
                <td>
                    <input type="number" placeholder="Ingresos del producto<?php echo ($i)?>" name="ingresos[]" id="ingresos<?php echo $i?>">
                </td>
            <?php }
            ?>
            <td ><div id="totalIngresos" name="total">Total de los ingresos</div></td>
    </tr>
    <tr>
            <td>Costos de produccion</td>
            <?php
            for($i =0; $i<$products; $i++){?>
                <td>
                    <input type="number" placeholder="Costos de produccion del producto<?php echo ($i)?>" name="costosProduccion[]" id="costosProduccion<?php echo $i?>">
                </td>
            <?php }
            ?>
            <td ><div id="totalCostosProduccion" name="total">Total de los costos de produccion</div></td>
    </tr>
    <tr>
            <td>Costos fijos</td>
            <?php
            for($i =0; $i<$products; $i++){?>
                <td>
                    <input type="number" placeholder="Costos fijos del producto<?php echo ($i)?>" name="costosFijos[]" id="costosFijos<?php echo $i?>">
                </td>
            <?php }
            ?>
            <td ><div id="totalCostosFijos" name="total">Total de los costos de fijos</div></td>
    </tr>
    <tr>
            <td>Costos administrativos</td>
            <?php
            for($i =0; $i<$products; $i++){?>
                <td>
                    <input type="number" placeholder="Costos adnministrativos del producto<?php echo ($i)?>" name="costosAdministrativos[]" id="costosAdministrativos<?php echo $i?>">
                </td>
            <?php }
            ?>
            <td><div id="totalCostosAdministrativos" name="total">Total de los costos administrativos</div></td>
    </tr>
</table>
<input type="button" value="Calcular indices" onclick="calcularIndices()">
</form>

<?php
?>
    <script src="../script/script1.js"></script>
