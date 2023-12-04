<link rel="stylesheet" href="/navbars-offcanvas/navbars-offcanvas.css">
<link rel="stylesheet" href="/assets/dist/css/bootstrap.min.css">

<?php session_start();
include("conexion.php");


$email = $_POST["email"];
//echo $_POST["password"];
$password =sha1($_POST["password"]);

$sql = "SELECT id,email,password,nombre_completo from usuarios where email ='$email' AND password = '$password'";

//echo $sql;
$resultado = $con->query($sql);

//si existe ese usuario o admin, entonces se creara una sesion, caso contrario no
if($resultado->num_rows > 0){
    
    $fila = $resultado->fetch_assoc();
    //$_SESSION["nombre"] = $fila["nombre"];
    
    $_SESSION["id_usuario"] = $fila["id"];
    $_SESSION["email"] = $fila["email"];
    $_SESSION["password"] = $fila["password"];
    $_SESSION["nombre_completo"] = $fila["nombre_completo"];

    header("Location:index.php");
}else{ ?>
    <div>
        Usuario o contraseña incorrectos
    </div>

    <!--<meta http-equiv="refresh" content="10;url=form_loggin.html">-->
<?php }
?>