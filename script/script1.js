function loadTable_indices(page) {
    var products_table = document.getElementById('products_table');
    var products = document.getElementById("products").valueAsNumber;

    // console.log(page+"?products="+products);

    fetch(page + "?products=" + products)
        .then(response => response.text())
        .then(data => {
            products_table.innerHTML = data;
        });
}
function calcularIndices() {

    var tabla_indices_preferencia = document.getElementById('indices_preferencia');

    var costosVariable = document.getElementsByName("costosVariable");
    var utilidades = document.getElementsByName("utilidades");
    var rentabilidadVentas = document.getElementsByName("rentabilidadVentas");
    var indiceComercial = document.getElementsByName("indiceComercial");
    var contribucionUtilidad = document.getElementsByName("contribucionUtilidad");




    var formulario = document.getElementById("form_datos");
    var parametros = new FormData(formulario);
    fetch("../components/Indicadores de preferencia/calcularIndices.php",
        {
            method: "POST",
            body: parametros
        })

        .then(response => response.text())
        .then(data => {

            objeto = JSON.parse(data);
            console.log(objeto);
            console.log(data)

            if (costosVariable.length > 0) {

                console.log("ya esxiste costo variables");
                

                for(i =0; i<costosVariable.length;i++){

        
                    costosVariable[i].innerHTML = objeto['costosVariables'][i];
                    utilidades[i].innerHTML = objeto['utilidades'][i];
                    rentabilidadVentas[i].innerHTML = objeto['rentabilidadVentas'][i]*100+"%";
                    indiceComercial[i].innerHTML = objeto['indiceComercial'][i]*100+"%";
                    contribucionUtilidad[i].innerHTML = objeto['contribucionUtilidad'][i]*100+"%";

                }

            } else {
                const tr_costosVariables = document.createElement("tr");
                const tr_utilidades = document.createElement("tr");
                const tr_rentabilidadVentas = document.createElement("tr");
                const tr_indiceComercial = document.createElement("tr");
                const tr_contribucionUtilidad = document.createElement("tr");

                tr_costosVariables.innerHTML = `<td>Costos Variables</td>`;
                tr_utilidades.innerHTML = `<td>Utilidad</td>`;
                tr_rentabilidadVentas.innerHTML = `<td>Rentabilidad de ventas</td>`;
                tr_indiceComercial.innerHTML = `<td>Indice de comerciabilidad</td>`;
                tr_contribucionUtilidad.innerHTML = `<td>Margen de contribucion</td>`;


                for (i = 0; i < objeto['nombres'].length; i++) {

                    const td_costosVariables = document.createElement("td");
                    td_costosVariables.innerHTML = `<div name="costosVariable">${objeto['costosVariables'][i]}<div>`;
                    tr_costosVariables.appendChild(td_costosVariables);

                    const td_utilidades = document.createElement("td");
                    td_utilidades.innerHTML = `<div name="utilidades">${objeto['utilidades'][i]}<div>`;
                    tr_utilidades.appendChild(td_utilidades);

                    const td_rentabilidadVentas = document.createElement("td");
                    td_rentabilidadVentas.innerHTML = `<div name="rentabilidadVentas">${objeto['rentabilidadVentas'][i]}%<div>`;
                    tr_rentabilidadVentas.appendChild(td_rentabilidadVentas);

                    const td_indiceComercial = document.createElement("td");
                    td_indiceComercial.innerHTML = `<div name="indiceComercial">${objeto['indiceComercial'][i]}%<div>`;
                    tr_indiceComercial.appendChild(td_indiceComercial);

                    const td_constribicionUtilidad = document.createElement("td");
                    td_constribicionUtilidad.innerHTML = `<div name="contribucionUtilidad">${objeto['contribucionUtilidad'][i]}%<div>`;
                    tr_contribucionUtilidad.appendChild(td_constribicionUtilidad);

                }

                tr_costosVariables.innerHTML+=`<td><div id="totalCostosVariables" name="total">Total xd</div></td>`;
                tr_utilidades.innerHTML+=`<td><div id="totalUtilidades" name="total">Total xd</div></td>`;
                tr_rentabilidadVentas.innerHTML+=`<td><div id="totalRentavilidad" name="total">Total xd</div>%</td>`;
                tr_indiceComercial.innerHTML+=`<td><div id="totalIndice" name="total">Total xd</div>%</td>`;
                tr_contribucionUtilidad.innerHTML+=`<td><div id="totalContribucion" name="total">Total xd</div>%</td>`;

                tabla_indices_preferencia.appendChild(tr_costosVariables);
                tabla_indices_preferencia.appendChild(tr_utilidades);
                tabla_indices_preferencia.appendChild(tr_rentabilidadVentas);
                tabla_indices_preferencia.appendChild(tr_indiceComercial);
                tabla_indices_preferencia.appendChild(tr_contribucionUtilidad);
            }

            var total = document.getElementsByName("total");
                console.log(total);

                for(var j =0; j< total.length; j++){
                    total[j].innerHTML= objeto['totales'][j];
                }

        });
}


