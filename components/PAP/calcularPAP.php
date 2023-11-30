<?php
$mesesTotal = $_POST["mesesTotal"];

$trabIniciales = $_POST["trabIniciales"];
$horasUnidad = $_POST["horasUnidad"];
$horasDia = $_POST["horasDia"];
$unidadesProducidas = $_POST["unidadesProducidas"];


$costoProduccion = $_POST["costoProduccion"];
$costoContratacion = $_POST["costoContratacion"];
$costoDespido = $_POST["costoDespido"];
$costoHoraExtra =$_POST["costoHoraExtra"];
$costoSubcontratacion = $_POST["costoSubcontratacion"];
$costoAlmacenamiento = $_POST["costoAlmacenamiento"];
$costoRotura = $_POST["costoRotura"];
$costoMO = $_POST["costoMO"];

$demandas = $_POST["demandas"];
$dias = $_POST["dias"];


$alternativa = $_POST["alternativasPAP"];

class PAP {
    private $alternativa;

    private $mesesTotal;
    private $demandas;
    private $dias;
    private $trabIniciales;
    private $horasUnidad;
    private $horasDia;
    private $unidadesProducidas;
    private $costoProduccion;
    private $costoContratacion;
    private $costoDespido;
    private $costoHoraExtra;
    private $costoSubcontratacion;
    private $costoAlmacenamiento;
    private $costoRotura;
    private $costoMO;

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
        $costoMO,
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
        $this->costoRotura = $costoRotura;
        $this->costoMO = $costoMO;
    }

    function datos(){
        $uniTrab = array();
        $demandaDia = array();
        $demandaUnid = array();
        $trabReq = array();
        $trabDispo= array($this->trabIniciales);
        $traContr = array();
        $trabDepe = array();
        $prodHrNor = array();
        $hrNormal = array();
        $hrNormNe = array();
        $hrHorarioNormal = array();
        $hrExtraNe = array();
        $uniSub = array();
        $costoSub = array();
        $uniProd = array();
        $inventario = array(0);
        $costoAlm = array();
        $costoRet = array();
        $costoTotal = array();
        $costoMONr=array();
        $costoMO = array();
        $trabEmp =array();        


        for($i = 0 ; $i<count($this->demandas); $i++){

            $uniTrab[] = $this->dias[$i] * $this->unidadesProducidas;
            $demandaDia[] = $this->demandas[$i]/$this->dias[$i];
            $demandaUnid[] = $this->demandas[$i]/$uniTrab[$i];
            $trabReq[] = ceil($demandaUnid[$i]);

            
            if($trabDispo[$i] < $trabReq[$i]){
                
                $traContr[] = $trabReq[$i] - $trabDispo[$i];
                $trabDepe[]=0;
            }else if($trabDispo[$i] > $trabReq[$i]){
                $traContr[] = 0;
                $trabDepe[] = $trabDispo[$i] - $trabReq[$i];
            }

            $trabDispo[$i+1] = $trabReq[$i] ;
            $trabEmp[] = $trabReq[$i];

            // echo $trabDispo[$i]."aqui xd <br>";

            //para seleccionar la alternativa
            switch($this->alternativa){
                case 1:
                    $prodHrNor[] = 0;
                    $hrNormNe[]=0;
                    $hrNormal[] =0;
                    $hrHorarioNormal[] =0;
                    $hrExtraNe[] =0;
                    $uniSub[]=0;
                    $costoSub[]=0;
                    $uniProd[] = $this->demandas[$i];
                    
                    break;
                case 2:
                    $prodHrNor[] = 0;
                    break;
                case 3:
                    $prodHrNor[] = 0;
                    break;
                case 4:
                    $prodHrNor[] = $this->demandas[$i] * $this->horasUnidad;
                    $hrNormal[] =$prodHrNor[$i]*$this->horasUnidad;

                    break;
            }

            
            $inventario[$i+1] = $inventario[$i] ;
           

            if($inventario[$i] < 0){
                $costoAlm[] = 0;
                $costoRet[] = $inventario[$i]*-1* $this->costoRotura;  
            }
            else if($inventario[$i] >= 0){
                
                $costoAlm[] = $inventario[$i]* $this->costoAlmacenamiento;
                $costoRet[] = 0; 
            }
            $costoMONr[]=$this->dias[$i] * $this->costoMO *$this->horasDia *$trabEmp[$i];
            $costoMO[]=$this->dias[$i] * $this->costoMO *$trabEmp[$i];
            
        }

        $costoTotal = array_map(function(...$costos) {
            return array_sum($costos);
        }, array_map(fn($elemento) => $elemento * $this->costoContratacion, $traContr), 
           array_map(fn($elemento) => $elemento * $this->costoDespido, $trabDepe),
           $costoSub,
           $costoAlm,
           $costoRet,
           $costoMO,
           $costoMONr,
           array_map(fn($elemento) => $elemento * $this->costoProduccion, $uniProd));

    
        return[
                "meses"=>$this->mesesTotal,
                "demanda"=>$this->demandas,
                "dias"=>$this->dias,
                "unidadTrabajador"=>$uniTrab,
                "demandaDia"=>$demandaDia,
                "demandaUnidad"=>$demandaUnid,
                "trabRequeridos"=>$trabReq,
                "trabDisponibles"=>array_slice($trabDispo,0,count($trabDispo)-1),
                "trabContratados"=>$traContr,
                "trabDespedidos"=>$trabDepe,
                "trabEmpleados"=>$trabEmp,
                "costoContratacion"=>array_map(fn($elemento) => $elemento * $this->costoContratacion, $traContr),
                "costoDespido"=>array_map(fn($elemento) => $elemento * $this->costoDespido, $trabDepe),
                "produccionHrNormal"=>$prodHrNor,
                "hrNormalNecesaria"=>$hrNormNe,
                "horaHorarioNormal"=>$hrHorarioNormal,
                "costoMO"=>$costoMO,
                "costoMOhrNormal"=>$costoMONr,
                "horaExtraNecesaria"=>$hrExtraNe,
                "unidadesSubcontratadas"=>$uniSub,
                "costoSubcontratacion"=>$costoSub,
                "unidadesProducidas" => $uniProd,
                "inventario"=>array_slice($inventario,0,count($inventario)-1),
                "costoAlmacenamiento"=>$costoAlm,
                "costoRotura"=>$costoRet,
                "costoUnidadProducida"=> array_map(fn($elemento) => $elemento * $this->costoProduccion, $uniProd),
                "costosTotales"=>  $costoTotal,
                   "totales"=>[
                            "totalDias"=>array_sum($this->dias),
                            "totalUniTrab"=>array_sum($uniTrab),
                            "totalDemanda"=>array_sum($this->demandas),
                            "totalCostoContratacion"=>array_sum(array_map(fn($elemento) => $elemento * $this->costoContratacion, $traContr)),
                            "totalCostoDespido"=>array_sum(array_map(fn($elemento) => $elemento * $this->costoDespido, $trabDepe)),
                            "totalcostoMO"=>array_sum($costoMO),
                            "totalcostoMOhrNormal"=>array_sum($costoMONr),
                            "totalCostoSubcontratacion"=>array_sum($costoSub),
                            "totalCostoAlmacenamiento"=>array_sum($costoAlm),
                            "totalCostoRotura"=>array_sum($costoRet),
                            "totalCostoUnidadProducida"=>array_sum(array_map(fn($elemento) => $elemento * $this->costoProduccion, $uniProd)),
                            "totalGeneral"=>array_sum($costoTotal),
                   ],
                   
              ] ;
              
    }
    function trabRequeridos(){

    }
}

$pap = new PAP($alternativa,$mesesTotal,$demandas,$dias,$trabIniciales,$horasUnidad,$horasDia,$unidadesProducidas,$costoProduccion,$costoContratacion,$costoDespido,$costoHoraExtra,$costoSubcontratacion,$costoAlmacenamiento,$costoRotura,$costoMO);

$general = $pap->datos();

echo json_encode($general, JSON_UNESCAPED_UNICODE);
?>