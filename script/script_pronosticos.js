let myChart_pronosticos = null;
let gridInstance_pronosticos = null;
let objetoconst = {};

function loadTable_pronosticos(page) {
  var pronosticos_table = document.getElementById("form_pronosticos_table");

  var pronosticos = document.getElementById("pronosticos").valueAsNumber;
  console.log(page + "?pronosticos=" + pronosticos);
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
        // Opción para Regresión Lineal (un input para periodo)
        opcionesPronostico.innerHTML = '<label for="periodo">Período:</label>' +
            '<input type="number" name="periodo" id="periodo" required>';
    } else if (metodo === "suavisadoexponencialsimple") {
        // Opción para Suavizado Exponencial Simple (un input para alpha)
        opcionesPronostico.innerHTML = '<label for="alpha">Alpha:</label>' +
            '<input type="text" name="alpha" id="alpha" required>';
    } else if (metodo === "suavisadoexponencialdoble") {
        // Opción para Suavizado Exponencial Doble (dos inputs para alpha y beta)
        opcionesPronostico.innerHTML = '<label for="alpha">Alpha:</label>' +
            '<input type="text" name="alpha" id="alpha" required>' +
            '<label for="beta">Beta:</label>' +
            '<input type="text" name="beta" id="beta" required>';
    } else if (metodo === "winters") {
        // Opción para Winters (tres inputs para alpha, beta y gama)
        opcionesPronostico.innerHTML = '<label for="alpha">Alpha:</label>' +
            '<input type="text" name="alpha" id="alpha" required>' +
            '<label for="beta">Beta:</label>' +
            '<input type="text" name="beta" id="beta" required>' +
            '<label for="gama">Gama:</label>' +
            '<input type="text" name="gama" id="gama" required>';
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
          console.log(data);
          objeto = redondearJSON(objeto, 2);
          console.log(objeto);
  
          objetoconst = {
            ...objetoconst,
            [metodo]: objeto,
          };
          console.log(objeto);
          if (myChart_pronosticos) {
            myChart_pronosticos.destroy();
          }
          
        console.log(objetoconst);
        // Crear el gráfico
        myChart_pronosticos = new Chart(ctx, {
          type: "line",
          data: {
            labels: Array.from(Array(objeto.demanda.length+3).keys()),
            datasets: [
              {
                label: "Datos de la Demanda",
                data: objeto && objeto.demanda ? objeto.demanda : [],
                borderColor: "rgb(0, 0, 255)",
              },
              {
                label: "Promedio móvil simple",
                data: objetoconst.promediomovilsimple && objetoconst.promediomovilsimple.promediomovilsimple
                  ? [null, null, null, ...objetoconst.promediomovilsimple.promediomovilsimple]
                  : [],
                borderColor: "rgb(0, 255, 0)",
              },
              {
                label: "Regresión lineal",
                data: objetoconst.regresionlineal && objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado
                  ? objetoconst.regresionlineal.regresionlineal.arraypronosticoajustado
                  : [],
                borderColor: "rgb(255, 0, 0)",
              },              
              {
                label: "Suavizado exponencial simple",
                data: objetoconst.suavisadoexponencialsimple && objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple
                  ? objetoconst.suavisadoexponencialsimple.suavisadoexponencialsimple
                  : [],
                borderColor: "rgb(255, 165, 0)",
              },
              {
                label: "Metodo de Winters",
                data: objetoconst.suavisadoexponencialdoble && objetoconst.suavisadoexponencialsimple.suavisadoexponencialdoble
                  ? objetoconst.suavisadoexponencialdoble.suavisadoexponencialdoble
                  : [],
                borderColor: "rgb(255, 255, 0)",
              },
            ],
          },
        });

        // Crear la tabla utilizando GRID.js
        if (gridInstance_pronosticos) {
          gridInstance_pronosticos.destroy(); // Destruir la tabla existente si hay una
        }

        // if (objetoconst.regresionlineal) {
        //   gridInstance_pronosticos = new gridjs.Grid({
        //     columns: [
        //       { name: "periodo" },
        //       { name: "demanda" },
        //       { name: "pronostico" },
        //       { name: "(M.E)" },
        //       { name: "pronostico ajustado" },
        //       { name: "error" },
        //       { name: "error abs" },
        //       { name: "error %" },
        //     ],
        //     data: objeto.regresionlineal.demanda.map((value, index) => {
        //       return [
        //         index + 1,
        //         value,
        //         objeto.regresionlineal.arraypronostico[index],
        //         objeto.regresionlineal.multiplicadorEstacional[
        //           index % objeto.regresionlineal.multiplicadorEstacional.length
        //         ],
        //         objeto.regresionlineal.arraypronosticoajustado[index],
        //         objeto.regresionlineal[0].errores[index],
        //         objeto.regresionlineal[0].erroresAbsolutos[index],
        //         objeto.regresionlineal[0].erroresPorcentuales[index],
        //       ];
        //     }),
        //   }).render(document.getElementById("rl_table"));
        // }
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
      };
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
  