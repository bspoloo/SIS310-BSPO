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
    var parametros = new FormData(document.getElementById("form_datosp"));
    
    fetch("../components/pronosticos/calcularPronosticos.php", {
        method: "POST",
        body: parametros
    })
    .then(response => response.text())
    .then(data => {
        try {
            objeto = JSON.parse(data);
            console.log(objeto);
            console.log(data);
        } catch (error) {
            console.error("Error al analizar la respuesta JSON:", error);
            
        }
    })
    .catch(error => {
        console.error("Error en la solicitud fetch:", error);
        // Manejar el error de la solicitud fetch, por ejemplo, mostrar un mensaje al usuario.
    });
}
