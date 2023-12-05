let myChart_pronosticos = null;
let gridInstance_rl = null;
let gridInstance_sed = null;
let gridInstance_ses = null;
let gridInstance_pmp = null;
let gridInstance_winters = null;


let objetoconst = {};
//let arrayNull = [];


function loadTable_pronosticos(page) {
  var pronosticos_table = document.getElementById("form_pronosticos_table");

  var pronosticos = document.getElementById("pronosticos").valueAsNumber;
  //console.log(page + "?pronosticos=" + pronosticos);
  pronosticos_table.innerHTML = "";
  fetch(page + "?pronosticos=" + pronosticos)
    .then((response) => response.text())
    .then((data) => {
      pronosticos_table.innerHTML = data;
      var content = document.getElementById("content");
    // Reemplazar la clase old-class con new-class
    content.className = "";
    content.classList.add("container-p");
    });

  
}

function CambiarPronostico() {
  var metodo = document.getElementById("metodo").value;
  var opcionesPronostico = document.getElementById("opcionesPronostico");

  // Limpiar el contenido actual
  opcionesPronostico.innerHTML = "";

  // Mostrar opciones según el método seleccionado
  if (metodo === "regresionlineal") {
    // Opción para Regresión Lineal (dos inputs para proporcion y alcance)
    opcionesPronostico.innerHTML =
      '<label for="proporcion">Proporción:</label>' +
      '<input type="text" name="proporcion" id="proporcion" required>' + '<br>' +
      '<label for="alcance">Alcance:</label>' +
      '<input type="number" name="alcance" id="alcance" required>';
  } else if (metodo === "suavisadoexponencialsimple") {
    // Opción para Suavizado Exponencial Simple (un input para alpha)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="number" name="alpha" id="alpha" required step="0.01" min="0" max="1">';
  } else if (metodo === "suavisadoexponencialdoble") {
    // Opción para Suavizado Exponencial Doble (dos inputs para alpha y beta)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="number" name="alpha" id="alpha" required step="0.01" min="0" max="1">' + '<br>' +
      '<label for="beta">Beta:</label>' +
      '<input type="number" name="beta" id="beta" required step="0.01" min="0" max="1">' + '<br>' +
      '<label for="alcance">Alcance:</label>' +
      '<input type="number" name="alcance" id="alcance" required>';
  } else if (metodo === "winters") {
    // Opción para Winters (tres inputs para alpha, beta y gama)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="number" name="alpha" id="alpha" required step="0.01" min="0" max="1">' + '<br>' +
      '<label for="beta">Beta:</label>' +
      '<input type="number" name="beta" id="beta" required step="0.01" min="0" max="1">' + '<br>' +
      '<label for="gama">Gama:</label>' +
      '<input type="number" name="gama" id="gama" required step="0.01" min="0" max="1">';
  } else if (metodo === "promediomovilsimple") {
    // Opción para Promedio Móvil Simple (un input para n)
    opcionesPronostico.innerHTML =
      '<label for="n">Número de periodos (n):</label>' +
      '<input type="number" name="n" id="n" required>';
  } else if (metodo === "promediomovilponderado") {
    // Opción para Promedio Móvil Ponderado (inputs para n, pesos y alcance)
    opcionesPronostico.innerHTML =
      '<label for="n">Número de periodos (n):</label>' +
      '<input type="number" name="n" id="n" required>' + '<br>' +
      '<label for="pesos">Pesos (separados por comas) que sumandos sean igual a 1:</label>' +
      '<input type="text" name="pesos" id="pesos" required>' + '<br>' + '<br>' +
      '<label for="alcance">Alcance:</label>' +
      '<input type="number" name="alcance" id="alcance" required>';
  }


  // Mostrar el contenedor de opciones
  opcionesPronostico.style.display = "block";
}

function calcularPronosticos() {
  var ctx = document.getElementById("myChart"); // Recupera el contexto del elemento del gráfico
  var parametros = new FormData(document.getElementById("form_datosp"));
  // Obtiene el valor del método desde el campo oculto
  var metodo = document.getElementById("metodo").value;
 
  // Agrega el valor del método al objeto de parámetros
  parametros.append("metodo", metodo);

  fetch("../components/pronosticos/calcularPronosticos.php", {
    method: "POST",
    body: parametros,
  })
    .then((response) => response.text())
    .then((data) => {
      try {
        let objeto = JSON.parse(data);
        objeto = redondearJSON(objeto, 2);

        objetoconst = {
          ...objetoconst,
          [metodo]: objeto,
        };
        console.log(objeto);
        if (myChart_pronosticos) {
          myChart_pronosticos.destroy();
        }

        const longitudes = {
          promediomovilsimple:
            objeto.promediomovilsimple && objeto.demanda.length+3,
          promediomovilponderado:
            objeto.promediomovilponderado &&
            objeto.promediomovilponderado.length,
          regresionlineal:
            objeto.regresionlineal &&
            objeto.regresionlineal.arraypronosticoajustado &&
            objeto.regresionlineal.arraypronosticoajustado.length,
          suavisadoexponencialsimple:
            objeto.suavisadoexponencialsimple &&
            objeto.suavisadoexponencialsimple.length,
          suavisadoexponencialdoble:
            objeto.suavisadoexponencialdoble &&
            objeto.suavisadoexponencialdoble.length,
          winters:
            objeto.winters &&
            objeto.winters.length,
        };
        const longitud = longitudes[metodo];

        console.log(objetoconst);
        // Crear el gráfico
        myChart_pronosticos = new Chart(ctx, {
          type: "line",
          data: {
            labels: Array.from({ length: longitud }, (_, i) => i + 1),
            datasets: [
              {
                label: "Datos de la Demanda",
                data: objeto && objeto.demanda ? objeto.demanda : [],
                borderColor: "rgb(0, 0, 255)",
              },
              {
                label: "Promedio móvil simple",
                data:
                  objetoconst.promediomovilsimple &&
                  objetoconst.promediomovilsimple.promediomovilsimple
                    ? [
                      ...objetoconst.promediomovilsimple.promediomovilsimple,
                      ]
                    : [],
                borderColor: "rgb(0, 255, 0)",
              },
              {
                label: "Promedio móvil Ponderado",
                data:
                  objetoconst.promediomovilponderado &&
                  objetoconst.promediomovilponderado.promediomovilponderado
                    ? [
                      ...objetoconst.promediomovilponderado.promediomovilponderado
                      ]
                    : [],
                borderColor: "rgb(164, 255, 0)",
              },

              {
                label: "Regresión lineal",
                data:
                  objetoconst.regresionlineal &&
                  objetoconst.regresionlineal.regresionlineal
                    ? objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado
                    : [],
                borderColor: "rgb(255, 0, 0)",
              },
              {
                label: "Suavizado exponencial simple",
                data:
                  objetoconst.suavisadoexponencialsimple &&
                  objetoconst.suavisadoexponencialsimple
                    .suavisadoexponencialsimple
                    ? objetoconst.suavisadoexponencialsimple
                        .suavisadoexponencialsimple
                    : [],
                borderColor: "rgb(255, 165, 0)",
              },
              {
                label: "Suavisado Exponencial Doble",
                data: objetoconst.suavisadoexponencialdoble && objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
                  ? objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
                  : [],
                borderColor: "rgb(255, 255, 0)",
              },
            ],
          },
        });

       
        if (gridInstance_rl) {
          gridInstance_rl.destroy(); // Destruir la tabla existente si hay una
        }

        if (objetoconst.regresionlineal) {

          

          const longitudPronostico = objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado.length;
        
        
          gridInstance_rl = new gridjs.Grid({
            
            columns: [ {
              name: 'Regresion lineal',
              columns: [{
               name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "(M.E)" },
              { name: "pronostico ajustado" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" }] }
            ],  
            search : true,
            data: Array(longitudPronostico).fill(0).map((_, index) => {
              const demandaValue = index < objetoconst.regresionlineal.demanda.length? objetoconst.regresionlineal.demanda[index] : null;
              const pronosticoValue = index < longitudPronostico ? objetoconst.regresionlineal.regresionlineal.arraypronostico[index] : null;
        
              return [
                index + 1, 
                demandaValue,
                pronosticoValue,
                objetoconst.regresionlineal.regresionlineal.multiplicadorEstacional[
                  index % objetoconst.regresionlineal.regresionlineal.multiplicadorEstacional.length
                ],
                objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado[index],
                objetoconst.regresionlineal.regresionlineal[0].errores[index],
                objetoconst.regresionlineal.regresionlineal[0].erroresAbsolutos[index],
                objetoconst.regresionlineal.regresionlineal[0].erroresCuadraticos[index],

                objetoconst.regresionlineal.regresionlineal[0].erroresPorcentuales[index],
              ];
            }
            
            ),
          }).render(document.getElementById("rl_table"));
        }

        if (gridInstance_ses) {
          gridInstance_ses.destroy(); // Destruir la tabla existente si hay una
        }

        if (objetoconst.suavisadoexponencialsimple) {

          

          const longitudPronostico = objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple.length;
          
          gridInstance_ses= new gridjs.Grid({
        
            columns: [ {
              name: 'Suavisado Exponencial Simple',
              columns: [{
               name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" },] }
              
            ],
        
            data: Array(longitudPronostico).fill(0).map((_, index) => {
        
              const demandaValue = index < objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple.length ? objetoconst.suavisadoexponencialsimple.demanda[index] : null;
        
              const pronosticoValue = index < longitudPronostico ?  
                objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple[index] : 
                null;
        
              return [
                index+1,
                demandaValue,
                pronosticoValue,
                objetoconst.suavisadoexponencialsimple[0].errores[index],
                objetoconst.suavisadoexponencialsimple[0].erroresAbsolutos[index],
                objetoconst.suavisadoexponencialsimple[0].erroresCuadraticos[index],
                objetoconst.suavisadoexponencialsimple[0].erroresPorcentuales[index]
              ];
        
            })
        
          }).render(document.getElementById("ses_table"));;
        
        }

        if (gridInstance_sed) {
          gridInstance_sed.destroy(); // Destruir la tabla existente si hay una
        }

        if (objetoconst.suavisadoexponencialdoble) {

          console.log(objetoconst.suavisadoexponencialdoble[0].promedioErroresAbsolutos)

          const longitudPronostico = objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble.length;
        
          // console.log("Longitud de arraypronosticoajustado:", longitudPronostico);
          // console.log("Longitud de demanda:", objetoconst.suavisadoexponencialdoble.demanda.length);
        
          gridInstance_sed = new gridjs.Grid({
            
            columns: [ {
              name: 'Suavisado Exponencial Doble',
              columns: [
              { name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" }],
            }
            ],  
            data: Array(longitudPronostico).fill(0).map((_, index) => {
              const demandaValue = index < objetoconst.suavisadoexponencialdoble.demanda.length? objetoconst.suavisadoexponencialdoble.demanda[index] : null;
              const pronosticoValue = index < longitudPronostico ? objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble[index] : null;
              return [
                index+1,
                demandaValue,
                pronosticoValue,
                objetoconst.suavisadoexponencialdoble[0].errores[index],
                objetoconst.suavisadoexponencialdoble[0].erroresAbsolutos[index],
                objetoconst.suavisadoexponencialdoble[0].erroresCuadraticos[index],
                objetoconst.suavisadoexponencialdoble[0].erroresPorcentuales[index]
              ];
            }),
          }).render(document.getElementById("sed_table"));
        }

        if (gridInstance_pmp) {
          gridInstance_pmp.destroy(); // Destruir la tabla existente si hay una
        }

        if (objetoconst.promediomovilponderado) {

        const longitudPronostico = objetoconst.promediomovilponderado.promediomovilponderado.length;
          
          gridInstance_pmp= new gridjs.Grid({
        
            columns: [ {
              name: 'Promedio Movil Ponderado',
              columns: [
              { name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" }]
            }
              
            ],
        
            data: Array(longitudPronostico).fill(0).map((_, index) => {
        
              const demandaValue = index < objetoconst.promediomovilponderado.demanda.length ? objetoconst.promediomovilponderado.demanda[index] : null;
        
              const pronosticoValue = index < longitudPronostico ?  
                objetoconst.promediomovilponderado.promediomovilponderado[index] : 
                null;
        
              return [
                index+1,
                demandaValue,
                pronosticoValue,
                objetoconst.promediomovilponderado[0].errores[index],
                objetoconst.promediomovilponderado[0].erroresAbsolutos[index],
                objetoconst.promediomovilponderado[0].erroresCuadraticos[index],
                objetoconst.promediomovilponderado[0].erroresPorcentuales[index]
              ];
        
            })
        
          }).render(document.getElementById("pmp_table"));;
        
        }


        if (objetoconst.promediomovilsimple) {

          const longitudPronostico = objetoconst.promediomovilsimple.promediomovilsimple.length;
            
            gridInstance_pmp= new gridjs.Grid({
          
              columns: [ {
                name: 'Promedio Movil Simple',
                columns: [
                { name: "periodo" },
                { name: "demanda" },
                { name: "pronostico" },
                { name: "error" },
                { name: "error abs" },
                { name: "error cuadrático" },
                { name: "error %" }]
              }
              ],
              data: Array(longitudPronostico).fill(0).map((_, index) => {
          
                const demandaValue = index < objetoconst.promediomovilsimple.demanda.length ? objetoconst.promediomovilsimple.demanda[index] : null;
          
                const pronosticoValue = index < longitudPronostico ?  
                  objetoconst.promediomovilsimple.promediomovilsimple[index] : 
                  null;
          
                return [
                  index+1,
                  demandaValue,
                  pronosticoValue,
                  objetoconst.promediomovilsimple[0].errores[index],
                  objetoconst.promediomovilsimple[0].erroresAbsolutos[index],
                  objetoconst.promediomovilsimple[0].erroresCuadraticos[index],
                  objetoconst.promediomovilsimple[0].erroresPorcentuales[index]
                ];
          
              })
          
            }).render(document.getElementById("pmp_table"));;
          
          }


        var tablaDatos = [
          { titulo: "Regresión Lineal", tipo: "Errores Absolutos", valor: objetoconst.regresionlineal ? objetoconst.regresionlineal.regresionlineal[0].promedioErroresAbsolutos : 0 },
          { titulo: "Regresión Lineal", tipo: "Errores Cuadráticos", valor: objetoconst.regresionlineal ? objetoconst.regresionlineal.regresionlineal[0].promedioErroresCuadraticos : 0 },
          { titulo: "Regresión Lineal", tipo: "Errores Porcentuales", valor: objetoconst.regresionlineal ? objetoconst.regresionlineal.regresionlineal[0].promedioErroresPorcentuales : 0 },
          { titulo: "Suavizado Exponencial Simple", tipo: "Errores Absolutos", valor: objetoconst.suavisadoexponencialsimple ? objetoconst.suavisadoexponencialsimple[0].promedioErroresAbsolutos : 0 },
          { titulo: "Suavizado Exponencial Simple", tipo: "Errores Cuadráticos", valor: objetoconst.suavisadoexponencialsimple ? objetoconst.suavisadoexponencialsimple[0].promedioErroresCuadraticos : 0 },
          { titulo: "Suavizado Exponencial Simple", tipo: "Errores Porcentuales", valor: objetoconst.suavisadoexponencialsimple ? objetoconst.suavisadoexponencialsimple[0].promedioErroresPorcentuales : 0 },
          { titulo: "Suavizado Exponencial Doble", tipo: "Errores Absolutos", valor: objetoconst.suavisadoexponencialdoble ? objetoconst.suavisadoexponencialdoble[0].promedioErroresAbsolutos : 0 },
          { titulo: "Suavizado Exponencial Doble", tipo: "Errores Cuadráticos", valor: objetoconst.suavisadoexponencialdoble && objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
            ? objetoconst.suavisadoexponencialdoble[0].promedioErroresCuadraticos : 0 },
          { titulo: "Suavizado Exponencial Doble", tipo: "Errores Porcentuales", valor: objetoconst.suavisadoexponencialdoble && objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
            ? objetoconst.suavisadoexponencialdoble[0].promedioErroresPorcentuales : 0 },
          { titulo: "Promedio Móvil Ponderado", tipo: "Errores Absolutos", valor: objetoconst.promediomovilponderado ? objetoconst.promediomovilponderado[0].promedioErroresAbsolutos : 0 },
          { titulo: "Promedio Móvil Ponderado", tipo: "Errores Cuadráticos", valor: objetoconst.promediomovilponderado ? objetoconst.promediomovilponderado[0].promedioErroresCuadraticos : 0 },
          { titulo: "Promedio Móvil Ponderado", tipo: "Errores Porcentuales", valor: objetoconst.promediomovilponderado ? objetoconst.promediomovilponderado[0].promedioErroresPorcentuales : 0},
          
          { titulo: "Promedio Móvil Simple", tipo: "Errores Absolutos", valor: objetoconst.promediomovilsimple ? objetoconst.promediomovilsimple[0].promedioErroresAbsolutos : 0 },
          { titulo: "Promedio Móvil Simple", tipo: "Errores Cuadráticos", valor: objetoconst.promediomovilsimple ? objetoconst.promediomovilsimple[0].promedioErroresCuadraticos : 0 },
          { titulo: "Promedio Móvil Simple", tipo: "Errores Porcentuales", valor: objetoconst.promediomovilsimple ? objetoconst.promediomovilsimple[0].promedioErroresPorcentuales : 0}
        ];
        
        generarTablaPromedios();
        
        function generarTablaPromedios() {
          let tabla = "<table>";
          tabla += "<tr><th>Título</th><th>Error Absolutos</th><th>Error Cuadráticos</th><th>Error Porcentuales</th></tr>";
        
          let map = {};
        
          tablaDatos.forEach(dato => {
            if (!map[dato.titulo]) {
              map[dato.titulo] = { "Error Absolutos": null, "Error Cuadráticos": null, "Error Porcentuales": null };
            }
        
            map[dato.titulo][dato.tipo] = dato.valor;
          });
        
          Object.keys(map).forEach(titulo => {
            tabla += "<tr>";
            tabla += `<td>${titulo}</td>`;
            tabla += `<td>${map[titulo]["Errores Absolutos"]}</td>`;
            tabla += `<td>${map[titulo]["Errores Cuadráticos"]}</td>`;
            tabla += `<td>${map[titulo]["Errores Porcentuales"]}</td>`;
            tabla += "</tr>";
          });
        
          tabla += "</table>";
        
          document.getElementById('tablaPromedios').innerHTML = tabla;
        }
        
        



      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
      }
    })
    .catch((error) => {
      console.error("Error en la solicitud fetch:", error);
    });
}

function redondearJSON(objeto, decimales) {
  if (typeof objeto === "number") {
    // Manejo de NaN
    return isNaN(objeto) ? objeto : Number(objeto.toFixed(decimales));
  } else if (typeof objeto === "object" && objeto !== null) {
    // Crear un nuevo objeto en lugar de modificar el existente
    const nuevoObjeto = Array.isArray(objeto) ? [] : {};

    for (let clave in objeto) {
      nuevoObjeto[clave] = redondearJSON(objeto[clave], decimales);
    }

    return nuevoObjeto;
  } else {
    // Devolver cualquier otro tipo de datos sin procesar
    return objeto;
  }
}



function limpiarObjetoConst(){
  objetoconst = {};
}

// Función para calcular el promedio
function calcularPromedio(array) {
  if (Array.isArray(array) && array.length > 0) {
    const valores = array.filter(valor => valor !== 0); // Filtrar los valores diferentes de 0
    const promedio = valores.reduce((suma, valor) => suma + valor, 0) / valores.length;
    return promedio.toFixed(2);
  } else {
    return 'No disponible';
  }
}


// Generar tabla de promedios



