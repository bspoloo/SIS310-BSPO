<?php
$products = $_GET["products"];
?>

<form method="post" id="form_datos">
<table id="tabla_pareto">
    <tr>
        <th>Nombre</th>
        <th>Unidades</th>
        <th>Precio</th>
    </tr>
    <?php
    for($i=0;$i<$products;$i++){?>
        <tr>
            <td><input type="text" placeholder="Nombre del producto <?php echo $i?>" name="nombreProductos[]"></td>
            <td><input type="number" name="unidades[]"></td>
            <td><input type="number" name="precios[]"></td>
        </tr>
    <?php }
    ?>
</table>
<input type="button" value="Enviar" onclick="calcularDatos()">
</form>

<script src="../script/script2.js"></script>
