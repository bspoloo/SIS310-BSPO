<?php

session_start();

$mesesTotal = $_POST["mesesTotal"];

$trabIniciales = $_POST["trabIniciales"];
$horasUnidad = $_POST["horasUnidad"];
$horasDia = $_POST["horasDia"];
$unidadesProducidas = $_POST["unidadesProducidas"];


$costoProduccion = $_POST["costoProduccion"];
$costoContratacion = $_POST["costoContratacion"];
$costoDespido = $_POST["costoDespido"];
$costoHoraExtra = $_POST["costoHoraExtra"];
$costoSubcontratacion = $_POST["costoSubcontratacion"];
$costoAlmacenamiento = $_POST["costoAlmacenamiento"];
$costoRotura = $_POST["costoRotura"];
$costoMO = $_POST["costoMO"];
$costoMOhr = $_POST["costoMOhr"];

$demandas = $_POST["demandas"];
$dias = $_POST["dias"];


$alternativa = $_POST["alternativasPAP"];

class PAP
{
    public $alternativa;
    public $mesesTotal;
    public $demandas;
    public $dias;
    public $trabIniciales;
    public $horasUnidad;
    public $horasDia;
    public $unidadesProducidas;
    public $costoProduccion;
    public $costoContratacion;
    public $costoDespido;
    public $costoHoraExtra;
    public $costoSubcontratacion;
    public $costoAlmacenamiento;
    public $costoRotura;
    public $costoMOhr;

    public function __construct(
        $alternativa,
        $mesesTotal,
        $demandas,
        $dias,
        $trabIniciales,
        $horasUnidad,
        $horasDia,
        $unidadesProducidas,
        $costoProduccion,
        $costoContratacion,
        $costoDespido,
        $costoHoraExtra,
        $costoSubcontratacion,
        $costoAlmacenamiento,
        $costoRotura,
        $costoMOhr
    ) {
        $this->alternativa = $alternativa;
        $this->mesesTotal = $mesesTotal;
        $this->demandas = $demandas;
        $this->dias = $dias;
        $this->trabIniciales = $trabIniciales;
        $this->horasUnidad = $horasUnidad;
        $this->horasDia = $horasDia;
        $this->unidadesProducidas = $unidadesProducidas;
        $this->costoProduccion = $costoProduccion;
        $this->costoContratacion = $costoContratacion;
        $this->costoDespido = $costoDespido;
        $this->costoHoraExtra = $costoHoraExtra;
        $this->costoSubcontratacion = $costoSubcontratacion;
        $this->costoAlmacenamiento = $costoAlmacenamiento;
        $this->costoRotura = $costoRotura;;
        $this->costoMOhr = $costoMOhr;
    }

    function datos()
    {
        $uniTrab = array();
        $demandaDia = array();
        $demandaUnid = array();
        $trabReq = array();
        $trabDispo = array($this->trabIniciales);
        $traContr = array();
        $trabDepe = array();
        $prodHrNor = array();
        $hrNormal = array();
        $hrNormNe = array();
        $hrHorarioNormal = array();
        $hrExtraNe = array();
        $costoExt = array();
        $uniSub = array();
        $costoSub = array();
        $uniProd = array();
        $inventario = array(0);
        $costoAlm = array();
        $costoRet = array();
        $costoTotal = array();
        $costoMONr = array();
        $trabEmp = array();
        $inventarioAct = array();
        //para el trabajo de fuerza constante


        switch ($this->alternativa) {
            case 1:
                for ($i = 0; $i < count($this->demandas); $i++) {
                    $uniTrab[] = round($this->dias[$i] * $this->unidadesProducidas, 2);
                    $demandaDia[] = round($this->demandas[$i] / $this->dias[$i]);
                    $demandaUnid[] = round($this->demandas[$i] / $uniTrab[$i], 2);
                    $trabReq[] = ceil($demandaUnid[$i]);
                }
                break;
            case 2:
                for ($i = 0; $i < count($this->demandas); $i++) {
                    $uniTrab[] = round($this->dias[$i] * $this->unidadesProducidas, 2);
                    $demandaDia[] = round($this->demandas[$i] / $this->dias[$i]);
                    $demandaUnid[] = round($this->demandas[$i] / $uniTrab[$i], 2);
                    $trabReq[] = ceil($demandaUnid[$i]);
                }
                break;
            case 3:
                for ($i = 0; $i < count($this->demandas); $i++) {
                    $uniTrab[] = round($this->dias[$i] * $this->unidadesProducidas, 2);
                    $demandaDia[] = round($this->demandas[$i] / $this->dias[$i]);
                    $demandaUnid[] = round($this->demandas[$i] / $uniTrab[$i], 2);
                    $trabReq[] = ceil($demandaUnid[$i]);
                }
                break;
            case 4:
                for ($i = 0; $i < count($this->demandas); $i++) {
                    $uniTrab[] = round($this->dias[$i] * $this->unidadesProducidas, 2);
                    $demandaDia[] = round($this->demandas[$i] / $this->dias[$i]);
                    $demandaUnid[] = round($this->demandas[$i] / $uniTrab[$i], 2);
                    $trabReq[] = ceil($demandaUnid[$i]);
                }
                break;
            case 5:
                for ($i = 0; $i < count($this->demandas); $i++) {

                    $uniTrab[] = round($this->dias[$i] * $this->unidadesProducidas, 2);
                    $demandaDia[] = round($this->demandas[$i] / $this->dias[$i]);
                    $demandaUnid[] = round($this->demandas[$i] / $uniTrab[$i], 2);
                    // $trabReq[] = ceil(array_sum($this->demandas)/ array_sum($uniTrab));
                    
                }
                break;
        }

        switch ($this->alternativa) {
                //para fuerza de trabajo constante
            case 2:
                $trabs = array_sum($this->demandas) / array_sum($uniTrab);
                break;
                //para fuerza de trabajo constante minima
            case 3:

                $posicion = array_search(min($this->demandas), $this->demandas);
                $trabs = min($this->demandas) / $uniTrab[$posicion];
                break;
            case 5:
                $trabs = ceil(array_sum($this->demandas)/ array_sum($uniTrab));
                break;
        }


        for ($i = 0; $i < count($this->demandas); $i++) {

            if ($this->alternativa == 2 || $this->alternativa == 3 || $this->alternativa ==5) {
                $trabReq[$i] = ceil($trabs);
            }



            if ($trabDispo[$i] < $trabReq[$i]) {
                $traContr[] = $trabReq[$i] - $trabDispo[$i];
                $trabDepe[] = 0;
            } else if ($trabDispo[$i] > $trabReq[$i]) {
                $traContr[] = 0;
                $trabDepe[] = $trabDispo[$i] - $trabReq[$i];
            } elseif ($trabDispo[$i] == $trabReq[$i]) {
                $traContr[] = 0;
                $trabDepe[] = 0;
            }

            $trabDispo[$i + 1] = $trabReq[$i];
            $trabEmp[] = $trabReq[$i];

            // echo $trabDispo[$i]."aqui xd <br>";

            //para seleccionar la alternativa
            switch ($this->alternativa) {
                case 1:
                    $prodHrNor[] = 0;
                    $hrNormNe[] = 0;
                    $hrNormal[] = 0;
                    $hrHorarioNormal[] = 0;
                    $hrExtraNe[] = 0;
                    $uniSub[] = 0;
                    $uniProd[] = $this->demandas[$i];
                    break;

                case 2:
                    $prodHrNor[] = 0;
                    $hrNormNe[] = 0;
                    $hrNormal[] = 0;
                    $hrHorarioNormal[] = 0;
                    $hrExtraNe[] = 0;
                    $uniSub[] = 0;
                    $uniProd[] = $uniTrab[$i] * $trabEmp[$i];
                    break;
                case 3:

                    $prodHrNor[] = 0;
                    $hrNormNe[] = 0;
                    $hrNormal[] = 0;
                    $hrHorarioNormal[] = 0;
                    $hrExtraNe[] = 0;
                    $uniProd[] = $uniTrab[$i] * $trabEmp[$i];

                    break;

                case 4:

                    $prodHrNor[] = 0;
                    $hrNormNe[] = $this->demandas[$i] * $this->horasUnidad;
                    $hrNormal[] = 0;
                    $hrHorarioNormal[] = 0;
                    $hrExtraNe[] = 0;
                    $uniProd[] = $uniTrab[$i] * $trabEmp[$i];
                    break;
                case 5:
                    $hrNormal[] = 0;
                    $uniSub[] = 0;
                    $uniProd[] = $this->demandas[$i];
                    $prodHrNor[] = $uniTrab[$i] * $trabEmp[$i];
                    $hrNormNe[] = $this->demandas[$i]*$this->horasUnidad;
                    $hrHorarioNormal[] = $uniTrab[$i] * $trabEmp[$i]* $this->horasUnidad;

                    if($hrNormNe[$i]>$hrHorarioNormal[$i]){
                        $hrExtraNe[] = $hrNormNe[$i] - $hrHorarioNormal[$i];
                    }elseif($hrNormNe[$i]<$hrHorarioNormal[$i]){
                        $hrExtraNe[] = 0;
                    }
                    break;
            }

            //para calcular el inventario

            $inventario[$i + 1] = $uniProd[$i] - $this->demandas[$i] + $inventario[$i];
        }


        // echo "el tamaño de es: ".count($inventario);

        $inventarioAct = array_slice($inventario, 1, count($inventario));

        for ($i = 0; $i < count($inventarioAct); $i++) {

            switch ($this->alternativa) {
                case 1:
                    $uniSub[] = 0;
                    break;
                case 2:
                    $uniSub[] = 0;
                    break;
                case 3:
                    if ($inventarioAct[$i] < 0) {
                        $uniSub[] = abs($inventarioAct[$i]);
                        $inventarioAct[$i] = 0;
                    } else if ($inventarioAct[$i] >= 0) {
                        $uniSub[] = 0;
                        $inventarioAct[$i] = $inventarioAct[$i];
                    }
                    break;
                case 4:
                    $uniSub[] = 0;
                    break;
            }
        }

        //para unidades subcontratadas


        for ($i = 0; $i < count($this->demandas); $i++) {


            if ($inventarioAct[$i] < 0) {
                $costoAlm[] = 0;
                $costoRet[] = $inventarioAct[$i] * (-1) * $this->costoRotura;
            } else {

                $costoAlm[] = $inventarioAct[$i] * $this->costoAlmacenamiento;
                $costoRet[] = 0;
            }
            
            

            if ($this->alternativa == 4) {
                $costoMONr[] = $hrNormNe[$i] * $this->costoMOhr;
            } else {
                $costoMONr[] = $this->dias[$i] * $this->costoMOhr * $this->horasDia * $trabEmp[$i];
            }
            
            $costoExt[] = $hrExtraNe[$i] * $this->costoHoraExtra;
        }


        $costoTotal = array_map(
            function (...$costos) {
                return array_sum($costos);
            },
            array_map(fn ($elemento) => $elemento * $this->costoContratacion, $traContr),
            array_map(fn ($elemento) => $elemento * $this->costoDespido, $trabDepe),
            $costoSub,
            $costoAlm,
            $costoRet,
            $costoMONr,
            $costoExt,
            array_map(fn ($elemento) => $elemento * $this->costoProduccion, $uniProd)
        );

        return [
            "meses" => $this->mesesTotal,
            "demanda" => $this->demandas,
            "dias" => $this->dias,
            "unidadTrabajador" => $uniTrab,
            "demandaDia" => $demandaDia,
            "demandaUnidad" => $demandaUnid,
            "trabRequeridos" => $trabReq,
            "trabDisponibles" => array_slice($trabDispo, 0, count($trabDispo) - 1),
            "trabContratados" => $traContr,
            "trabDespedidos" => $trabDepe,
            "trabEmpleados" => $trabEmp,
            "costoContratacion" => array_map(fn ($elemento) => $elemento * $this->costoContratacion, $traContr),
            "costoDespido" => array_map(fn ($elemento) => $elemento * $this->costoDespido, $trabDepe),
            "produccionHrNormal" => $prodHrNor,
            "hrNormalNecesaria" => $hrNormNe,
            "horaHorarioNormal" => $hrHorarioNormal,
            "costoMOhrNormal" => $costoMONr,
            "horaExtraNecesaria" => $hrExtraNe,
            "costoHoraExtra" => $costoExt,
            "unidadesSubcontratadas" => $uniSub,
            "costoSubcontratacion" => array_map(fn ($elemento) => $elemento * $this->costoSubcontratacion, $uniSub),
            "unidadesProducidas" => $uniProd,
            "inventario" => $inventarioAct,
            "costoAlmacenamiento" => $costoAlm,
            "costoRotura" => $costoRet,
            "costoUnidadProducida" => array_map(fn ($elemento) => $elemento * $this->costoProduccion, $uniProd),
            "costosTotales" =>  $costoTotal,
            "totales" => [
                "totalDias" => array_sum($this->dias),
                "totalUniTrab" => array_sum($uniTrab),
                "totalDemanda" => array_sum($this->demandas),
                "totalCostoContratacion" => array_sum(array_map(fn ($elemento) => $elemento * $this->costoContratacion, $traContr)),
                "totalCostoDespido" => array_sum(array_map(fn ($elemento) => $elemento * $this->costoDespido, $trabDepe)),
                "totalcostoMOhrNormal" => array_sum($costoMONr),
                "totalCostoHoraExtra" => array_sum($costoExt),
                "totalCostoSubcontratacion" => array_sum($costoSub),
                "totalCostoAlmacenamiento" => array_sum($costoAlm),
                "totalCostoRotura" => array_sum($costoRet),
                "totalCostoUnidadProducida" => array_sum(array_map(fn ($elemento) => $elemento * $this->costoProduccion, $uniProd)),
                "totalGeneral" => array_sum($costoTotal),
            ],

        ];
    }
    function unidadTrabjador($alternativa, $cantidad,)
    {
        $unidadTrab = "hola xd";
        echo $unidadTrab;
    }
}

$pap = new PAP($alternativa, $mesesTotal, $demandas, $dias, $trabIniciales, $horasUnidad, $horasDia, $unidadesProducidas, $costoProduccion, $costoContratacion, $costoDespido, $costoHoraExtra, $costoSubcontratacion, $costoAlmacenamiento, $costoRotura, $costoMOhr);

$_SESSION['datos']=$pap->alternativa;

$_SESSION['uniProd']=$pap->unidadesProducidas;

$_SESSION['pap']=$pap->datos();

$general = $pap->datos();



$_SESSION["alternativas"]=array();

for($i=0; $i<5; $i++){
    $pap = new PAP($i+1, $mesesTotal, $demandas, $dias, $trabIniciales, $horasUnidad, $horasDia, $unidadesProducidas, $costoProduccion, $costoContratacion, $costoDespido, $costoHoraExtra, $costoSubcontratacion, $costoAlmacenamiento, $costoRotura, $costoMOhr);
    $alternativas1[$i] = $pap->datos();
}

$_SESSION["alternativas"] = $alternativas1;

echo json_encode($general, JSON_UNESCAPED_UNICODE);
