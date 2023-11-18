let myChart = null;

function loadTablep(page) {
    var pronosticos_table = document.getElementById('form_pronosticos_table');
    var pronosticos = document.getElementById("pronosticos").valueAsNumber;

    // console.log(page+"?pronosticos="+pronosticos);

    fetch(page + "?pronosticos=" + pronosticos)
        .then(response => response.text())
        .then(data => {
            pronosticos_table.innerHTML = data;
        });
}

function calcularPronosticos() {
    var ctx = document.getElementById('chart').getContext('2d'); // Recupera el contexto del elemento del gráfico
    var parametros = new FormData(document.getElementById("form_datosp"));
    
    fetch("../components/pronosticos/calcularPronosticos.php", {
        method: "POST",
        body: parametros
    })
    .then(response => response.text())
    .then(data => {
        try {
            let objeto = JSON.parse(data);
            console.log(objeto);
            console.log(data);

            if(myChart){
                myChart.destroy();
            }
            // Crear el gráfico
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array.from(Array(objeto.demanda.length).keys()),
                    datasets: [{
                        label: 'Original Data',
                        data: objeto.demanda,
                        borderColor: 'rgb(0, 0, 255)',
                    }, {
                        label: 'Simple Moving Average',
                        data: objeto.promediomovilsimple,
                        borderColor: 'rgb(0, 255, 0)',
                    }, {
                        label: 'Linear Regression',
                        data: objeto.regresionlineal.arrayfinal,
                        borderColor: 'rgb(255, 0, 0)',
                    }, {
                        label: 'Simple Exponential Smoothing',
                        data: objeto.suavisadoexponencialsimple,
                        borderColor: 'rgb(255, 165, 0)',
                    }]
                }
            });

           //tablas por doquier en esta parte
        } catch (error) {
            console.error("Error al analizar la respuesta JSON:", error);
        }
    })
    .catch(error => {
        console.error("Error en la solicitud fetch:", error);
         });
}
