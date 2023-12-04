let myChart_pronosticos = null;
let gridInstance_rl = null;
let gridInstance_sed = null;
let gridInstance_ses = null;
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
      '<input type="text" name="proporcion" id="proporcion" required>' +
      '<label for="alcance">Alcance:</label>' +
      '<input type="number" name="alcance" id="alcance" required>';
  } else if (metodo === "suavisadoexponencialsimple") {
    // Opción para Suavizado Exponencial Simple (un input para alpha)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="text" name="alpha" id="alpha" required>';
  } else if (metodo === "suavisadoexponencialdoble") {
    // Opción para Suavizado Exponencial Doble (dos inputs para alpha y beta)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="text" name="alpha" id="alpha" required>' +
      '<label for="alcance">Alcance:</label>' +
      '<input type="number" name="alcance" id="alcance" required>';
  } else if (metodo === "winters") {
    // Opción para Winters (tres inputs para alpha, beta y gama)
    opcionesPronostico.innerHTML =
      '<label for="alpha">Alpha:</label>' +
      '<input type="text" name="alpha" id="alpha" required>' +
      '<label for="beta">Beta:</label>' +
      '<input type="text" name="beta" id="beta" required>' +
      '<label for="gama">Gama:</label>' +
      '<input type="text" name="gama" id="gama" required>';
  } else if (metodo === "promediomovilsimple") {
    // Opción para Promedio Móvil Simple (un input para n)
    opcionesPronostico.innerHTML =
      '<label for="n">Número de periodos (n):</label>' +
      '<input type="number" name="n" id="n" required>';
  } else if (metodo === "promediomovilponderado") {
    // Opción para Promedio Móvil Ponderado (inputs para n, pesos y alcance)
    opcionesPronostico.innerHTML =
      '<label for="n">Número de periodos (n):</label>' +
      '<input type="number" name="n" id="n" required>' +
      '<label for="pesos">Pesos (separados por comas):</label>' +
      '<input type="text" name="pesos" id="pesos" required>' +
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
              // {
              //   label: "Metodo de Winters",
              //   data: objetoconst.suavisadoexponencialdoble && objetoconst.suavisadoexponencialsimple.suavisadoexponencialdoble
              //     ? objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
              //     : [],
              //   borderColor: "rgb(255, 255, 0)",
              // },
            ],
          },
        });

       
        if (gridInstance_rl) {
          gridInstance_rl.destroy(); // Destruir la tabla existente si hay una
        }

        if (objetoconst.regresionlineal) {

         

          const longitudPronostico = objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado.length;
        
          console.log("Longitud de arraypronosticoajustado:", longitudPronostico);
          console.log("Longitud de demanda:", objetoconst.regresionlineal.demanda.length);
        
          gridInstance_rl = new gridjs.Grid({
            columns: [
              { name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "(M.E)" },
              { name: "pronostico ajustado" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" }
            ],  
            
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
            }),
          }).render(document.getElementById("rl_table"));
        }


        if (objetoconst.suavisadoexponencialsimple) {

          if (gridInstance_sed) {
            gridInstance_sed.destroy(); // Destruir la tabla existente si hay una
          }

          const longitudPronostico = objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple.length;
          
          gridInstance_sed= new gridjs.Grid({
        
            columns: [
              { name: "periodo" },
              { name: "demanda" },
              { name: "pronostico" },
              { name: "error" },
              { name: "error abs" },
              { name: "error cuadrático" },
              { name: "error %" }
              
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
                objetoconst.suavisadoexponencialsimple[0].erroresCuadraticos[index]
              ];
        
            })
        
          }).render(document.getElementById("sed_table"));;
        
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


function getValor(selector) {
  const elemento = document.getElementById(selector);
  if (elemento) {
    return elemento.value; 
  } else {
    return null;
  }
}

function limpiarObjetoConst(){
  objetoconst = {};
}