<?php
$todo = array();
function promediomovilsimple($demanda, $n)
{
    $movilSimple = [];

    // Agregar nulls al principio según el valor de $n
    $movilSimple = array_pad($movilSimple, count($movilSimple) + $n, null);

    // Cambié la condición para incluir el último valor
    for ($i = $n - 1; $i < count($demanda); $i++) {
        $sumaPeriodos = 0;

        for ($j = 0; $j < $n; $j++) {
            $sumaPeriodos += $demanda[$i - $j];
        }

        $movil = round($sumaPeriodos / $n, 2);
        $movilSimple[] = $movil;
    }

    return $movilSimple;
}




function promedioMovilPonderado($demandas, $pesos, $n, $alcance)
{

    $promedioponderado = [];

    for ($i = $n - 1; $i < count($demandas); $i++) {
        $sumaPonderada = 0;

        for ($j = 0; $j < $n; $j++) {
            $sumaPonderada += $demandas[$i - $j] * $pesos[$j];
        }

        $promedio = round($sumaPonderada, 2);
        $promedioponderado[] = $promedio;
    }

    // Realizar iteraciones a futuro
    for ($k = 0; $k < $alcance; $k++) {
        $sumaPonderada = 0;

        for ($j = 0; $j < $n; $j++) {
            $sumaPonderada += $demandas[count($demandas) - 1 - $j] * $pesos[$j];
        }

        $promedio = round($sumaPonderada, 2);
        $promedioponderado[] = $promedio;

        array_push($demandas, $promedio);
    }

    return $promedioponderado;
}

function regresionlineal($demanda, $proporcion, $alcance)
{
    $m = 0;
    $b = 0;

    $index = 1;
    foreach ($demanda as $value) {
        $arraycorreguido[] = array($index, $value);
        $index++;
    }
    $data = $arraycorreguido;
    // Store data length in a local variable to reduce
    // repeated array property lookups
    $dataLength = count($data);

    // If there's only one point, arbitrarily choose a slope of 0
    // and a y-intercept of whatever the y of the initial point is
    if ($dataLength === 1) {
        $m = 0;
        $b = $data[0][1];
    } else {
        // Initialize our sums and scope the `m` and `b`
        // variables that define the line.
        $sumX = 0;
        $sumY = 0;
        $sumXX = 0;
        $sumXY = 0;

        // Use local variables to grab point values
        // with minimal array property lookups
        $point = [];
        $x = 0;
        $y = 0;

        // Gather the sum of all x values, the sum of all
        // y values, and the sum of x^2 and (x*y) for each
        // value.
        //
        // In math notation, these would be SS_x, SS_y, SS_xx, and SS_xy
        for ($i = 0; $i < $dataLength; $i++) {
            $point = $data[$i];
            $x = $point[0];
            $y = $point[1];

            $sumX += $x;
            $sumY += $y;

            $sumXX += $x * $x;
            $sumXY += $x * $y;
        }

        // `m` is the slope of the regression line
        $m =
            ($dataLength * $sumXY - $sumX * $sumY) /
            ($dataLength * $sumXX - $sumX * $sumX);

        // `b` is the y-intercept of the line.
        $b = $sumY / $dataLength - ($m * $sumX) / $dataLength;
    }

    for ($index = 1; $index <= (count($demanda) + $alcance); $index++) {
        $arraypronostico[] = $m * $index + $b; // Multiplicar por el índice en lugar del valor
    }


    // Calcular el multiplicador estacional
    // Calcular el multiplicador estacional
    $multiplicadorEstacional = [];
    for ($i = 0; $i < count($demanda) - $proporcion; $i++) {
        $valor1 = $demanda[$i] / $arraypronostico[$i];
        $valor2 = $demanda[$i + $proporcion] / $arraypronostico[$i + $proporcion];

        $valoresDepuracion[] = [
            'Valor1' => $valor1,
            'Valor2' => $valor2
        ];
        $multiplicadorEstacional[] = ($valor1 + $valor2) / 2;
    }

    // Aplicar el multiplicador estacional al pronóstico para obtener el pronóstico ajustado
    $arraypronosticoajustado = [];
    foreach ($arraypronostico as $key => $pronostico) {
        $index = $key % count($multiplicadorEstacional);
        $arraypronosticoajustado[] = $pronostico * $multiplicadorEstacional[$index];
    }

    // Regresar todos los valores como un array
    return [
        'm' => $m,
        'b' => $b,
        'arraypronostico' => $arraypronostico,
        'multiplicadorEstacional' => $multiplicadorEstacional,
        'arraypronosticoajustado' => $arraypronosticoajustado,
        'otros' => $valoresDepuracion,
        calcularErrores($demanda, $arraypronosticoajustado)
    ];
}



function calcularErrores($demanda, $pronostico)
{
    $errores = [];
    $erroresAbsolutos = [];
    $erroresPorcentuales = [];
    $erroresCuadraticos = [];

    for ($i = 0; $i < count($demanda); $i++) {
        $error = $demanda[$i] - $pronostico[$i];
        $errorAbsoluto = abs($error);
        $errorPorcentual = ($errorAbsoluto / $demanda[$i]) * 100;
        $errorCuadratico = $error * $error;

        $errores[] = $error;
        $erroresAbsolutos[] = $errorAbsoluto;
        $erroresPorcentuales[] = $errorPorcentual;
        $erroresCuadraticos[] = $errorCuadratico;
    }

    return [
        'errores' => $errores,
        'erroresAbsolutos' => $erroresAbsolutos,
        'erroresPorcentuales' => $erroresPorcentuales,
        'erroresCuadraticos' => $erroresCuadraticos
    ];
}




function suavisadoexponencialsimple($x, $y)
{
    $sed = new SimpleExponentialSmoothing($x, $y);
    $result = $sed->predict();
    return $result;
}


class SimpleExponentialSmoothing
{
    private $data;
    private $alpha;
    private $forecast;

    public function __construct($data, $alpha)
    {
        if ($data == null) {
            throw new Exception("data parameter is null");
        } elseif (count($data) < 2) {
            throw new Exception("data doesn't contain enough data to make a prediction");
        }

        if ($alpha > 1 || $alpha < 0) {
            throw new Exception("alpha parameter must be between 0 and 1");
        }

        $this->data = $data;
        $this->alpha = $alpha;
        $this->forecast = null;
    }

    public function predict()
    {
        $forecast = array();
        $forecast[0] = $this->data[0]; // Utilizar el primer dato de la demanda como el primer dato en el pronóstico
        $forecast[1] = 0.5 * ($this->data[0] + $this->data[1]);

        for ($i = 2; $i <= count($this->data); ++$i) {
            $forecast[$i] = $this->alpha * ($this->data[$i - 1] - $forecast[$i - 1]) + $forecast[$i - 1];
        }

        $this->forecast = $forecast;
        return $forecast;
    }

    public function getForecast()
    {
        if ($this->forecast == null) {
            $this->predict();
        }
        return $this->forecast;
    }
}



class HoltSmoothing
{
    public $data;
    public $alpha;
    public $beta;
    public $forecast;

    public function __construct($data, $alpha, $beta)
    {
        if ($data == null) {
            throw new Exception("data parameter is null");
        } elseif (count($data) < 2) {
            throw new Exception("data doesn't contain enough data to make a prediction");
        }

        if ($alpha > 1 || $alpha < 0) {
            throw new Exception("alpha parameter must be between 0 and 1");
        }

        if ($beta > 1 || $beta < 0) {
            throw new Exception("beta parameter must be between 0 and 1");
        }

        $this->data = $data;
        $this->alpha = $alpha;
        $this->beta = $beta;
        $this->forecast = null;
    }

    public function predict($horizon)
    {
        $A = array();
        $B = array();

        $A[0] = 0;
        $B[0] = $this->data[0];

        for ($i = 1; $i < count($this->data); ++$i) {
            $B[$i] = $this->alpha * $this->data[$i] + (1 - $this->alpha) * ($B[$i - 1] + $A[$i - 1]);
            $A[$i] = $this->beta * ($B[$i] - $B[$i - 1]) + (1 - $this->beta) * $A[$i - 1];
        }

        $forecast = array();
        $forecast[0] = null;
        for ($i = 1; $i <= count($this->data); ++$i) {
            $forecast[$i] = $A[$i - 1] + $B[$i - 1];
        }

        for ($i = count($this->data) + 1; $i < count($this->data) + $horizon; ++$i) {
            $forecast[$i] = $forecast[$i - 1] + $A[count($this->data) - 1];
        }

        $this->forecast = $forecast;
        return $forecast;
    }

    public function getForecast()
    {
        if ($this->forecast == null) {
            return null;
        }
        return $this->forecast;
    }

}


function suavisadoexponencialdoble($demanda, $alpha, $beta, $alcance)
{
    $ses = new HoltSmoothing($demanda, $alpha, $beta);

    // Realizar la predicción con el horizonte especificado
    $pronosticos = $ses->predict($alcance);

    // Obtener el array final con los pronósticos
    return $pronosticos;
}





if (isset($_POST['metodo'], $_POST['demanda'])) {
    // Recupera los valores del formulario
    $metodo = $_POST['metodo'];
    $demanda = $_POST['demanda'];
    switch ($metodo) {
        case 'promediomovilsimple':
            $n = $_POST['n'];
            $pms = promediomovilsimple($demanda, $n);
            $todo = [
                'demanda' => $demanda,
                'promediomovilsimple' => $pms,
            ];
            echo json_encode($todo, JSON_UNESCAPED_UNICODE);
            break;
        case 'promediomovilponderado':
            $n = $_POST['n'];
            $pesos = $_POST['pesos'];
            $alcance = $_POST['alcance'];
            $pmp = promedioMovilPonderado($demanda, $pesos, $n, $alcance);
            $todo = [
                'demanda' => $demanda,
                'promediomovilponderado' => $pmp,
                calcularErrores($demanda, $pmp)
            ];
            echo json_encode($todo, JSON_UNESCAPED_UNICODE);
            break;
        case 'regresionlineal':
            $proporcion = isset($_POST['proporcion']) ? $_POST['proporcion'] : null;
            $alcance = $_POST['alcance'];
            $rl = regresionlineal($demanda, $proporcion, $alcance);
            $todo = [
                'demanda' => $demanda,
                'regresionlineal' => $rl
            ];
            echo json_encode($todo, JSON_UNESCAPED_UNICODE);
            break;
        case 'suavisadoexponencialsimple':
            $alpha = isset($_POST['alpha']) ? $_POST['alpha'] : null;
            $ses = suavisadoexponencialsimple($demanda, $alpha);
            $todo = [
                'demanda' => $demanda,
                'suavisadoexponencialsimple' => $ses,
                calcularErrores($demanda, $ses)
            ];
            echo json_encode($todo, JSON_UNESCAPED_UNICODE);
            break;
        case 'suavisadoexponencialdoble':
                $alpha = isset($_POST['alpha']) ? $_POST['alpha'] : null;
                $alcance = $_POST['alcance'];
                
                $sed = suavisadoexponencialdoble($demanda, $alpha,$beta, $alcance );
                $todo = [
                    'demanda' => $demanda,
                    'suavisadoexponencialdoble' => $sed,
                    //calcularErrores($demanda, $sed)
                ];
                echo json_encode($todo, JSON_UNESCAPED_UNICODE);
                break;
        case 'winters':
                    $alpha = isset($_POST['alpha']) ? $_POST['alpha'] : null;
                    $ses = suavisadoexponencialsimple($demanda, $alpha);
                    $todo = [
                        'demanda' => $demanda,
                        'suavisadoexponencialsimple' => $ses,
                        calcularErrores($demanda, $ses)
                    ];
                    echo json_encode($todo, JSON_UNESCAPED_UNICODE);
                    break;
        default:
            $error = ['error' => 'Método no reconocido'];
            echo json_encode($error, JSON_UNESCAPED_UNICODE);
            break;
    }

    // Resto de tu código...
}
