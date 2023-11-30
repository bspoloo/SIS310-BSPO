<?php
$pronosticos = $_POST["pronosticos"];
$tipo_pronostico = $_POST["mi_select"];
$tipo_pronostico = $_POST["metodo"];
?>

<form class="form2" method="post" id="form_datosp">

  <table id="table_pronosticos">
    <tr>
      <th>Periodo</th>
      <th>Demanda</th>
    </tr>
    <?php
    for ($i = 0; $i < $pronosticos; $i++) { ?>
      <tr>
        <td type="text" placeholder="Periodo" name="periodo[]"><?php echo $i + 1 ?></td>
        <td><input type="number" name="demanda[]"></td>
      </tr>
    <?php }
    ?>

  </table>

  <?php
  // Agrega el campo adicional según la opción seleccionada
  if ($tipo_pronostico === 'regresionlineal') { ?>
    <label for="proporcion">Proporción:</label>
    <input type="text" name="proporcion">
  <?php } elseif ($tipo_pronostico === 'suavisadoexponencialsimple') { ?>
    <label for="alpha">Alpha:</label>
    <input type="text" name="alpha">
  <?php } ?>

  <input type="button" value="Calcular Pronósticos" onclick="calcularPronosticos()">
</form>
