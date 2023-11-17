let myChart = null;

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
    console.log("calulando datos");

    var ingresos_table = document.getElementById("ingresos_table");
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

            ingresos_table.innerHTML = ``;

            const table = document.createElement("table");
            table.border = 1;
            table.innerHTML = `<tr> 
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Unidades</th>
                                    <th>Precio($)</th>
                                    <th>Ingresos($)</th>
                                    <th>Porcentaje %</th>
                                    <th>Porcentaje acumulativo %</th>
                                </tr>`;

            for (var i = 0; i < objeto['nombres'].length; i++) {

                var tr = document.createElement("tr");
                tr.innerHTML = `
                                <td>${i + 1}</td>
                                <td>${objeto['nombres'][i]}</td>
                                <td>${objeto['unidades'][i]}</td>
                                <td>${objeto['precios'][i]}</td>
                                <td>${objeto['ingresos'][i]}</td>
                                <td>${objeto['porcentaje'][i]}%</td>
                                <td>${objeto['porcentajeAcumulativo'][i]}%</td>`;
                table.appendChild(tr);
            }
            table.innerHTML += `
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td>${objeto['totalesIngresos']}</td>
                                <td>${objeto['totalesPorcentaje']}%</td>
                                <td></td>`;
            ingresos_table.appendChild(table);

            graficarPareto(objeto['nombres'],objeto['ingresoAcumulativo'],objeto['porcentajeAcumulativo'],objeto['ingresos']);

        });

    
}

function graficarPareto(NombreProductos,ingresoAcumulativo,porcentaje, ingresos) {

    console.log("graficando xd");

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