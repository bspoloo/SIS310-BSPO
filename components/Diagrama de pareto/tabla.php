<?php
$products = $_GET["products"];
?>

<div class="product_table">
    <h1>Paso 2:</h1>
    <p>El segundo paso es obetner los ingresos de cada producto, para luego ordenarlos de mayor a menor de acuerdo al ingreso, para luego ir graficando:</p>
    <ol>
        <li><b>Barras:</b>Se los grafica de acuerdo al producto en el orden mayor a menor, donde cada altura representa la cantidad de ingresos que hizo ese preducto. </li>
        <li><b>Linea de porcentaje acumulativo:</b> esta se grafica de acuerdo al porcentaje acumulativo, en porden de mayor a menor</li>
        <li><b>Analisis se hace el analisis de que productos pueden estar por encima del 80%</b></li>
    </ol>
</div>

<div>
    <form method="post" id="form_datos">
        <table id="tabla_pareto">
            <tr>
                <th>Nombre</th>
                <th>Unidades</th>
                <th>Precio</th>
            </tr>
            <?php
            for ($i = 0; $i < $products; $i++) { ?>
                <tr>
                    <td><input type="text" placeholder="Nombre del producto <?php echo $i ?>" name="nombreProductos[]"></td>
                    <td><input type="number" name="unidades[]" min=0></td>
                    <td><input type="number" name="precios[]" min=0></td>
                </tr>
            <?php }
            ?>
        </table>
        <div class="align-content">
            <input type="button" value="Realizar diagrama" onclick="calcularDatos()">
        </div>

    </form>

    <div class="products_table">
        <div class="chartBox1">
          <canvas id="myChart">
              
          </canvas>
        </div>
</div>

</div>





<script src="../script/script2.js"></script>