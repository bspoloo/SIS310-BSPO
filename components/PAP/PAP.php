<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $meses = $meses = array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );
    ?>
    <form action="javascript:loadTablePAP('PAP/tabla.php')" method="get">
        <div>
            <div>Seleccione el mes inicial</div>
            <select name="mes1" id="mes1">
                <?php
                for($i =0; $i< count($meses); $i++){ ?>
                        <option value="<?php echo $i?>"><?php echo $meses[$i]?></option>
                <?php }  
                ?>
            </select>
        </div>
        <div>
            <div>Seleccione el mes final</div>
            <select name="mes2" id="mes2">
            <?php
                for($i =0; $i< count($meses); $i++){ ?>
                        <option value="<?php echo $i?>"><?php echo $meses[$i]?></option>
                <?php }  
                ?>
            </select>
        </div>
        
        <input type="submit" value="Enviar">
    </form>
    
    <br>
    <div id="demanda_table">
            
    </div>
    <br>
    <div id="PAP_table">
            
    </div>
    <br>
    <div id="div_PAP">

    </div>


    <script src="/script/script_PAP.js"></script>
</body>
</html>