<?php
$pronosticos = $_GET["pronosticos"];
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
        <td><input type="number" name="demanda[]" required></td>
      </tr>
    <?php }
    ?>
  </table>
  <div>
    <label for="metodo">Seleccione el método:</label>
    <select name="metodo" id="metodo" onchange="CambiarPronostico()">
        <option value="promediomovilsimple">Promedio Móvil Simple</option>
        <option value="regresionlineal">Regresión Lineal</option>
        <option value="suavisadoexponencialsimple">Suavizado Exponencial Simple</option>
        <!-- <option value="suavisadoexponencialdoble">Suavizado Exponencial Doble</option>
        <option value="winters">Winters</option> -->
    </select>
</div>

<div id="opcionesPronostico" style="display:none;">
</div>
      
  <input type="button" value="Calcular Pronósticos" onclick="calcularPronosticos()">
  <input type="button" value="Limpiar" onclick="limpiarObjetoConst()">  

</form>