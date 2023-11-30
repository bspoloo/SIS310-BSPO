let myChart_pronosticos = null;
let gridInstance_pronosticos = null;

function loadTable_pronosticos(page) {
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
    var ctx = document.getElementById('myChart'); // Recupera el contexto del elemento del gráfico
    var parametros = new FormData(document.getElementById("form_datosp"));

    fetch("../components/pronosticos/calcularPronosticos.php", {
        method: "POST",
        body: parametros
    })
    .then(response => response.text())
    .then(data => {
        try {
            let objeto = redondearJSON(JSON.parse(data),2);
            console.log(objeto);
            console.log(data);

            if (myChart_pronosticos) {
                myChart_pronosticos.destroy();
            }

            // Crear el gráfico
            myChart_pronosticos = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Array.from(Array(objeto.demanda.length).keys()),
                    datasets: [{
                        label: 'Datos de la Demanda',
                        data: objeto.demanda ?  objeto.demanda : [],
                        borderColor: 'rgb(0, 0, 255)',
                    }, {
                        label: 'Promedio móvil simple',
                        data: objeto.promediomovilsimple ? [null,null,null, ...objeto.promediomovilsimple]: [],
                        borderColor: 'rgb(0, 255, 0)',
                    }, {
                        label: 'Regresión lineal',
                        data: objeto.regresionlineal.arraypronostico ? objeto.regresionlineal.arraypronostico : [],
                        borderColor: 'rgb(255, 0, 0)',
                    }, {
                        label: 'Suavizado exponencial simple',
                        data: objeto.suavisadoexponencialsimple ?  objeto.suavisadoexponencialsimple :[],
                        borderColor: 'rgb(255, 165, 0)',
                    }]
                }
            });

            // Crear la tabla utilizando GRID.js
            if (gridInstance_pronosticos) {
                gridInstance_pronosticos.destroy(); // Destruir la tabla existente si hay una
            }

            if(objeto.regresionlineal.arraypronostico) {
                gridInstance_pronosticos= new gridjs.Grid({
                    columns: [
                        { name: "periodo" },
                        { name: "demanda"},
                        { name: "pronostico" },
                        { name: "(M.E)"},
                        { name: "pronostico ajustado"},
                        { name: "error"},
                        { name: "error abs"},
                        { name: "error %"}
                    ],
                    data: objeto.demanda.map((value, index) => {
                      return [
                        index + 1,                                              
                        value,                                                 
                        objeto.regresionlineal.arraypronostico[index],
                        objeto.regresionlineal.multiplicadorEstacional[index % objeto.regresionlineal.multiplicadorEstacional.length],          
                        objeto.regresionlineal.arraypronosticoajustado[index],  
                        objeto.regresionlineal[0].errores[index],               
                        objeto.regresionlineal[0].erroresAbsolutos[index],      
                        objeto.regresionlineal[0].erroresPorcentuales[index]];
                    })
                  }).render(document.getElementById("rl_table"));
            }

        } catch (error) {
            console.error("Error al analizar la respuesta JSON:", error);
        }
    })
    .catch(error => {
        console.error("Error en la solicitud fetch:", error);
    });
}


function redondearJSON(objeto, decimales) {
    if (typeof objeto === 'number') {
      return Number(objeto.toFixed(decimales));
    } else if (typeof objeto === 'object') {
      for (let clave in objeto) {
        objeto[clave] = redondearJSON(objeto[clave], decimales);
      }
    } else if (Array.isArray(objeto)) {
      for (let i = 0; i < objeto.length; i++) {
        objeto[i] = redondearJSON(objeto[i], decimales);
      }
    }
    return objeto;
  }