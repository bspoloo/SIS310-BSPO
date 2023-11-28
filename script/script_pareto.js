let myChart = null;
let gridInstance = null;

function loadTable_pareto(page) {
    var products_table = document.getElementById('products_table');
    var products = document.getElementById("products").valueAsNumber;

    document.getElementById('ingresos_table').innerHTML = "";
    // console.log(page+"?products="+products);

    fetch(page + "?products=" + products)
        .then(response => response.text())
        .then(data => {
            products_table.innerHTML = data;
        });
}
function calcularDatos() {

    var ingresos_table = document.getElementById("ingresos_table");
    var paretoTableContainer = document.getElementById("pareto_table");
    paretoTableContainer.innerHTML = "";
    
    console.log("aqui ta",paretoTableContainer);


    var formulario = document.getElementById("form_datos");
    var parametros = new FormData(formulario);


    
    fetch("../components/Diagrama de pareto/calcularDatos.php",
        {
            method: "POST",
            body: parametros
        })

        .then(response => response.text())
        .then(data => {

            objeto = JSON.parse(data);
            console.log(objeto);


            if (gridInstance) {
                gridInstance.destroy(); // Destruir la tabla existente si hay una
            }
            
            gridInstance = new gridjs.Grid({
                columns: ["Nr°","Nombres", "Unidades", "Precios", "Ingresos","Porcentaje %", "Porcentaje acumulativo %"],
                data: objeto.ingresos.map((value, index) => {
                  return [
                    index + 1,                                                                                    
                    objeto['nombres'][index],
                    objeto['unidades'][index],          
                    objeto['precios'][index],  
                    objeto['ingresos'][index],               
                    objeto['porcentaje'][index],      
                    objeto['porcentajeAcumulativo'][index],
                    objeto['totalesIngresos'][index]];

                })
              }).render(paretoTableContainer);
            // Agregar otras tablas si es necesario
            graficarPareto(objeto['nombres'],objeto['ingresoAcumulativo'],objeto['porcentajeAcumulativo'],objeto['ingresos']);
        });

    
}

function graficarPareto(NombreProductos,ingresoAcumulativo,porcentaje, ingresos) {
    

    console.log("graficando xd xdxdxd");

    const data = {
        labels: NombreProductos,
        datasets: [{
            label: 'Ingresos',
            data: porcentaje,
            backgroundColor: 'rgba(255, 26, 104, 0.2)',
            borderColor: 'rgba(255, 26, 154, 1)',
            borderWidth: 1,
            yAxisID: 'percentageAxis',
        }, {
            label: 'Porcentaje acumulativo',
            data: ingresos,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(255, 26, 104, 1)',
            borderWidth: 1,
            type: 'bar',
            categoryPercentage: 1,
        }]
    };

    // config 
    const config = {
        type: 'line',
        data,
        options: {

            plugins: {
                tooltip: {
                    yAling: 'bottom'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Productos',
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Ingresos',
                    }
                },

                percentageAxis: {
                    beginAtZero: true,
                    type: 'linear',
                    position: 'right',
                    min: 0,
                    max: 100,
                    ticks: {
                        callback: function (value) {
                            return value + '%';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Cumulative percentage',
                    }
                }
            }
        }
    };

    // render init block

    if (myChart) {
        myChart.destroy();
    }
    myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
}