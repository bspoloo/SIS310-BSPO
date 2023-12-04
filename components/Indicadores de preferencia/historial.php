<?php
include("../conexion.php");

$sql = "SELECT id,costo_variables FROM indices_preferencia";

$resultado = $con->query($sql);
$miArray = array();

// foreach($miArray as $i){
//     echo $i;
// }

if ($resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        $datosSerializados = $row["costo_variables"];
        $miArray[] = unserialize($datosSerializados);
     }


} else {
    echo "No se encontraron resultados";
}
// Cerrar la conexión a la base de datos
$con->close();

?>

<table>
    <?php
    for($i=0; $i<count($miArray); $i++){?>
        <tr>
            <?php
            foreach($miArray[$i] as $valor){?>
                <td><?php echo $valor?></td>
            <?php }
            ?>
        </tr>
    <?php }
    ?>
</table>