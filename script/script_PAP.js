
function loadTablePAP(page) {


    var demanda_table = document.getElementById('demanda_table');
    var div_PAP = document.getElementById("div_PAP");
    div_PAP.innerHTML = "";

    var mes1 = document.getElementById("mes1").value;
    var mes2 = document.getElementById("mes2").value;

    demanda_table.innerHTML = "";

    // console.log(page+"?products="+products);

    fetch(page + "?mes1=" + mes1 + "&mes2=" + mes2)
        .then(response => response.text())
        .then(data => {
            demanda_table.innerHTML = data;
        });
}
function calcularPAP() {


    console.log("calculando xd");

    var horasUnidad = document.getElementById("horasUnidad").valueAsNumber;
    var horasDia = document.getElementById("horasDia").valueAsNumber;

    var unidadesProducidas = document.getElementById("unidadesProducidas");
    unidadesProducidas.value = horasDia / horasUnidad;

    var costoMOhr = document.getElementById("costoMOhr");

    costoMOhr.value = document.getElementById("costoMO").valueAsNumber / document.getElementById("horasDia").valueAsNumber;





    var formulario = document.getElementById("form_demandaPAP");
    var parametros = new FormData(formulario);

    //Para cargarlo al grid
    var tablePAP = document.createElement("table");
    tablePAP.border = 1;
    tablePAP.innerHTML = "";

    var div_PAP = document.getElementById("div_PAP");
    div_PAP.innerHTML = "";



    fetch("../components/PAP/calcularPAP.php",
        {
            method: "POST",
            body: parametros
        })

        .then(response => response.text())
        .then(data => {

            objeto = JSON.parse(data);
            console.log(objeto);


            const tr_meses = document.createElement("tr");
            const tr_demanda = document.createElement("tr");
            const tr_dias = document.createElement("tr");
            const tr_uniTrab = document.createElement("tr");
            const tr_demandaDias = document.createElement("tr");
            const tr_demandaUnidad = document.createElement("tr");
            const tr_trabRequeridos = document.createElement("tr");
            const tr_trabDisponibles = document.createElement("tr");
            const tr_trabContratados = document.createElement("tr");
            const tr_trabDespedidos = document.createElement("tr");
            const tr_trabEmpleados = document.createElement("tr");
            const tr_costoContratacion = document.createElement("tr");
            const tr_costoDespido = document.createElement("tr");
            const tr_produccionHrNormal = document.createElement("tr");
            const tr_hrNormalNecesaria = document.createElement("tr");
            const tr_horaHorarioNormal = document.createElement("tr");
            // const tr_costoMO = document.createElement("tr");
            const tr_costoMOhrNormal = document.createElement("tr");

            const tr_horaExtraNecesaria = document.createElement("tr");
            const tr_costoHoraExtra = document.createElement("tr");
            const tr_unidadesSubcontratadas = document.createElement("tr");
            const tr_costoSubcontratacion = document.createElement("tr");
            const tr_unidadesProducidas = document.createElement("tr");
            const tr_inventario = document.createElement("tr");
            const tr_costoAlmacenamiento = document.createElement("tr");
            const tr_costoRotura = document.createElement("tr");
            const tr_costoUnidadProducida = document.createElement("tr");
            const tr_costosTotales = document.createElement("tr");



            tr_meses.innerHTML = `<th>Mes</th>`;
            tr_demanda.innerHTML = `<th>Demanda esperada</th>`;
            tr_dias.innerHTML = `<th>Dias de produccion</th>`;
            tr_uniTrab.innerHTML = `<th>Unidad/Trabajador</th>`;
            tr_demandaDias.innerHTML = `<th>Demanda/dia</th>`;
            tr_demandaUnidad.innerHTML = `<th>Demanda/unidad</th>`;
            tr_trabRequeridos.innerHTML = `<th>Trabajadores requerdidos</th>`;
            tr_trabDisponibles.innerHTML = `<th>Trabajadores Disponibles</th>`;
            tr_trabContratados.innerHTML = `<th>Trabajadores Contratados</th>`;
            tr_trabDespedidos.innerHTML = `<th>Trabajadores Despedidos</th>`;
            tr_trabEmpleados.innerHTML = `<th>Trabajadores Empleados</th>`;
            tr_costoContratacion.innerHTML = `<th>Costo de contratacion</th>`;
            tr_costoDespido.innerHTML = `<th>Costo de Despido</th>`;
            tr_produccionHrNormal.innerHTML = `<th>Produccion en Hr normal</th>`;
            tr_hrNormalNecesaria.innerHTML = `<th>Horas normal necesarias</th>`;
            tr_horaHorarioNormal.innerHTML = `<th>Hora en horario normal</th>`;
            // tr_costoMO.innerHTML =`<th>Costo MO</th>`;
            tr_costoMOhrNormal.innerHTML = `<th>Costo MO hora normal</th>`;
            tr_horaExtraNecesaria.innerHTML = `<th>Horas extra necesarias</th>`;
            tr_costoHoraExtra.innerHTML = `<th>Costo de hora extra</th>`;
            tr_unidadesSubcontratadas.innerHTML = `<th>Unidades Subcontratadas</th>`;
            tr_costoSubcontratacion.innerHTML = `<th>Costo de Subcontratacion</th>`;
            tr_unidadesProducidas.innerHTML = `<th>Unidades producidas</th>`;
            tr_inventario.innerHTML = `<th>inventario</th>`;
            tr_costoAlmacenamiento.innerHTML = `<th>Costo de almacenamiento</th>`;
            tr_costoRotura.innerHTML = `<th>Costo de rotura</th>`;
            tr_costoUnidadProducida.innerHTML = `<th>Costo de unidades producidas</th>`;
            tr_costosTotales.innerHTML = `<th>TOTAL</th>`;

            for (i = 0; i < objeto['demanda'].length; i++) {

                const th_meses = document.createElement("th");
                th_meses.innerHTML = `<div name="meses">${objeto['meses'][i]}<div>`;
                tr_meses.appendChild(th_meses);

                const td_demanda = document.createElement("td");
                td_demanda.innerHTML = `<div name="demanda">${objeto['demanda'][i]}<div>`;
                tr_demanda.appendChild(td_demanda);

                const td_dias = document.createElement("td");
                td_dias.innerHTML = `<div name="dias">${objeto['dias'][i]}<div>`;
                tr_dias.appendChild(td_dias);

                const td_uniTrab = document.createElement("td");
                td_uniTrab.innerHTML = `<div name="uniTrab">${objeto['unidadTrabajador'][i]}<div>`;
                tr_uniTrab.appendChild(td_uniTrab);

                const td_demandaDia = document.createElement("td");
                td_demandaDia.innerHTML = `<div name="demandaDia">${objeto['demandaDia'][i]}<div>`;
                tr_demandaDias.appendChild(td_demandaDia);

                const td_demandaUnidad = document.createElement("td");
                td_demandaUnidad.innerHTML = `<div name="demandaUnidad">${objeto['demandaUnidad'][i]}<div>`;
                tr_demandaUnidad.appendChild(td_demandaUnidad);

                const td_trabRequeridos = document.createElement("td");
                td_trabRequeridos.innerHTML = `<div name="trabRequeridos">${objeto['trabRequeridos'][i]}<div>`;
                tr_trabRequeridos.appendChild(td_trabRequeridos);

                const td_trabDisponibles = document.createElement("td");
                td_trabDisponibles.innerHTML = `<div name="trabDisponibles">${objeto['trabDisponibles'][i]}<div>`;
                tr_trabDisponibles.appendChild(td_trabDisponibles);

                const td_trabContratados = document.createElement("td");
                td_trabContratados.innerHTML = `<div name="trabContratados">${objeto['trabContratados'][i]}<div>`;
                tr_trabContratados.appendChild(td_trabContratados);

                const td_trabDespedidos = document.createElement("td");
                td_trabDespedidos.innerHTML = `<div name="trabDespedidos">${objeto['trabDespedidos'][i]}<div>`;
                tr_trabDespedidos.appendChild(td_trabDespedidos);

                const td_trabEmpleados = document.createElement("td");
                td_trabEmpleados.innerHTML = `<div name="trabDespedidos">${objeto['trabEmpleados'][i]}<div>`;
                tr_trabEmpleados.appendChild(td_trabEmpleados);

                const td_costoContratacion = document.createElement("td");
                td_costoContratacion.innerHTML = `<div name="costo">${objeto['costoContratacion'][i] + "$"}<div>`;
                tr_costoContratacion.appendChild(td_costoContratacion);

                const td_costoDespido = document.createElement("td");
                td_costoDespido.innerHTML = `<div name="costo">${objeto['costoDespido'][i] + "$"}<div>`;
                tr_costoDespido.appendChild(td_costoDespido);

                const td_produccionHrNormal = document.createElement("td");
                td_produccionHrNormal.innerHTML = `<div name="produccionHrNormal">${objeto['produccionHrNormal'][i]}<div>`;
                tr_produccionHrNormal.appendChild(td_produccionHrNormal);

                const td_hrNormalNecesaria = document.createElement("td");
                td_hrNormalNecesaria.innerHTML = `<div name="hrNormalNecesaria">${objeto['hrNormalNecesaria'][i]}<div>`;
                tr_hrNormalNecesaria.appendChild(td_hrNormalNecesaria);

                const td_horaHorarioNormal = document.createElement("td");
                td_horaHorarioNormal.innerHTML = `<div name="horaHorarioNormal">${objeto['horaHorarioNormal'][i]}<div>`;
                tr_horaHorarioNormal.appendChild(td_horaHorarioNormal);

                // const td_costoMO = document.createElement("td");
                // td_costoMO.innerHTML = `<div name="costo">${objeto['costoMO'][i]+"$"}<div>`;
                // tr_costoMO.appendChild(td_costoMO);

                const td_costoMOhrNormal = document.createElement("td");
                td_costoMOhrNormal.innerHTML = `<div name="costo">${objeto['costoMOhrNormal'][i] + "$"}<div>`;
                tr_costoMOhrNormal.appendChild(td_costoMOhrNormal);

                const td_horaExtraNecesaria = document.createElement("td");
                td_horaExtraNecesaria.innerHTML = `<div name="horaExtraNecesaria">${objeto['horaExtraNecesaria'][i]}<div>`;
                tr_horaExtraNecesaria.appendChild(td_horaExtraNecesaria);

                const td_costoHoraExtra = document.createElement("td");
                td_costoHoraExtra.innerHTML = `<div name="costo">${objeto['costoHoraExtra'][i] + "$"}<div>`;
                tr_costoHoraExtra.appendChild(td_costoHoraExtra);

                const td_unidadesSubcontratadas = document.createElement("td");
                td_unidadesSubcontratadas.innerHTML = `<div name="unidadesSubcontratadas">${objeto['unidadesSubcontratadas'][i]}<div>`;
                tr_unidadesSubcontratadas.appendChild(td_unidadesSubcontratadas);

                const td_costoSubcontratacion = document.createElement("td");
                td_costoSubcontratacion.innerHTML = `<div name="costo">${objeto['costoSubcontratacion'][i] + "$"}<div>`;
                tr_costoSubcontratacion.appendChild(td_costoSubcontratacion);

                const td_unidadesProducidas = document.createElement("td");
                td_unidadesProducidas.innerHTML = `<div name="unidadesProducidas">${objeto['unidadesProducidas'][i]}<div>`;
                tr_unidadesProducidas.appendChild(td_unidadesProducidas);

                const td_inventario = document.createElement("td");
                td_inventario.innerHTML = `<div name="unidadesProducidas">${objeto['inventario'][i]}<div>`;
                tr_inventario.appendChild(td_inventario);

                const td_costoAlmacenamiento = document.createElement("td");
                td_costoAlmacenamiento.innerHTML = `<div name="costo">${objeto['costoAlmacenamiento'][i] + "$"}<div>`;
                tr_costoAlmacenamiento.appendChild(td_costoAlmacenamiento);

                const td_costoRotura = document.createElement("td");
                td_costoRotura.innerHTML = `<div name="costo">${objeto['costoRotura'][i] + "$"}<div>`;
                tr_costoRotura.appendChild(td_costoRotura);

                const td_costoUnidadProducida = document.createElement("td");
                td_costoUnidadProducida.innerHTML = `<div name="costo">${objeto['costoUnidadProducida'][i] + "$"}<div>`;
                tr_costoUnidadProducida.appendChild(td_costoUnidadProducida);

                const td_costosTotales = document.createElement("td");
                td_costosTotales.innerHTML = `<div name="costo">${objeto['costosTotales'][i] + "$"}<div>`;
                tr_costosTotales.appendChild(td_costosTotales);
            }
            tr_meses.innerHTML += `<th><div id="total" name="total">Total</div></th>`;
            tr_demanda.innerHTML += `<td><div id="total" name="total">${objeto["totales"]["totalDemanda"]}</div></td>`;
            tr_dias.innerHTML += `<td><div id="total" name="total">${objeto["totales"]["totalDias"]}</div></td>`;
            tr_uniTrab.innerHTML += `<td><div id="total" name="total">${objeto["totales"]["totalUniTrab"]}</div></td>`;
            tr_demandaDias.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_demandaUnidad.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_trabRequeridos.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_trabDisponibles.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_trabContratados.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_trabDespedidos.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_trabEmpleados.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_costoContratacion.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoContratacion"] + "$"}</div></td>`;
            tr_costoDespido.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoDespido"] + "$"}</div></td>`;
            tr_produccionHrNormal.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_hrNormalNecesaria.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_horaHorarioNormal.innerHTML += `<td><div id="total" name="total"></div></td>`;
            // tr_costoMO.innerHTML +=`<td><div id="total" name="costo">${objeto["totales"]["totalcostoMO"]+"$"}</div></td>`;
            tr_costoMOhrNormal.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalcostoMOhrNormal"] + "$"}</div></td>`;
            tr_horaExtraNecesaria.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_costoHoraExtra.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoHoraExtra"] + "$"}</div></td>`;
            tr_unidadesSubcontratadas.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_costoSubcontratacion.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoSubcontratacion"] + "$"}</div></td>`;
            tr_unidadesProducidas.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_inventario.innerHTML += `<td><div id="total" name="total"></div></td>`;
            tr_costoAlmacenamiento.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoAlmacenamiento"] + "$"}</div></td>`;
            tr_costoRotura.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalCostoRotura"] + "$"}</div></td>`;
            tr_costoUnidadProducida.innerHTML += `<td><div id="costo" name="costo">${objeto["totales"]["totalCostoUnidadProducida"] + "$"}</div></td>`;
            tr_costosTotales.innerHTML += `<td><div id="total" name="costo">${objeto["totales"]["totalGeneral"] + "$"}</div></td>`;

            tablePAP.appendChild(tr_meses);
            tablePAP.appendChild(tr_demanda);
            tablePAP.appendChild(tr_dias);
            tablePAP.appendChild(tr_uniTrab);
            tablePAP.appendChild(tr_demandaDias);
            tablePAP.appendChild(tr_demandaUnidad);
            tablePAP.appendChild(tr_trabRequeridos);
            tablePAP.appendChild(tr_trabDisponibles);
            tablePAP.appendChild(tr_trabContratados);
            tablePAP.appendChild(tr_trabDespedidos);
            tablePAP.appendChild(tr_trabEmpleados);
            tablePAP.appendChild(tr_costoContratacion);
            tablePAP.appendChild(tr_costoDespido);
            tablePAP.appendChild(tr_produccionHrNormal);
            tablePAP.appendChild(tr_hrNormalNecesaria);
            tablePAP.appendChild(tr_horaHorarioNormal);
            // tablePAP.appendChild(tr_costoMO);
            tablePAP.appendChild(tr_costoMOhrNormal);
            tablePAP.appendChild(tr_horaExtraNecesaria);
            tablePAP.appendChild(tr_costoHoraExtra);
            tablePAP.appendChild(tr_unidadesSubcontratadas);
            tablePAP.appendChild(tr_costoSubcontratacion);
            tablePAP.appendChild(tr_unidadesProducidas);
            tablePAP.appendChild(tr_inventario);
            tablePAP.appendChild(tr_costoAlmacenamiento);
            tablePAP.appendChild(tr_costoRotura);
            tablePAP.appendChild(tr_costoUnidadProducida);
            tablePAP.appendChild(tr_costosTotales);

            div_PAP.appendChild(tablePAP);

            var costos = document.getElementsByName("costo");
            for (var i = 0; i < costos.length; i++) {
                costos[i].style.backgroundColor = "#ffb275";
            }


            var alternativa = parseInt(document.getElementById("alternativasPAP").value);
            genenerarInformePAP(alternativa);
        });


}
function genenerarInformePAP(alternativa) {

    console.log("la alternativa seleccionada es para esta: " + alternativa);

    var informe_PAP = document.getElementById('informe_PAP');
    informe_PAP.innerHTML = "";
    console.log(informe_PAP);
    var informe =`informe`;

    // switch (alternativa) {
    //     case 1:
    //         informe+=+alternativa+".php";
    //         break;
    //     case 2:
    //         informe+=+alternativa+".php";
    //         break;
    //     case 3:
    //         informe+=+alternativa+".php";
    //         break;
    //     case 4:
    //         informe+=+alternativa+".php";
    //         break;
    //     case 5:
    //         informe+=+alternativa+".php";
    //         break;
    // }


        var formulario = document.getElementById("form_demandaPAP");
        var parametros = new FormData(formulario);
        fetch("../components/PAP/informe1.php",
            {method: "POST",
            body: parametros})
            .then(response => response.text())
            .then(data => {
                informe_PAP.innerHTML = data
            });

}