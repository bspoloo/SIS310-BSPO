<?php

$products = $_GET["products"];

?>
<div class="justify-text ">
    <h3>paso1:</h3>
    <h5>Ingresa los Nombres y costos necesarios de los <?php echo $products?> productos con los que cuentas, es necesario el nombre y costo que se pide en cada cuadro, esto servira para calcular:</h5>
    <h5>
        <ol>
            <li>Costos Variables</li>
            <li>Utilidades</li>
            <li>Rentabilidad de ventas</li>
            <li>Comerciabilidad del producto</li>
            <li>Contribucion a la utilidad</li>
        </ol>
    </h5>
</div>

<div class="products_table">

<form class="" method="post" id="form_datos">

    <table id="indices_preferencia">
        <tr>
            <th>Variables</th>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <th>
                    <input type="text" placeholder="Nombre del producto <?php echo ($i) ?>" name="nombresProducto[]" min=0 id="nombreProducto<?php echo $i ?>">
                </th>
            <?php }
            ?>
            <th>Total</th>
        </tr>
        <tr>
            <td>Ingresos</td>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <td>
                    <input type="number" placeholder="Ingresos del producto <?php echo ($i) ?>" name="ingresos[]" min=0 id="ingresos<?php echo $i ?>">
                </td>
            <?php }
            ?>
            <td>
                <div id="totalIngresos" name="total">Total de los ingresos</div>
            </td>
        </tr>

        <tr>
            <td>Costos de produccion</td>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <td>
                    <input type="number" placeholder="Costos de produccion del producto <?php echo ($i) ?>" name="costosProduccion[]" min=0 id="costosProduccion<?php echo $i ?>">
                </td>
            <?php }
            ?>
            <td>
                <div id="totalCostosProduccion" name="total">Total de los costos de produccion</div>
            </td>
        </tr>

        <tr>
            <td>Costos fijos</td>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <td>
                    <input type="number" placeholder="Costos fijos del producto <?php echo ($i) ?>" name="costosFijos[]" min=0 id="costosFijos<?php echo $i ?>">
                </td>
            <?php }
            ?>
            <td>
                <div id="totalCostosFijos" name="total">Total de los costos de fijos</div>
            </td>
        </tr>
        <tr>
            <td>Costos administrativos</td>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <td>
                    <input type="number" placeholder="Costos adnministrativos del producto <?php echo ($i) ?>" name="costosAdministrativos[]" min=0 id="costosAdministrativos<?php echo $i ?>">
                </td>
            <?php }
            ?>
            <td>
                <div id="totalCostosAdministrativos" name="total">Total de los costos administrativos</div>
            </td>
        </tr>
    </table>
    <br>
    <div class="align-content">
        <input type="button" value="Calcular indices" onclick="calcularIndices()">
    </div>

</form>
</div>

<?php
?>
<script src="../script/script1.js"></script>