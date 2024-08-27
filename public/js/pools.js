// nextModalAdd
const nextModalAdd = (hideStep,showStep) => {
    console.log('nextModalAdd')

    // Antes de cambiar a la pantalla 2 validamos los campos obligatorios
    if(showStep == 2){
        // Verificamos que se haya seleccionado el Sponsor
        let sponsor = $("#sponsor_add_id").val()
        if( sponsor == '' ){

            // Regresamos a la pantalla 1
            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Sponsor',
                text: 'Por favor, selecciona un sponsor...',
            })
            return false
        }
        // Verificamos que se haya capturado el Título
        let titulo = $("#titulo").val()
        if( titulo == '' ){

            // Regresamos a la pantalla 1
            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Título',
                text: 'Por favor, captura el título...',
            })
            return false
        }
        // Verificamos que se haya capturado el SubTítulo
        let subtitulo = $("#subtitulo").val()
        if( subtitulo == '' ){

            // Regresamos a la pantalla 1
            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Subtítulo',
                text: 'Por favor, captura el subtítulo...',
            })
            return false
        }
        // Verificamos que se haya capturado la Fecha de Inicio
        let fecha_inicio = $("#fecha_inicio").val()
        if( fecha_inicio == '' ){

            // Regresamos a la pantalla 1
            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Fecha de Inicio',
                text: 'Por favor, captura la fecha de inicio...',
            })
            return false
        }
        // Verificamos que se haya capturado el Horario de Inicio
        let horario_inicio = $("#horario_inicio").val()
        if( horario_inicio == '' ){

            // Regresamos a la pantalla 1
            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Horario de Inicio',
                text: 'Por favor, captura la horario de inicio...',
            })
            return false
        }
    } // if

    // Antes de cambiar a la pantalla 3 validamos los campos obligatorios
    if(showStep == 3){
        let body_premios = $('#tblMatchAwardsAdd tbody').html()

        if (body_premios == '') {
            hideStep = ''
            showStep = 2

            Swal.fire({
                icon: 'warning',
                title: 'Premios',
                text: 'Por favor, agrega al menos un premio...',
            })
            return false
        }
    } // if

    // Antes de cambiar a la pantalla 4 validamos los campos obligatorios
    if(showStep == 4){
        let deporte = $("#sport_id_search").val()

        if (deporte == '') {
            hideStep = ''
            showStep = 3

            Swal.fire({
                icon: 'warning',
                title: 'Deporte',
                text: 'Por favor, selecciona al menos un deporte...',
            })
            return false
        }

        $("#divBracketsMatches").html('')
    } // if

    // Antes de cambiar a la pantalla 5 validamos los campos obligatorios
    if(showStep == 5){
        let body_partidos = $("#tblBracketsMatchesAdded tbody").html()
        let fieldset_buildyourform = $("#buildyourform").html()

        if (body_partidos == '' && fieldset_buildyourform == '') {
            hideStep = ''
            showStep = 4

            Swal.fire({
                icon: 'warning',
                title: 'Preguntas',
                text: 'Por favor, agrega al menos una pregunta...',
            })
            return false
        }
    } // if


    // Cerramos el modal activo y abrimos el modal de la siguiente pantalla
    $('#modal-add-'+hideStep).modal('hide');
    $('#modal-add-'+showStep).modal('show');

    $("#modal-add-"+showStep).addClass('scroll-vertical')

    // STEP 1 - localstorage
    if(hideStep == 1 && showStep == 2){

        var step1 = localStorage.getItem("pools_step1")
        console.log("step1: "+step1)

        arrStep1 = new Array()

        sponsor_id = $("#sponsor_id").val()
        titulo = $("#titulo").val()
        subtitulo = $("#subtitulo").val()
        fecha_inicio = $("#fecha_inicio").val()
        fecha_fin = $("#fecha_fin").val()

        console.log("arrStep1",arrStep1)

        if(step1==null){
            arrStep1.push({
                'sponsor_id':sponsor_id,
                'titulo':titulo,
                'subtitulo':subtitulo,
                'fecha_inicio':fecha_inicio,
                'fecha_fin':fecha_fin
            }) 

            console.log("arrStep1Add",arrStep1)
    
            localStorage.setItem('pools_step1', JSON.stringify(arrStep1))
        }else{
            
            arrStep1.push({
                'sponsor_id':sponsor_id,
                'titulo':titulo,
                'subtitulo':subtitulo,
                'fecha_inicio':fecha_inicio,
                'fecha_fin':fecha_fin
            }) 
            console.log("arrStep1Edit",arrStep1)

            localStorage.setItem('pools_step1', JSON.stringify(arrStep1))
        }
    }

    // STEP 2 - localstorage
    if(hideStep == 2 && showStep == 3){
        var step2 = localStorage.getItem("pools_step2")
        console.log("step2: "+step2)

        arrStep2 = new Array()

        // Premios
        var listPremios = document.getElementsByClassName("cantidades");
        var numPremios = listPremios.length; 
        console.log("numPremios: ",numPremios)

        var total = 0
        for(var i = 1; i <= numPremios; i++){

            cantidad = $("#award_"+i).val()
            premio_id = $("#physical_award_id_"+i).val()
            premio_titulo = $("#physical_award_title_"+i).val()

            arrStep2.push({
                'lugar':i,
                'cantidad':cantidad,
                'premio_id':premio_id,
                'premio_titulo':premio_titulo
            }) 

        }

        if(step2==null){
            localStorage.setItem('pools_step2', JSON.stringify(arrStep2))
        }else{

        }

    }

    // Obtenemos los matches para seleccionar
    if(hideStep == 3 && showStep == 4){
        getMatches()
    }

    // Obtenemos el resumen
    if(hideStep == 4 && showStep == 5){
        getResume()
    }

}

// addAward
const addAward = (id,op='') => {
    console.log('addAward');
    /*
    console.log(`
    id: ${id}
    op: ${op}
    `);
    */

    if(op == 'add'){
        op = 'Add';
    }
    if(op == 'edit'){
        op = 'Edit';
    }

    let lugar = 1;
    let lugar_add = $("#lugar_add").val();
    //console.log('lugar_add: ',lugar_add);

    if(lugar_add > 0){
        lugar = parseInt(lugar_add)+1;
    }

    

    let body_awards = `
    <tr>
        <td class="text-center" style="padding: .4rem">${lugar}°</td>
        <td style="padding: .4rem">
            <div class="form-group" style="margin: 0;">
                <input type="text" id="award_add_${lugar}" name="award_add_${lugar}" class="form-control cantidades" value="${id}" onchange="sumarAward(this.id)">
            </div>
        </td>
        <td class="text-center" style="padding: .4rem">
            <input type="hidden"  id="physical_award_add_id_${lugar}" name="physical_award_add_id_${lugar}" class="physical_award">
            <input type="hidden"  id="physical_award_add_title_${lugar}" name="physical_award_add_title_${lugar}" class="physical_title">
            <button type="button" id="btn_physical_award_add_${lugar}" class="btn btn-dark" onclick="physicalAwards(${lugar},'add')"><i class="fas fa-plus"></i> Premio físico</button>
        </td>
    </tr>
    `;

    // Actualizamos el último lugar de los premios
    $("#lugar_add").val(lugar);
    //$("#total_awards").val(lugar)

    // Pintamos los lugares
    $("#tblMatchAwards"+op+" tbody").append(body_awards);
    $("#modal-add-2").addClass('scroll-vertical')

    sumarAward('add');


}

// Step 1/5
// selectSponsor
const selectSponsor = (id,image_id,op='') => {
    //console.log('selectSponsor')

    // inputs
    $("#sponsor_"+op+"_id").val(id)
    $("#sponsor_"+op+"_image").val(image_id)
    // image
    $(".sponsor-"+op).removeClass('sport-selected')
    $("#sponsor_image_"+op+"_"+image_id).addClass('sport-selected')

}

// Step Add 2/5
const createAwards = (op='') => {
    console.log('createAwards')

    if(op == 'add'){
        op = 'Add'
    }
    if(op == 'edit'){
        op = 'Edit'
    }

    let total_awards = $("#total_awards").val()

    let lugar = 0;
    let lugar_add = $("#lugar_add").val();
    //console.log('lugar_add: ',lugar_add);

    if(lugar_add > 0){
        lugar = parseInt(lugar_add);
    }

    let body_awards = $("#tblMatchAwards"+op+" tbody").html()

    for (i=1; i<=total_awards; i++){

        lugar = lugar + 1;  

        body_awards += `
        <tr>
            <td class="text-center" style="padding: .4rem">${lugar}°</td>
            <td style="padding: .4rem">
                <div class="form-group" style="margin: 0;">
                    <input type="text" id="award_add_${lugar}" name="award_add_${lugar}" class="form-control cantidades" onchange="sumarAward(this.id)">
                </div>
            </td>
            <td class="text-center" style="padding: .4rem">
                <input type="hidden"  id="physical_award_add_id_${lugar}" name="physical_award_add_id_${lugar}" class="physical_award">
                <input type="hidden"  id="physical_award_add_title_${lugar}" name="physical_award_add_title_${lugar}" class="physical_title">
                <button type="button" id="btn_physical_award_add_${lugar}" class="btn btn-dark" onclick="physicalAwards(${lugar},'add')"><i class="fas fa-plus"></i> Premio físico</button>
            </td>
        </tr>
        `

        $("#lugar_add").val(lugar);
        //$("#total_awards").val(lugar)
    }

    
    $("#tblMatchAwards"+op+" tbody").html(body_awards)
    $("#modal-add-2").addClass('scroll-vertical')
}

const physicalAwards = id => {
    console.log('physicalAwards')
    console.log('id: '+id)

    $('#modal-physical-award').modal('show')

    $("#inputAwardID").val(id)

}

const selectAwardAdd = (award_id,award_title) => {
    console.log('selectAwardAdd')

    let input_id = $("#inputAwardID").val()

    $("#physical_award_add_id_"+input_id).val(award_id)
    $("#physical_award_add_title_"+input_id).val(award_title)
    $("#btn_physical_award_add_"+input_id).removeClass('btn-dark').addClass('btn-success')

    $('#modal-physical-award').modal('hide')

}

const sumarAward = (id = '') => {
    //console.log('sumarAward')
    //console.log('id: ',id)

    if(id != ''){
        console.log('entro a agragarle el atributo value al input de la cantidad')
        let input_cantidad =  $("#"+id).val()
        $("#"+id).attr('value',input_cantidad)
    }

    var cantidad = 0
    var total = 0

    // Awards
    var listAwards = document.getElementsByClassName("cantidades");

    var x = 1
    var input_old = ''
    var terminado = 0
    Array.prototype.forEach.call(listAwards, function(elemento) {
        //console.log("elemento_name: "+elemento.name)
        let input_name_cantidades = elemento.name

        //console.log('input_old: '+input_old)
        //console.log('input_name_cantidades: '+input_name_cantidades)
        if(input_name_cantidades == input_old){
            terminado = 1
        }

        if(x==1){
            input_old = input_name_cantidades
            //console.log('x: '+1)
            //console.log('input_old: '+input_old)
        }

        if(terminado == 0){
        
            cantidad = $("#"+input_name_cantidades).val()
            //console.log('cantidad: '+cantidad)

            if(cantidad != '' && cantidad > 0){        
                total = total + parseInt(cantidad)
                //console.log('total: '+total)
            }
getMatches
        }

        x++
        
    })
		
    // Colocar el resultado de la suma en el control "span".
    $('#awards').val(total)
    $('#cantidad_award').html(total)
}

const getMatches = () => {
    console.log('getMatches')

    var body_group = '';    

    $("#input:checkbox:checked").each(function() {
        if($(this).val() != 'on' ){
            match_id = $(this).val()
            match_name = $("#match_league_name_"+match_id).html()
            match_local_team = $("#match_local_team_name_"+match_id).html()
            match_visitor_team = $("#match_visitor_team_name_"+match_id).html()
            match_start_date = $("#match_start_date_"+match_id).html()

            
            console.log(`
                match_id: ${match_id}
                match_name: ${match_name}
                match_local_team: ${match_local_team}
                match_visitor_team: ${match_visitor_team}
                match_start_date: ${match_start_date}
            `)
            
            
            if(match_id != '' && match_id > 0){

                body_group += `
                <tr>
                    <td>${match_name}</td>
                    <td>${match_local_team}</td>
                    <td>${match_visitor_team}</td>
                    <td>${match_start_date}</td>
                    <td><input type="text" id="grupo_${match_id}" name="grupo[${match_id}]" class="form-control grupo-add"></td>
                    <td><input type="text" id="jornada_${match_id}" name="jornada[${match_id}]" class="form-control jornada-add"></td>
                </tr>
                `
            }
        }
    })

        
    $("#tblBracketsGroup tbody").html(body_group)

    $("#modal-add-4").addClass('scroll-vertical')
    
}

// Step Add 3/5
/*
 * It makes an ajax call to get the leagues, then it makes another ajax call to get the teams, then it
 * populates the select boxes with the results.
 */
// selectSportModal
const selectSportModal = (id,op) => {
    //console.log('selectSport')

    if(op == 'add'){
        $("#sport_id_search").val(id)
        $(".sport-search").removeClass('sport-selected')
        $("#sport_image_search_"+id).addClass('sport-selected')
    }
    if(op == 'edit'){
        $("#sport_id_search_edit").val(id)
        $(".sport-search-edit").removeClass('sport-selected')
        $("#sport_image_search_"+id+"_edit").addClass('sport-selected')
    }
    if(op == 'phases'){
        $("#sport_id_search_phases").val(id)
        $(".sport-search-phases").removeClass('sport-selected')
        $("#sport_image_search_"+id+"_phases").addClass('sport-selected')
    }

    $.ajax({
        url: '/brackets/leagues/'+id,
        type: 'GET',
        data: '',
        beforeSend: function() {
            $("#loading1").show();
            $("#loading-text-1").html('Procesando Ligas, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response_league){
            //console.log('success leagues')
            console.log(JSON.parse(response_league))
            
            data = JSON.parse(response_league)

            var input_league = '<option value="">Seleccionar</option>'

            data.forEach(response_data=>{
                var league_id = response_data.id
                var league_name = response_data.name
                var option_status_league = ''

                //if(league_id == league_edit_id){
                //    option_status_league = 'selected'
                //}

                input_league += `
                    <option value="${league_id}" ${option_status_league}>${league_name}</option>
                `
            })

            if(op == 'add'){
                $("#league_id").html(input_league);
            }
            if(op == 'edit'){
                $("#league_id_edit").html(input_league);
            }
            if(op == 'phases'){
                $("#league_id_phases").html(input_league);
            }
            
  
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })

}

// listarPools
const listarPools = (container) => {
    console.log('listarPools')

    // Realizamos la consulta de los brackets
    $.ajax({
        url: '/pools/list',
        type: 'GET',
        data: { },
        beforeSend: function() {
            $("#loading2").show();
            $("#loading-text-2").html('Procesando registros, espere un momento....');
        },
        complete: function() {
            $("#loading2").hide();
        },
        success: function(response_pools){
            console.log('success pools')
            console.log(JSON.parse(response_pools))
            
            data = JSON.parse(response_pools)

            let body_pools = ''
            var x = 1;

            let color_status1 = 'c-gray-light';
            let color_status2 = 'c-gray-light';
            let color_status3 = 'c-gray-light';


            data.forEach(response_data=>{

                if(response_data.status){
                    switch(response_data.status){
                        case 'open':
                            color_status1 = 'c-green';
                            color_status2 = 'c-gray-light';
                            color_status3 = 'c-gray-light';
                            icon_status = '<i class="fas fa-lock-open"></i>';
                            texto_status = 'abierta';
                            break;

                        case 'running':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-gray-light';
                            icon_status = '<i class="fas fa-lock-open"></i>';
                            texto_status = 'en curso';
                            break;
    
                        case 'finished':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-red';
                            icon_status = '<i class="fas fa-lock"></i>';
                            texto_status = 'finalizada';
                            break;

                        default:
                            color_status1 = 'c-green';
                            color_status2 = 'c-gray-light';
                            color_status3 = 'c-gray-light';
                            icon_status = '<i class="fas fa-lock-open"></i>';
                            texto_status = 'abierta';
                            break;
                    } // switch
                } // if

                // QUinielas Acumulativas
                if (container == 'tblCumulativePools' && response_data.status != 'finished' && response_data.is_cumulative == 1){
                    body_pools += `
                    <tr>
                        <td>${response_data.title}</td>
                        <td>${response_data.subtitle}</td>
                        <td>
                            <img id="sport_img_${response_data.sport_id}" src="/images/icons/${response_data.sport_id}.png" class="img-fluid mrg-lr-10 sport" width="20px">
                        </td>
                        <td class="text-center">
                                <i class="fas fa-circle ${color_status1}"></i><i class="fas fa-minus ${color_status2}"></i><i class="fas fa-circle ${color_status2}"></i><i class="fas fa-minus ${color_status3}"></i><i class="fas fa-circle ${color_status3}"></i><br>
                                ${response_data.status}
                        </td>
                        <td class="text-center">${response_data.limit_date}</td>
                        <td class="text-center">
                            <button class="btn" onclick="modalEdit(${response_data.id})" title="editar"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn" onclick="delPools(${response_data.id},'${container}')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                            <button class="btn" onclick="modalTiebreakers(${response_data.id})" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                            <button class="btn" onclick="chageSport(${response_data.id})" title="cambiar icono deporte"><?= $_icon_sport ?></button>
                            <button class="btn" onclick="chageStatus(${response_data.id})" title="cambiar estatus">${icon_status}</button>
                        </td>
                    </tr>
                    `
                }

                if (container == 'tblPools' && response_data.status != 'finished' && response_data.is_cumulative == 0){
                    body_pools += `
                    <tr>
                        <td>${response_data.title}</td>
                        <td>${response_data.subtitle}</td>
                        <td>
                            <img id="sport_img_${response_data.sport_id}" src="/images/icons/${response_data.sport_id}.png" class="img-fluid mrg-lr-10 sport" width="20px">
                        </td>
                        <td class="text-center">
                                <i class="fas fa-circle ${color_status1}"></i><i class="fas fa-minus ${color_status2}"></i><i class="fas fa-circle ${color_status2}"></i><i class="fas fa-minus ${color_status3}"></i><i class="fas fa-circle ${color_status3}"></i><br>
                                ${response_data.status}
                        </td>
                        <td class="text-center">${response_data.limit_date}</td>
                        <td class="text-center">
                            <button class="btn" onclick="modalEdit(${response_data.id})" title="editar"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn" onclick="delPools(${response_data.id},'${container}')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                            <button class="btn" onclick="modalTiebreakers(${response_data.id})" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                            <button class="btn" onclick="chageSport(${response_data.id})" title="cambiar icono deporte"><?= $_icon_sport ?></button>
                            <button class="btn" onclick="chageStatus(${response_data.id})" title="cambiar estatus">${icon_status}</button>
                        </td>
                    </tr>
                    `
                }

                if (container == 'tblPoolsFinished' && response_data.status != 'finished'){
                    body_pools += `
                    <tr>
                        <td>${response_data.title}</td>
                        <td>${response_data.subtitle}</td>
                        <td>
                            <img id="sport_img_${response_data.sport_id}" src="/images/icons/${response_data.sport_id}.png" class="img-fluid mrg-lr-10 sport" width="20px">
                        </td>
                        <td class="text-center">
                                <i class="fas fa-circle ${color_status1}"></i><i class="fas fa-minus ${color_status2}"></i><i class="fas fa-circle ${color_status2}"></i><i class="fas fa-minus ${color_status3}"></i><i class="fas fa-circle ${color_status3}"></i><br>
                                ${response_data.status}
                        </td>
                        <td class="text-center">${response_data.limit_date}</td>
                        <td class="text-center">
                            <button class="btn" onclick="modalEdit(${response_data.id})" title="editar"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn" onclick="delPools(${response_data.id},'${container}')" title="eliminar"><i class="far fa-trash-alt"></i></button>

                            <button class="btn" onclick="modalTiebreakers(${response_data.id})" title="calificar preguntas"><i class="fas fa-list-ul"></i></button>
                            <button class="btn" onclick="chageSport(${response_data.id})" title="cambiar icono deporte"><?= $_icon_sport ?></button>
                            <button class="btn" onclick="chageStatus(${response_data.id})" title="cambiar estatus">${icon_status}</button>
                        </td>
                    </tr>
                    `
                }

                x++
            })

            // Pintamos los registros en la tabla
            $("#"+container+" tbody").html(body_pools);

        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })

}


// listarBracketsMatches dentro de los Steps
const listarBracketsMatches = (op='') => {
    console.log('listarBracketsMatches')

    let selectedDivInicial = ''
    let selectedDiv = 'Add'
    let selectedModal = ''
    let showMoal = 'add'
    let tableAdded = 'tblBracketsMatchesAdded'

    if(op == 'Edit'){
        selectedDivInicial = 'Edit'
        selectedDiv = 'Edit'
        selectedModal = '_edit'
        showMoal = 'edit'
        tableAdded = 'tblBracketsMatchesEditAdded'
    }

    if(op == 'Phases'){
        selectedDivInicial = 'Phases'
        selectedDiv = 'Phases'
        selectedModal = '_phases'
        showMoal = 'phases'
        tableAdded = 'tblBracketsMatchesPhasesEdit'
    }

    let divTable = $("#divBracketsMatches"+selectedDivInicial)
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblBracketsMatches${selectedDiv}" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Liga</th>
                <th>Local</th>
                <th>Visitante</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    `
    divTable.append(table)

    // recuperamos las variables para la consulta
    let sport_id = $("#sport_id_search"+selectedModal).val()
    let league_id = $("#league_id"+selectedModal).val()
    let date = $("#start_date_search"+selectedModal).val()

    if(sport_id != '' && sport_id > 0) {

        if(date != ''){
            // Realizamos la consulta por el Deporte y la Fecha
            $.ajax({
                url: '/matches/date',
                type: 'GET',
                data: { 
                    "sport_id" : sport_id, 
                    "date" : date
                },
                beforeSend: function() {
                    $("#loading2").show();
                    $("#loading-text-2").html('Procesando registros, espere un momento....');
                },
                complete: function() {
                    $("#loading2").hide();
                },
                success: function(response_matches){
                    console.log('success matches date')
                    console.log(JSON.parse(response_matches))
                    
                    data = JSON.parse(response_matches)

                    let body_matches = ''
                    var x = 1;

                    data.forEach(response_data=>{
                        console.log(response_data);
                        var res_fecha_edit = ''
                        var res_horario_edit = ''
                        if(response_data.start_date != '' && response_data.start_date != null){
                            [res_fecha_edit,res_horario_edit] = response_data.start_date.split('T')
                        }

                        let nombre_liga = '';
                        // Validamos que exista una liga
                        if(response_data.league != null){
                            nombre_liga = response_data.league.name
                        }

                        // Armamos los partidos
                        body_matches += `
                        <tr>
                            <td class="text-center" style="padding: 0.4rem; ">
                                <input type="checkbox" id="match_id_${x}" name="match_id[${x}]" class="matches-add" value="${response_data.id}" onclick="addMatch('${tableAdded}',${x},${response_data.id},'${nombre_liga}','${response_data.local_team.name}','${response_data.visitor_team.name}','${response_data.start_date}')" >
                            </td>
                            <td style="padding: 0.4rem;" id="match_league_name_${response_data.id}">${nombre_liga}</td>
                            <td style="padding: 0.4rem;" id="match_local_team_name_${response_data.id}">${response_data.local_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_visitor_team_name_${response_data.id}">${response_data.visitor_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_start_date_${response_data.id}">${response_data.start_date}</td>
                        </tr>
                        `
                        console.log(body_matches);

                        x++
                    })

                    // Pintamos los registros en la tabla
                    $("#tblBracketsMatches"+selectedDiv+" tbody").html(body_matches);
                    $("#matches_status").val('add')
                    
                    let cantidad = 100

                    // Agregamos el datatable
                    $("#tblBracketsMatches"+selectedDiv).DataTable({
                        "responsive": true, 
                        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                        "lengthChange": false, 
                        "autoWidth": false,
                        "scrollX": false,
                        "stateSave": false,
                        'pageLength': cantidad,
                        
                        
                    });

                    $("#modal-"+showMoal+"-3").addClass('scroll-vertical')
        
                },
                error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                }
            })

        }else{
            if(league_id != '' && league_id > 0){
                // Realizamos la consulta por el Deporte y la Liga
                $.ajax({
                    url: '/matches/league',
                    type: 'GET',
                    data: { 
                        "sport_id" : sport_id, 
                        "league_id" : league_id
                    },
                    beforeSend: function() {
                        $("#loading2").show();
                        $("#loading-text-2").html('Procesando registros, espere un momento....');
                    },
                    complete: function() {
                        $("#loading2").hide();
                    },
                    success: function(response_matches){
                        console.log('success matches league')
                        //console.log(JSON.parse(response_matches))
                        
                        data = JSON.parse(response_matches)

                        let body_matches = ''
                        var x = 1;

                        data.forEach(response_data=>{
                            var res_fecha_edit = ''
                            var res_horario_edit = ''
                            if(response_data.start_date != '' && response_data.start_date != null){
                                [res_fecha_edit,res_horario_edit] = response_data.start_date.split('T')
                            }

                            let nombre_liga = '';
                            // Validamos que exista una liga
                            if(response_data.league != null){
                                nombre_liga = response_data.league.name
                            }
    
                            // Armamos los partidos

                            body_matches += `
                            <tr>
                                <td class="text-center" style="padding: 0.4rem; ">
                                    <input type="checkbox" id="match_id_${x}" name="match_id[${x}]" class="matches-add" value="${response_data.id}" onclick="addMatch('${tableAdded}',${x},${response_data.id},'${nombre_liga}','${response_data.local_team.name}','${response_data.visitor_team.name}','${response_data.start_date}')" >
                                </td>
                                <td style="padding: 0.4rem;" id="match_league_name_${response_data.id}">${nombre_liga}</td>
                                <td style="padding: 0.4rem;" id="match_local_team_name_${response_data.id}">${response_data.local_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_visitor_team_name_${response_data.id}">${response_data.visitor_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_start_date_${response_data.id}">${response_data.start_date}</td>
                            </tr>
                            `
                            x++
                        })

                        // Pintamos los registros en la tabla
                        $("#tblBracketsMatches"+selectedDiv+" tbody").html(body_matches);
                        $("#matches_status").val('add')
                        
                        let cantidad = 200

                        // Agregamos el datatable
                        $("#tblBracketsMatches"+selectedDiv).DataTable({
                            "responsive": true, 
                            "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                            "lengthChange": true, 
                            "autoWidth": false,
                            "scrollX": false,
                            "stateSave": false,
                            'pageLength': cantidad,
                            
                            
                        });

                        $("#modal-"+showMoal+"-3").addClass('scroll-vertical')
            
                    },
                    error: function (obj, error, objError){
                    var error = objError
                    console.log('Error al obtener el resultado. '+ error)
                    }
                })
            } // END if league_id
        } // END else date

    } // END if sport_id
}   

// Step Add 4/5
const createTiebreakers = (op='') => {
    console.log('createTiebreakers')
    //agrega las preguntas
    var intId = $("#buildyourform"+op+"  div").length + 1;
    var fieldWrapper = $('<div class="form-group" role="list" id="field' + intId + '">');
    var fieldInputGroup = $('<div class="input-group">');
    var fName = $('<input type="text" name="pregunta[' + intId + ']" class="fieldname form-control pregunta" placeholder="Pregunta" required >');
    var subWrapper = $('<fieldset id="subwrapper' + intId + '">');

    var newButton = $('<div class="input-group-append"><button type="button" class="new btn btn-success btn-sm input-group-text" id="new' + intId + '"><i class="fas fa-plus"></i></button></div>');
    newButton.click(function() {

        //grupo para las opiones
        var Id = $("#subwrapper" + intId + " aside").length + 1;

        var subfield = $('<aside class ="col-md-8 mt-1" id="subfield' + Id + '"/>');
        var subfieldInputGroup = $('<div class="input-group" role="list">');
        var Name = $('<input type="text" name ="opcion_' + intId + '[' + Id + ']" class="form-control opcion_' + intId + '" placeholder=" Opción" required>');
        var value = $('<input type="radio" name="valor' + intId + '" value ="' + Id + '" class="form-check-input">');

        //elimina una opcion específica
        var removeButton1 = $('<div class="input-group-append"><button type="button" class="remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button></div>');

        removeButton1.click(function() {
        $(this).parent().remove();
        });

        subWrapper.append(subfield);
        subfield.append(subfieldInputGroup);
        //subfieldInputGroup.append(value);
        subfieldInputGroup.append(Name);
        subfieldInputGroup.append(removeButton1);
        //subfield.append(subdato);

        $("#subwrapper" + intId).append(subfield);

    });

    //elimina una pregunta específica
    var removeButton = $('<div class="input-group-append"><button type="button" id="remove' + intId + '" class="remove btn btn-danger btn-sm input-group-text"><i class="far fa-trash-alt"></i></button></div>');
    removeButton.click(function() {
        $(this).parent().remove();
    });

    fieldWrapper.append(fieldInputGroup);
    fieldInputGroup.append(fName)
    fieldInputGroup.append(newButton);
    fieldInputGroup.append(removeButton);
    fieldWrapper.append(subWrapper);
    //fieldWrapper.append(dato);

    $("#buildyourform"+op).append(fieldWrapper);

}
$(document).ready(function() {
    $(".remove").click(function() {
        $(this).parent().remove();
    })

})

// Eliminar pregunta y respuestas de los tiebreakers cuando se edita
$('#buildyourformedit').on('click', '.remove-question', function() {
    $(this).parent().remove();
});

$('#buildyourformedit').on('click', '.remove-answer', function() {
    $(this).parent().remove();
});


// Eliminar pregunta y respuestas de los tiebreakers cuando se edita
$('#buildyourformphases').on('click', '.remove-question-phases', function() {

    let tiebreaker_id = $(this).attr("data-id");
    console.log('tiebreaker_id: ',tiebreaker_id)

    Swal.fire({
        title: '¿Deseas borrar esta pregunta?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
    }).then((result) => {
        if (result.isConfirmed) {

            $(this).parent().remove();

            $.ajax({
                url: '/pools/delete_tiebreaker',
                type: 'POST',
                data: { 
                    "tiebreaker_id" : tiebreaker_id,
                },
                success: function(response){
                    //console.log('success matches delete')
                    //console.log(JSON.parse(response))

                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: 'Su pregunta ha sido eliminada...',
                    })
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
        
        }
    })
});

$('#buildyourformphases').on('click', '.remove-answer-phases', function() {
    $(this).parent().remove();
});

// Step Add 5/5
const getResume = () => {
    console.log('getResume')

    let titulo = $('#titulo').val()
    let subtitulo = $('#subtitulo').val()
    let fecha_inicio = $('#fecha_inicio').val()

    let sponsor_id = $('#sponsor_add_id').val()
    let sponsor = $('#sponsor_image_add_resume').attr('src')
    let sponsor_img = sponsor+sponsor_id+'.png'

    let sport_id = $('#sport_id_search').val()
    let sport = $('#sport_image_add_resume').attr('src')
    let sport_img = sport+sport_id+'.png'

    let partido_liga = ''
    let partido_local = ''
    let partido_visitante = ''
    let partido_fecha = ''
    let partido_grupo = ''
    let partido_jornada = ''
    let body_partidos = ''

    // Partidos
    var resume_table = document.getElementById("tblBracketsMatchesAdded");

    for (var i = 1, row; row = resume_table.rows[i]; i++) {
        /*
        // Recorrer celdas
        for (var j = 0, col; col = row.cells[j]; j++) {
            console.log(`Txt: ${col.innerText} \tFila: ${i} \t Celda: ${j}`)
        }
        */
        
        match_selected = row.cells[0].getElementsByTagName('input')[0].checked
        partido_liga = row.cells[1].innerText
        partido_local = row.cells[2].innerText
        partido_visitante = row.cells[3].innerText
        partido_fecha = row.cells[4].innerText

        console.log('match_selected: ',match_selected)
        //console.log('partido_liga',partido_liga)

        if(match_selected == true){
            body_partidos += `
            <tr style="border-top: 2px solid #333;">
                <td><span class="text-bold">Local:</span> ${partido_local}</td>
                <td><span class="text-bold">Visitante:</span> ${partido_visitante}</td>
            </tr>
            <tr>
                <td style="border: none;"><span class="text-bold">Liga:</span> ${partido_liga}</td>
                <td style="border: none;"><span class="text-bold">Fecha:</span> ${partido_fecha}</td>
            </tr>
            `
        }

    }

    $('#partidos_resume tbody').html(body_partidos)

    // Premios
    var listAwards = document.getElementsByClassName("cantidades");

    var x = 1
    var input_old = ''
    var terminado = 0
    var body_premios = ''
    Array.prototype.forEach.call(listAwards, function(elemento) {
        //console.log("elemento_name: "+elemento.name)
        let input_name_cantidades = elemento.name

        //console.log('input_old: '+input_old)
        //console.log('input_name_cantidades: '+input_name_cantidades)
        if(input_name_cantidades == input_old){
            terminado = 1
        }

        if(x==1){
            input_old = input_name_cantidades
            //console.log('x: '+1)
            //console.log('input_old: '+input_old)
        }

        if(terminado == 0){
        
            cantidad = $("#"+input_name_cantidades).val()
            //console.log('cantidad: '+cantidad)

            body_premios += `
            <tr>
                <td>${x}°</td>
                <td>$ ${cantidad}</td>
                <td></td>
                </td>
            </tr>
            `
        }

        x++
        
    })

    $('#premios_resume tbody').html(body_premios)


    // Preguntas
    var listPreguntas = document.getElementsByClassName("pregunta");

    var body_preguntas = ''

    Array.prototype.forEach.call(listPreguntas, function(elemento) {
        //console.log("elemento_name: "+elemento.name)
        //console.log("elemento_value: "+elemento.value)

        let input_pregunta_id = elemento.name.slice(9,-1)
        let input_pregunta_valor = elemento.value

        //console.log("input_pregunta_id: ", input_pregunta_id)
        //console.log("input_pregunta_valor: ", input_pregunta_valor)

        body_preguntas += `
        <tr>
            <td style="background: #CCCCCC; ">${input_pregunta_valor}</td>
        </tr>
        `

        // Respuestas Preguntas
        var listRespuestas = document.getElementsByClassName("opcion_"+input_pregunta_id);

        Array.prototype.forEach.call(listRespuestas, function(elemento2) {
            //console.log("elemento_name: "+elemento2.name)
            //console.log("elemento_value: "+elemento2.value)

            let input_respuesta_valor = elemento2.value

            body_preguntas += `
            <tr>
                <td>${input_respuesta_valor}</td>
            </tr>
            `    
        })

    })

    $('#preguntas_resume tbody').html(body_preguntas)


    // Mostramos el resumen
    $('#titulo_resume').html(titulo)
    $('#subtitulo_resume').html(subtitulo)
    $('#fecha_inicio_resume').html(fecha_inicio)

    $('#sponsor_image_add_resume').attr('src',sponsor_img)
    $('#sport_image_add_resume').attr('src',sport_img)

    $("#modal-add-5").addClass('scroll-vertical')

}

// Guardamos la quiniela creada
const save = () => {
    console.log('save')

    $('#frmPoolAdd').submit()

    localStorage.removeItem("pools_step1")
    localStorage.removeItem("pools_step2")
}

// delPools
const delPools = (id,container) => {
    //console.log('delPools')

    console.log(`
    pool_id: ${id}
    `)

    Swal.fire({
        title: '¿Deseas borrar este registro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/pools/delete',
                type: 'POST',
                data: { 
                    "pool_id" : id,
                },
                success: function(response){
                    //console.log('success matches delete')
                    //console.log(JSON.parse(response))

                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: 'Su registro ha sido eliminada...',
                    })

                    listarPools(container)
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
        
        }
    })
}

// Open modal Edit
const modalEdit = pool_id => {
    console.log('modalEdit')

    $.ajax({
        url: '/pools/list_pools/'+pool_id,
        type: 'GET',
        data: '',
        beforeSend: function() {
            $("#loading1").show();
            $("#loading-text-1").html('Procesando, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response){
            console.log('success')
            console.log(JSON.parse(response))
            
            data = JSON.parse(response)
            //console.log(data)

            // Step 1
            // Datos generales del bracket
            let arrLimitDate = data.limit_date.split("T");

            $("#pool_edit_id").val(data.id)

            // TEST
            if(data.test == 0){
                $('input[name="test_edit"]').bootstrapSwitch('state', false, false)
            }
            if(data.test == 1){
                $('input[name="test_edit"]').bootstrapSwitch('state', true, true)
            }

            // VIP
            if(data.is_vip == 0){
                $('input[name="vip_edit"]').bootstrapSwitch('state', false, false)
            }
            if(data.is_vip == 1){
                $('input[name="vip_edit"]').bootstrapSwitch('state', true, true)
            }
            

            $("#titulo_edit").val(data.title)
            $("#subtitulo_edit").val(data.subtitle)
            $("#fecha_inicio_edit").val(arrLimitDate[0])
            $("#horario_inicio_edit").val(arrLimitDate[1])
            $("#multiplicador_edit").val(data.multiplier)

            $("#titulo_edit_old").val(data.title)
            $("#subtitulo_edit_old").val(data.subtitle)
            $("#fecha_inicio_edit_old").val(arrLimitDate[0])
            $("#horario_inicio_edit_old").val(arrLimitDate[1])
            $("#multiplicador_edit_old").val(data.multiplier)

            // inputs
            $("#sponsor_edit_id").val(data.sponsor.id)
            $("#sponsor_edit_image").val(data.sponsor.s3_file_id)
            
            $("#sponsor_edit_id_old").val(data.sponsor.id)
            
            // image
            $(".sponsor-edit").removeClass('sport-selected')
            $("#sponsor_image_edit_"+data.sponsor.s3_file_id).addClass('sport-selected')

            $('#modal-edit-1').modal('show');

            // Step 2
            // Premios
            let arrAwardsFirst = data.awards.substring(1);
            let arrAwardsLast = arrAwardsFirst.substring(0, arrAwardsFirst.length - 1)
            let arrAwards = arrAwardsLast.split("-");
            //console.log(arrAwards)
            let total_premios = arrAwards.length

            $("#total_awards_edit").val(total_premios)
            $("#cantidad_award_edit").html(data.award)
            $("#awards_edit").val(data.award)

            let body_awards = ''
            let body_awards_resume = ''

            for (let i=0;i< total_premios; i++){

                awardNumber1 = arrAwards[i].replace(/[$,]/g, "");
                awardNumber = parseInt(awardNumber1)
                //console.log(parseInt(awardNumber1))

                //console.log('awardNumber: '+awardNumber)
                //console.log(data.physical_awards)

                //Buscamos el premio físico
                let premio_fisico = data.physical_awards.find(element => element.place === i+1);
                //console.log("premio_fisico: ", premio_fisico)

                let premio_id = ''
                let premio_title = ''
                let btn_award = 'btn-dark'

                if(typeof premio_fisico !== 'undefined'){
                    //console.log(i+1)
                    console.log(premio_fisico.premio.id)
                    premio_id = premio_fisico.premio.id
                    premio_title = premio_fisico.premio.title
                    btn_award = 'btn-success'
                }

                // Armamos los premios
                body_awards += `
                <tr>
                    <td class="text-center" style="padding: .4rem">${i+1}°</td>
                    <td style="padding: .4rem">
                        <div class="form-group" style="margin: 0;">
                            <input type="text" id="award_edit_${i+1}" name="award_edit_${i+1}" class="form-control cantidades" value="${awardNumber}" 
                            `
                            if(data.monetary_awards == true){
                                body_awards += ` onchange="sumarAward('edit')">`
                            }else{
                                body_awards += ` >`
                            }
                            body_awards += `
                            <input type="hidden" id="award_edit_old_${i+1}" name="award_edit_old_${i+1}" class="form-control" value="${awardNumber}"> 
                        </div>
                    </td>
                    <td class="text-center" style="padding: .4rem">
                        <input type="hidden"  id="physical_award_edit_id_${i+1}" name="physical_award_edit_id_${i+1}" class="physical_award" value="${premio_id}">
                        <input type="hidden"  id="physical_award_edit_title_${i+1}" name="physical_award_edit_title_${i+1}" class="physical_title" value="${premio_title}">
                        <button type="button" id="btn_physical_award_edit_${i+1}" class="btn ${btn_award}" onclick="physicalAwards(${i+1},'edit')"><i class="fas fa-plus"></i> Premio físico</button>

                        <input type="hidden"  id="physical_award_edit_old_id_${i+1}" name="physical_award_edit_old_id_${i+1}" class="physical_award" value="${premio_id}">
                        <input type="hidden"  id="physical_award_edit_old_title_${i+1}" name="physical_award_edit_old_title_${i+1}" class="physical_title" value="${premio_title}">
                    </td>
                </tr>
                `

                body_awards_resume += `
                <tr>
                    <td>${i+1}°</td>
                    <td>${awardNumber}</td>
                </tr>
                `
            }

            $("#tblMatchAwardsEdit tbody").html(body_awards)
            $("#modal-edit-2").addClass('scroll-vertical')

            // Step 3

            // Quiniela Normal
            //console.log('is_cumulative', data.is_cumulative)
            if(data.is_cumulative == 0){

                $('input[name="is_cumulative_edit"]').bootstrapSwitch('state', false, false)
                $("#cumulative_phase_edit").attr('style','display: none')

                // inputs
                $("#phase_name_edit").val('')
                
                $("#fecha_inicio_cumulative_edit").val('')
                $("#horario_inicio_cumulative_edit").val('')

                $("#fecha_fin_cumulative_edit").val('')
                $("#horario_fin_cumulative_edit").val('')

                // inputs old
                $("#phase_name_edit_old").val('')
                
                $("#fecha_inicio_cumulative_edit_old").val('')
                $("#horario_inicio_cumulative_edit_old").val('')

                $("#fecha_fin_cumulative_edit_old").val('')
                $("#horario_fin_cumulative_edit_old").val('')
            }

            // Quiniela Acumulativa
            if(data.is_cumulative == 1){

                $('input[name="is_cumulative_edit"]').bootstrapSwitch('state', true, true)
                $("#cumulative_phase_edit").attr('style','display: block')

                // inputs
                $("#phase_name_edit").val(data.pool_phases.actual.name)

                let [start_date_cumulative,start_time_cumulative] = data.pool_phases.actual.start_date.split('T')
                $("#fecha_inicio_cumulative_edit").val(start_date_cumulative)
                $("#horario_inicio_cumulative_edit").val(start_time_cumulative)

                let [end_date_cumulative,end_time_cumulative] = data.pool_phases.actual.end_date.split('T')
                $("#fecha_fin_cumulative_edit").val(end_date_cumulative)
                $("#horario_fin_cumulative_edit").val(end_time_cumulative)

                // inputs old
                $("#phase_name_edit_old").val(data.pool_phases.actual.name)

                $("#fecha_inicio_cumulative_edit_old").val(start_date_cumulative)
                $("#horario_inicio_cumulative_edit_old").val(start_time_cumulative)

                $("#fecha_fin_cumulative_edit_old").val(end_date_cumulative)
                $("#horario_fin_cumulative_edit_old").val(end_time_cumulative)
            }

            
            // Sport and Matches
            let league_id = ''
            let sport_id = ''
            let arr_matches = ''
            let arr_matches2 = ''
            let x = 1


            // Eliminamos el step3 para crearlo de cero
            localStorage.removeItem("step3")

            // Eliminamos el step3_detail para crearlo de cero
            localStorage.removeItem("step3_detail")

            // Guardamos el step 3 detail
            var step3_detail = localStorage.getItem("step3_detail")
            //console.log("step3_detail: "+step3_detail)

            // Buscamos el step 3
            var step3 = localStorage.getItem("step3")
            console.log("step3: "+step3)


            arrStep3 = new Array()
            arrStep3Detail = new Array()
            let body_match_resume = ''
            let body_matches = ''
            let string_match = ''

            console.log('matches')
            console.log(data.matches)

            let total_matches = data.matches.length
            console.log('total_matches: ',total_matches)

            league_id = ''
            sport_id = ''
            //$("#matches_status").val('add')

            let divTable = $("#divBracketsMatchesEditAdded")
            divTable.html("")
        
            // Creamos la tabla dentro del div
            table = `
            <table id="tblBracketsMatchesEditAdded" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Liga</th>
                        <th>Local</th>
                        <th>Visitante</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            `
        
            divTable.append(table)


            if(total_matches > 0){


                // Es donde buscamos los partidos
                Object.entries(data.matches).forEach(([key, obj_matches]) => {
                    //console.log(`${key} ${obj_matches}`); 
                    //Object.entries(obj_group).forEach(([key2, obj_matches]) => {
                        //console.log(`${key2} ${obj_matches}`); 

                        if(obj_matches.league !== null){
                            //console.log(obj_matches.league)
                            league_id = obj_matches.league.id
                            sport_id = obj_matches.league.sport_id

                            if(x == 1){
                                // Creamos el string con el que pintaremos los checkbox en el step 3
                                arr_matches = obj_matches.id
                                
                                // Creamos el step3_detail con toda la información para el step 4
                                if(step3_detail==null){
                                    arrStep3Detail.push({
                                        'id':obj_matches.id,
                                        'match_id':obj_matches.id,
                                        'fecha':obj_matches.start_date,
                                        'league_name':obj_matches.league.name,
                                        'local_name':obj_matches.local_team.name,
                                        'visitor_name':obj_matches.visitor_team.name
                                    }) 
                                    //console.log("arrStep3Detail",arrStep3Detail)
                                    localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))

                                    arrStep3.push(obj_matches.id) 
                                    localStorage.setItem('step3', JSON.stringify(arrStep3))
                                }else{
                                    arrStep3Detail.push({
                                        'id':obj_matches.id,
                                        'match_id':obj_matches.id,
                                        'fecha':obj_matches.start_date,
                                        'league_name':obj_matches.league.name,
                                        'local_name':obj_matches.local_team.name,
                                        'visitor_name':obj_matches.visitor_team.name
                                    }) 
                                    //console.log("arrStep3Detail",arrStep3Detail)
                                    localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))

                                    arrStep3.push(obj_matches.id) 
                                    localStorage.setItem('step3', JSON.stringify(arrStep3))

                                }
                            }else{
                                // Creamos el string con el que pintaremos los checkbox en el step 3
                                arr_matches += ','+obj_matches.id

                                // Creamos el step3_detail con toda la información para el step 4
                                if(step3_detail==null){
                                    arrStep3Detail.push({
                                        'id':obj_matches.id,
                                        'match_id':obj_matches.id,
                                        'fecha':obj_matches.start_date,
                                        'league_name':obj_matches.league.name,
                                        'local_name':obj_matches.local_team.name,
                                        'visitor_name':obj_matches.visitor_team.name
                                    }) 
                                    //console.log("arrStep3Detail",arrStep3Detail)
                                    localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))

                                    arrStep3.push(obj_matches.id) 
                                    localStorage.setItem('step3', JSON.stringify(arrStep3))
                                }else{
                                    arrStep3Detail.push({
                                        'id':obj_matches.id,
                                        'match_id':obj_matches.id,
                                        'fecha':obj_matches.start_date,
                                        'league_name':obj_matches.league.name,
                                        'local_name':obj_matches.local_team.name,
                                        'visitor_name':obj_matches.visitor_team.name
                                    }) 
                                    //console.log("arrStep3Detail",arrStep3Detail)
                                    localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))

                                    arrStep3.push(obj_matches.id) 
                                    localStorage.setItem('step3', JSON.stringify(arrStep3))

                                }
                            }

                            // Se arman los partidos para mostrar los que ya estan seleccionados
                            body_matches += `
                            <tr>
                                <td class="text-center" style="padding: 0.4rem; ">
                                `;
                                body_matches += '<input type="checkbox" id="match_edit_id_'+obj_matches.id+'" name="match_edit_id['+obj_matches.id+']" class="matches-edit" value="'+obj_matches.id+'" checked onclick="editMatchStorage('+obj_matches.id+')" >';
                                body_matches += '<input type="hidden" id="match_edit_old_id_'+obj_matches.id+'" name="match_edit_old_id['+obj_matches.id+']" value="checked" >';

                                body_matches += `
                                </td>
                                <td style="padding: 0.4rem;" id="match_league_name_edit_${obj_matches.id}">${obj_matches.league.name}</td>
                                <td style="padding: 0.4rem;" id="match_local_team_name_edit_${obj_matches.id}">${obj_matches.local_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_visitor_team_name_edit_${obj_matches.id}">${obj_matches.visitor_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_start_date_edit_${obj_matches.id}">${obj_matches.start_date}</td>
                            </tr>
                            `;

                            // Se arman los partidos para mostrar el resumen
                            body_match_resume += `
                            <tr style="border-top: 3px solid #999;">
                                <td><span class="text-bold">Local:</span> ${obj_matches.local_team.name}</td>
                                <td><span class="text-bold">Visitante:</span> ${obj_matches.visitor_team.name}</td>
                            </tr>
                            <tr>
                                <td><span class="text-bold">Liga:</span> ${obj_matches.league.name}</td>
                                <td><span class="text-bold">Fecha:</span>${obj_matches.start_date}</td>
                            </tr>
                            `
                        }
                        x++
                    //})
                })

                $('#partidos_resume_edit tbody').html(body_match_resume)

            } // if

            //console.log("league_id: ",league_id)
            //console.log("sport_id: ",sport_id)
            //console.log("arr_matches: ",arr_matches)

            // Pintamos los registros en la tabla
            $("#tblBracketsMatchesEditAdded tbody").html(body_matches);
            
            let cantidad = 200

            // Agregamos el datatable
            $("#tblBracketsMatchesEditAdded").DataTable({
                "responsive": true, 
                "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                "lengthChange": true, 
                "autoWidth": false,
                "scrollX": false,
                "stateSave": false,
                'pageLength': cantidad,
                
                
            });

            $("#modal-edit-3").addClass('scroll-vertical')

            $("#sport_id_search_edit").val(sport_id)

            setTimeout(function(){
                // Si existe el league_id llamamos la función para construir los inputs checkbox
                if(league_id != ''){
                    //selectSportModalEdit(league_id,sport_id,arr_matches,arr_matches2)
                }    
            }, 2000);


            // Step 4
            let y = 1
            let z = 1
            let preguntas = ''
            let body_preguntas_resume = ''
            // Obtenemos las preguntas para editarlas
            Object.entries(data.tiebreakers).forEach(([key, obj_tiebreakers]) => {
                //console.log("key: ",key)
                //console.log(obj_tiebreakers)

                preguntas += `
                <div class="form-group" role="list" id="field${y}">
                    <div class="input-group">
                        <input type="text" name="pregunta[${y}]" class="fieldname form-control" placeholder="Pregunta" required="" value="${obj_tiebreakers.question}">
                        <input type="hidden" name="pregunta_id[${y}]" value="${obj_tiebreakers.id}">
                        <input type="hidden" name="pregunta_old[${y}]" value="${obj_tiebreakers.question}">
                        <div class="input-group-append"><button type="button" class="new btn btn-success btn-sm input-group-text" id="new${y}"><i class="fas fa-plus"></i></button></div>
                        <button type="button" id="remove${y}" data-id="${obj_tiebreakers.id}" class="remove-question btn btn-danger btn-sm input-group-text"><i class="far fa-trash-alt"></i>
                        </div>
                    </div>
                `

                body_preguntas_resume += `
                <tr>
                    <td style="background: #CCCCCC; ">${obj_tiebreakers.question}</td>
                </tr>
                `

                let arrOptionsFirst = obj_tiebreakers.options.substring(1);
                let arrOptionsLast = arrOptionsFirst.substring(0, arrOptionsFirst.length - 1)
                let arrOptions = arrOptionsLast.split(",");
                //console.log(arrOptions)
                let total_respuestas = arrOptions.length
                //console.log("total_respuestas: ",total_respuestas)

                for(i=1;i<=total_respuestas;i++){

                    if(z == 1){
                        preguntas += `<fieldset id="subwrapper${y}">`
                    }
                    preguntas += `
                        <aside class="col-md-8 mt-1" id="subfield${z}">
                            <div class="input-group" role="list">
                                <input type="text" name="opcion_${y}[${z}]" class="form-control" placeholder=" Opción" required="" value="${arrOptions[z-1]}">
                                <button type="button" class="remove-answer btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                <input type="hidden" name="opcion_old_${y}[${z}]" class="form-control" placeholder=" Opción" required="" value="${arrOptions[z-1]}">
                            </div>
                        </aside>
                    `

                    body_preguntas_resume += `
                    <tr>
                        <td>${arrOptions[z-1]}</td>
                    </tr>
                    ` 

                    if(z == total_respuestas){
                        preguntas += `</fieldset></div>`
                        z = 0
                    }

                    // Aumentamos el contador de respuestas
                    z++

                } // END for

                // Aumentamos el contador de preguntas
                y = y+10
                
            })

            $("#buildyourformedit").html(preguntas)
            $("#modal-edit-4").addClass('scroll-vertical')

            // Step 5
            // Resumen
            $("#titulo_resume_edit").html(data.title)
            $("#subtitulo_resume_edit").html(data.subtitle)
            $("#fecha_inicio_resume_edit").html(arrLimitDate[0])

            $("#partidos_resume_edit tbody").html(body_match_resume)
            $("#premios_resume_edit tbody").html(body_awards_resume)
            $('#preguntas_resume_edit tbody').html(body_preguntas_resume)

            $("#modal-edit-5").addClass('scroll-vertical')

            

        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }

    })
}

const update = () => {
    console.log('update')

    localStorage.removeItem("step1")
    localStorage.removeItem("step2")
    localStorage.removeItem("step3")
    localStorage.removeItem("step3_detail")
    localStorage.removeItem("pools_step1")
    localStorage.removeItem("pools_step2")

    $('#frmPoolEdit').submit()
}

// nextModalEdit
const nextModalEdit = (hideStep,showStep) => {
    console.log('nextModalEdit')

    // Step 4
    if(showStep == 4){
        $("#divBracketsMatchesEdit").html('')
        var step3_detail = localStorage.getItem("step3_detail")

        let body_match = ''
        let body_match_resume = ''

        if(step3_detail != null){
            step3_detail = JSON.parse(step3_detail);
            //console.log(step3_detail)

            Object.entries(step3_detail).forEach(([key, value]) => {
            
                body_match += `
                <tr>
                    <td>${value.league_name}</td>
                    <td>${value.local_name}</td>
                    <td>${value.visitor_name}</td>
                    <td>${value.fecha}</td>
                    <td>
                        <input type="text" id="grupo_${value.match_id}" name="grupo[${value.match_id}]" class="form-control grupo-edit" value="${value.grupo}">
                        <input type="hidden" id="grupo_old_${value.match_id}" name="grupo_old[${value.match_id}]" class="form-control grupo-edit" value="${value.grupo}">
                        <input type="hidden" id="bracket_match_id_${value.match_id}" name="bracket_match_id[${value.match_id}]" class="form-control grupo-edit" value="${value.id}">
                    </td>
                    <td>
                        <input type="text" id="jornada_${value.match_id}" name="jornada[${value.match_id}]" class="form-control jornada-edit" value="${value.jornada}">
                        <input type="hidden" id="jornada_old_${value.match_id}" name="jornada_old[${value.match_id}]" class="form-control jornada-edit" value="${value.jornada}">
                    </td>
                </tr>
                `

                body_match_resume += `
                <tr style="border-top: 3px solid #999;">
                    <td><span class="text-bold">Local:</span> ${value.local_name}</td>
                    <td><span class="text-bold">Visitante:</span> ${value.visitor_name}</td>
                </tr>
                <tr>
                    <td><span class="text-bold">Liga:</span> ${value.league_name}</td>
                    <td><span class="text-bold">Fecha:</span> ${value.fecha}</td>
                </tr>
                `

            })

            $("#tblBracketsGroupEdit tbody").html(body_match)
            $("#modal-edit-4").addClass('scroll-vertical')

            $("#partidos_resume_edit tbody").html(body_match_resume)
            $("#modal-edit-5").addClass('scroll-vertical')

            
        }
    }

    $('#modal-edit-'+hideStep).modal('hide');
    $('#modal-edit-'+showStep).modal('show');
}

// selectSportModalEdit
// Selección de los partidos para editar los inputs checkbox
const selectSportModalEdit = (league_id,sport_id,arreglo,op='') => {
    console.log('selectSportModalEdit')
    console.log(arreglo)

    // Convertimos los ID's de los partidos en cadena
    let cadena_arreglo = arreglo.toString()
    // Verificamos si son varios ID's o solamente es un ID
    let validar_arreglo = cadena_arreglo.includes(",")
    
    // Convertimos el string en array, match_id
    if(validar_arreglo == true){ 
        // Más de un partido
        arr_matches = arreglo.split(',')
    }else{
        // Solo un partido
        arr_matches = [arreglo]
    }

    console.log(arr_matches)

    let selectDiv = 'Edit'
    let selectModal = 'edit'

    if(op == 'Phases'){
        selectDiv = 'Phases'
        selectModal = 'phases'   
    }

    let divTable = $("#divBracketsMatches"+selectDiv)
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblBracketsMatches${selectDiv}" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Liga</th>
                <th>Local</th>
                <th>Visitante</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    `

    divTable.append(table)

    $.ajax({
        url: '/matches/league',
        type: 'GET',
        data: { 
            "sport_id" : sport_id, 
            "league_id" : league_id
        },
        beforeSend: function() {
            $("#loading2").show();
            $("#loading-text-2").html('Procesando registros, espere un momento....');
        },
        complete: function() {
            $("#loading2").hide();
        },
        success: function(response_matches){
            console.log('success matches league')
            //console.log(JSON.parse(response_matches))
            
            data = JSON.parse(response_matches)

            // Eliminamos el step3 para crearlo de cero
            localStorage.removeItem("step3")

            // Guardamos el step 3
            var step3 = localStorage.getItem("step3")
            //console.log("step3: "+step3)

            arrStep3 = new Array()

            // Definición de variables
            let body_matches = ''
            let string_match = ''
            var x = 1;

            // Traemos los matches de los partidos
            data.forEach(response_data=>{
                let selectedCheckMatch = ''
                var res_fecha_edit = ''
                var res_horario_edit = ''
                
                if(response_data.start_date != '' && response_data.start_date != null){
                    [res_fecha_edit,res_horario_edit] = response_data.start_date.split('T')
                }

                //console.log(arr_matches)
                //console.log('id: ',response_data.id)

                // validamos si esta seleccionado el checkbox
                const index = arr_matches.findIndex(element => element == response_data.id.toString())

                //console.log('index: ',index)

                // Si esta seleccionado
                if(index != -1){
                    //console.log('entro a index')
                    // Colocamos el checked a los partidos que ya se encuentran seleccionados
                    selectedCheckMatch = 'checked'

                    // Creamos el step3
                    if(step3==null){
                        arrStep3.push(response_data.id) 
                        //console.log("arrStep3",arrStep3)
                        localStorage.setItem('step3', JSON.stringify(arrStep3))
                    }else{
                        arrStep3.push(response_data.id) 
                        //console.log("arrStep3",arrStep3)
                        localStorage.setItem('step3', JSON.stringify(arrStep3))
                    }
        
                }else{
                    // Es un partido nuevo que se va agregar al bracket
                    string_match = `${response_data.id},${response_data.start_date},${response_data.league.name},${response_data.local_team.name},${response_data.visitor_team.name}`
                }
                //console.log(selectedCheckMatch)


                body_matches += `
                <tr>
                    <td class="text-center" style="padding: 0.4rem; ">
                    `;
                    if(index != -1){
                        body_matches += '<input type="checkbox" id="match_edit_id_'+response_data.id+'" name="match_edit_id['+response_data.id+']" class="matches-edit" value="'+response_data.id+'" '+selectedCheckMatch+' onclick="editMatchStorage('+response_data.id+')" >';
                        body_matches += '<input type="hidden" id="match_edit_old_id_'+response_data.id+'" name="match_edit_old_id['+response_data.id+']" value="'+selectedCheckMatch+'" >';
                    }else{
                        body_matches += '<input type="checkbox" id="match_edit_id_'+response_data.id+'" name="match_edit_id['+response_data.id+']" class="matches-edit" value="'+response_data.id+'" '+selectedCheckMatch+' onclick="addMatchStorage('+response_data.id+',\''+string_match+'\')" >';
                        body_matches += '<input type="hidden" id="match_edit_old_id_'+response_data.id+'" name="match_edit_old_id['+response_data.id+']" value="'+selectedCheckMatch+'" >';
                            
                    }
                    body_matches += `
                    </td>
                    <td style="padding: 0.4rem;" id="match_league_name_edit_${response_data.id}">${response_data.league.name}</td>
                    <td style="padding: 0.4rem;" id="match_local_team_name_edit_${response_data.id}">${response_data.local_team.name}</td>
                    <td style="padding: 0.4rem;" id="match_visitor_team_name_edit_${response_data.id}">${response_data.visitor_team.name}</td>
                    <td style="padding: 0.4rem;" id="match_start_date_edit_${response_data.id}">${response_data.start_date}</td>
                </tr>
                `;
                x++
            })

            // Pintamos los registros en la tabla
            $("#tblBracketsMatches"+selectDiv+" tbody").html(body_matches);
            
            let cantidad = 200

            // Agregamos el datatable
            $("#tblBracketsMatches"+selectDiv).DataTable({
                "responsive": true, 
                "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                "lengthChange": true, 
                "autoWidth": false,
                "scrollX": false,
                "stateSave": false,
                'pageLength': cantidad,
                
                
            });

            $("#modal-"+selectModal+"-3").addClass('scroll-vertical')


        },
        error: function (obj, error, objError){
        var error = objError
        console.log('Error al obtener el resultado. '+ error)
        }
    })
}

// addMatchStorage
// Agregamos el partido seleccionado al pool
const addMatchStorage = (id,arreglo) => {
    console.log('addMatchStorage')
    console.log('arreglo: ', arreglo)

    // Buscamos el step 3
    var step3 = localStorage.getItem("step3")
    console.log("step3: "+step3)

    if(step3==null){
        arrStep3 = new Array()
        arrStep3.push(id) 
        //console.log("arrStep3",arrStep3)
        localStorage.setItem('step3', JSON.stringify(arrStep3))
    }else{
        arrStep3=JSON.parse(step3);
        arrStep3.push(id) 
        //console.log("arrStep3",arrStep3)
        localStorage.setItem('step3', JSON.stringify(arrStep3))
    }


    // Buscamos el step 3 detail y agregamos los detalles del nuevo partido
    var step3_detail = localStorage.getItem("step3_detail")
    //console.log("step3_detail: "+step3_detail)

    let match_id = ''
    let start_date = ''
    let league_name = ''
    let local_team_name = ''
    let visitor_team_name = ''

    if(arreglo != ''){
        [match_id,start_date,league_name,local_team_name,visitor_team_name] = arreglo.split(',')

        if(step3_detail==null){
            arrStep3Detail = new Array()
    
            arrStep3Detail.push({
                'id':'',
                'match_id':match_id,
                'fecha':start_date,
                'league_name':league_name,
                'local_name':local_team_name,
                'visitor_name':visitor_team_name,
                'grupo':'',
                'jornada':''
            }) 
            //console.log("arrStep3Detail",arrStep3Detail)
            localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
        }else{
            arrStep3Detail=JSON.parse(step3_detail);
    
            arrStep3Detail.push({
                'id':'',
                'match_id':match_id,
                'fecha':start_date,
                'league_name':league_name,
                'local_name':local_team_name,
                'visitor_name':visitor_team_name,
                'grupo':'',
                'jornada':''
            }) 
            //console.log("arrStep3Detail",arrStep3Detail)
            localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
        }
    }

    // cambiamos la funcion a editar
    document.getElementById("match_edit_id_"+id).setAttribute("onclick", "editMatchStorage("+id+")");


}

// editMatchStorage
// Desvinculamos el partido seleccionado del pool
const editMatchStorage = id => {
    console.log('editMatchStorage')
    //console.log('id: ',id)

    Swal.fire({
        title: '¿Deseas desvincular este partido de la quiniela?',
        text: "¡Podrás agregarlo nuevamente de ser necesario!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
    }).then((result) => {
        if (result.isConfirmed) {

            // Buscamos el step 3 detail
            var step3_detail = localStorage.getItem("step3_detail")
            //console.log(step3_detail)

            arrStep3Detail=JSON.parse(step3_detail);

            // Buscamos el ID en el step 3 detail
            const indexDetail = arrStep3Detail.findIndex(element => element.match_id == id)
            //console.log('indexDetail: ',indexDetail)
            console.log(arrStep3Detail[indexDetail])

            let id_desvincular_partido = ''
            let match_id = ''
            let start_date = ''
            let league_name = ''
            let local_team_name = ''
            let visitor_team_name = ''

            // Si encontro el item y lo quitamos del almacenamiento detail
            if(indexDetail != -1){
                id_desvincular_partido = arrStep3Detail[indexDetail].id

                match_id = arrStep3Detail[indexDetail].match_id
                start_date = arrStep3Detail[indexDetail].fecha
                league_name = arrStep3Detail[indexDetail].league_name
                local_team_name = arrStep3Detail[indexDetail].local_name
                visitor_team_name = arrStep3Detail[indexDetail].visitor_name
            
                // Eliminamos el item del arreglo
                arrStep3Detail.splice(indexDetail, 1);
            }

            //console.log('id_desvincular_partido: ',id_desvincular_partido)
            //console.log(arrStep3Detail)
            //console.log("buscando index: ",indexDetail)

            let string_match = `${match_id},${start_date},${league_name},${local_team_name},${visitor_team_name}`

            localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))


            // Buscamos el step 3
            var step3 = localStorage.getItem("step3")
            //console.log(step3)

            arrStep3=JSON.parse(step3);

            // Buscamos el ID en el step3
            const index = arrStep3.findIndex(element => element == id)

            // Si encontro el item y lo quitamos del almacenamiento
            if(index != -1){
                arrStep3.splice(index, 1);
            }
            
            //console.log(arrStep3)
            //console.log("buscando index: ",index)

            localStorage.setItem('step3', JSON.stringify(arrStep3))

            // cambiamos la funcion a agregar
            //$("#match_edit_id_"+id).prop("checked", false)
            console.log('cambiamos la funcion')
            console.log('id: ',id)
            document.getElementById("match_edit_id_"+id).setAttribute("onclick", "addMatchStorage("+id+",'"+string_match+"')");

            let pool_id = $("#pool_edit_id").val()

            console.log('pool_id: ', pool_id)
            console.log('match_id: ', id_desvincular_partido)

            if(id_desvincular_partido != ''){
                
                $.ajax({
                    url: '/pools/remove_match',
                    type: 'POST',
                    data: { 
                        "pool_match_id" : id_desvincular_partido,
                        "pool_id" : pool_id
                    },
                    success: function(response){
                        console.log('success remove match')
                        console.log(JSON.parse(response))
            
                    },
                    error: function (obj, error, objError){
                    var error = objError
                    console.log('Error al obtener el resultado. '+ error)
                    }
                })
                
            } // END if
        
        }else{
            $("#match_edit_id_"+id).prop("checked", true)
        }
    })

}

const addMatch = (tbl,x,match_id,liga,local,visitante,fecha) => {

    let row = ''

    row += `
        <tr>
            <td class="text-center" style="padding: 0.4rem; ">
                <input type="checkbox" id="match_id_${match_id}" name="match_id[${match_id}]" class="matches-add" value="${match_id}" checked>
            </td>
            <td style="padding: 0.4rem;" id="match_league_name_${match_id}">${liga}</td>
            <td style="padding: 0.4rem;" id="match_local_team_name_${match_id}">${local}</td>
            <td style="padding: 0.4rem;" id="match_visitor_team_name_${match_id}">${visitante}</td>
            <td style="padding: 0.4rem;" id="match_start_date_${match_id}">${fecha}</td>
        </tr>
    `

    $("#"+tbl+">tbody").append(row);

}

// Mostrar el modal para calificar las preguntas
const modalTiebreakers = pool_id => {
    console.log('modalTiebreakers')

    $.ajax({
        url: '/pools/list_pools/'+pool_id,
        type: 'GET',
        data: '',
        beforeSend: function() {
            $("#loading1").show();
            $("#loading-text-1").html('Procesando, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response){
            console.log('success')
            console.log(JSON.parse(response))
            
            data = JSON.parse(response)
            //console.log(data)


            // Step 4
            let y = 1
            let z = 1
            let preguntas = ''
            // Obtenemos las preguntas para editarlas
            Object.entries(data.tiebreakers).forEach(([key, obj_tiebreakers]) => {
                //console.log("key: ",key)
                console.log(obj_tiebreakers)

                preguntas += `
                <div class="form-group" role="list" id="field${y}">
                    
                        <div><input type="text" name="pregunta[${y}]" class="fieldname form-control" placeholder="Pregunta" required="" value="${obj_tiebreakers.question}" disabled>
                        <input type="hidden" name="pregunta_id[${y}]" value="${obj_tiebreakers.id}">
                        <input type="hidden" name="pregunta_old[${y}]" value="${obj_tiebreakers.question}">
                        </div>
                    
                `

                let arrOptionsFirst = obj_tiebreakers.options.substring(1);
                let arrOptionsLast = arrOptionsFirst.substring(0, arrOptionsFirst.length - 1)
                let arrOptions = arrOptionsLast.split(",");
                //console.log(arrOptions)
                let total_respuestas = arrOptions.length
                let radio_selected = ''
                //console.log("total_respuestas: ",total_respuestas)

                for(i=1;i<=total_respuestas;i++){

                    if(z == 1){
                        preguntas += `<fieldset id="subwrapper${y}">`
                    }

                    if(obj_tiebreakers.answer != null && obj_tiebreakers.answer == z-1){
                        radio_selected = 'checked'
                    }else{
                        radio_selected = ''
                    }

                    
                    preguntas += `
                        <aside class="col-md-8 mt-1" id="subfield${z}">
                            <div class="input-group" role="list">
                                <input type="radio" name="opcion[${obj_tiebreakers.id}]" value="${z-1}" ${radio_selected}>
                                <input type="hidden" name="opcion_old[${obj_tiebreakers.id}]" value="${obj_tiebreakers.answer}">
                                <input type="text" name="opcion_${y}[${z}]" class="form-control" placeholder=" Opción" required="" value="${arrOptions[z-1]}" disabled>
                            </div>
                        </aside>
                    `

                    if(z == total_respuestas){
                        preguntas += `</fieldset></div>`
                        z = 0
                    }

                    // Aumentamos el contador de respuestas
                    z++

                } // END for

                // Aumentamos el contador de preguntas
                y = y+10
                
            })

            $("#buildyourformwinner").html(preguntas)
            $('#modal-tiebreakers').modal('show');

        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }

    })

}


// Calificar las preguntas de las quinielas
const qualifyTiebreakers = () => {
    Swal.fire({
        title: '¿Deseas calificar las preguntas?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, calificar!'
    }).then((result) => {
        if (result.isConfirmed) {

            $("#frmPoolTiebreakers").submit()
        
        }
    })
}
/*****************************************************************************************************/

// Mostramos el Modal para Cambiar el icono del Deporte
const changeSport = (id,container,sport_id) => {
    //console.log('changeSport')
    //console.log(`pool_id: ${id}, sport_id: ${sport_id}`)

    // Quiniela seleccionada
    $("#pool_id_chg_sport").val(id);

    // Deporte seleccionado
    $("#sport_image_change_"+sport_id).addClass('sport-selected');
    $("#multi_sport_id").val(sport_id);

    $('#modal-sport').modal('show');
}

// Cambiamos el icono del deporte
const selectSportChange = sport_id => {
    console.log('selectSportChange');
    console.log({sport_id});

    // Quitamos la selección del icono que estaba marcado
    $(".sport-change").removeClass('sport-selected');
    // Agregamos la selección al nuevo icono
    $("#sport_image_change_"+sport_id).addClass('sport-selected');
    $("#multi_sport_id").val(sport_id);
}

//Guardamos el cambio de icono del deporte
const saveNewSportIcon = () => {
    console.log('saveNewSportIcon');

    let pool_id = $("#pool_id_chg_sport").val();
    let sport_id = $("#multi_sport_id").val();

    $.ajax({
        url: '/pools/sport_pool',
        type: 'POST',
        data: { 
            "pool_id" : pool_id,
            "sport_id" : sport_id
        },
        success: function(response){
            //console.log('success change status')
            //console.log(JSON.parse(response))

            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'El icono del deporte de la quiniela ha sido actualizado.',
            })

            window.self.location='/pools'
    
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })
        


}

/*****************************************************************************************************/
// Mostrar el modal para cambiar el estatus de las quinielas
const chageStatus = pool_id => {
    console.log('chageStatus')

    let inputStatus = ''

    $.ajax({
        url: '/pools/list_pools/'+pool_id,
        type: 'GET',
        data: '',
        beforeSend: function() {
            $("#loading1").show();
            $("#loading-text-1").html('Procesando, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response){
            console.log('success')
            //console.log(JSON.parse(response))
            
            data = JSON.parse(response)
            //console.log(data)

            let status_open = ''
            let status_running = ''
            let status_finished = ''

            switch(data.status){
                case 'open': 
                    status_open = 'checked' 
                break;

                case 'running': 
                    status_running = 'checked' 
                break;

                case 'finished': 
                    status_finished = 'checked' 
                break;
            }


            inputStatus = `
                <input type="hidden" name="status_pool_id" id="status_pool_id" value="${data.id}">
                <input type="radio" name="status" value="open" ${status_open}> abierto <br>
                <input type="radio" name="status" value="running" ${status_running}> en curso <br>
                <input type="radio" name="status" value="finished" ${status_finished}> finalizado <br>
            `

            
            $("#divStatus").html(inputStatus)
            $('#modal-status').modal('show');

        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }

    })

}


// Cambiar estatus de las quinielas
const saveStatus = () => {
    let pool_id = $("#status_pool_id").val()
    let status = $('input:radio[name=status]:checked').val()

    //console.log('pool_id', pool_id)
    //console.log('status', status)

    Swal.fire({
        title: '¿Deseas modificar el estatus de la quiniela?',
        text: "Recuerda que si estas FINALIZANDO la quiniela, debes asegurarte de haber calificado todas las preguntas",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, cambiar estatus!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/pools/status',
                type: 'POST',
                data: { 
                    "pool_id" : pool_id,
                    "status" : status
                },
                success: function(response){
                    //console.log('success change status')
                    //console.log(JSON.parse(response))

                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'El estatus de la quiniela ha sido actualizado.',
                    })

                    window.self.location='/pools'
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
        
        }
    })
}

// Quinielas Acumulativas
const cumulativeShow = (op='') => {
    console.log('cumulativeShow')
    console.log(op)

    if (op == ''){
        $("#cumulative_phase").toggle('slow')
    }

    if (op == 'edit'){
        $("#cumulative_phase_edit").toggle('slow')
    }

}

// Switch para mostrar los datos a llenar de la Quiniela acumulativa
$('#is_cumulative').click(function() {
    $("#cumulative_phase").toggle(this.checked);
});


// Mostrar fases, crear y editar fases
const modalPhases = (pool_id = '', nombre_quiniela = '') => {
    console.log('modalPhases')

    $('#modal-phases').modal('show');
    $("#quiniela-fases").html(' - '+nombre_quiniela)

    // Se agrega el ID de la Quiniela por si se agrega una nueva fase
    $("#pool_id_new").val(pool_id)
    // Se agrega el ID de la Quiniela por si se agrega o actualizan partidos y preguntas
    $("#pool_id_phases").val(pool_id)

    if(pool_id != ''){
        $.ajax({
            url: '/pools/phases',
            type: 'POST',
            data: { 
                "pool_id" : pool_id
            },
            beforeSend: function() {
                $("#loading1").show();
                $("#loading-text-1").html('Procesando, espere un momento....');
            },
            complete: function() {
                $("#loading1").hide();
            },
            success: function(response){
                //console.log('success')
                console.log(JSON.parse(response))

                data = JSON.parse(response)

                if(data != null){
                    listarPhases(response)
                }else{

                    $("#loading1").hide();

                    Swal.fire({
                        icon: 'warning',
                        title: 'No se encontro ningún resultado',
                        text: 'Intentalo nuevamente...',
                    })
                }
      
            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                $("#loading1").hide();
            }
        })
    }

}


// listar las fases de la quiniela acumulativa
const listarPhases = (response) => {
    console.log('listarPhases')

    // Seleccionamos el div donde colocaremos el contenido de la tabla
    let divTable = $("#divPhases")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <div class="row">
        <div class="col-5">
            <button class="btn btn-block btn-dark" onclick="modalPhasesAdd()"><i class="fas fa-plus"></i> Crear Fase</button>
        </div>
    </div>

    <table id="tblPhases" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Fase</th>
                <th>Fecha de Inicio</th>
                <th>Fecha Finalización</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    `
    divTable.append(table)

    let body_phases = ''
    data = JSON.parse(response)
    console.log(data)

    
    data[0].forEach(response_data=>{

        body_phases += `
        <tr>
            <td>${response_data.name}</td>
            <td>${response_data.start_date}</td>
            <td>${response_data.end_date}</td>
            <td class="text-center">
                <button class="btn" onclick="nextModalPhases('',2,${response_data.id})" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn" onclick="delPhases(${response_data.id})"><i class="far fa-trash-alt"></i></button>
            </td>
        </tr>
        `
    })

    // Pintamos los registros en la tabla
    $("#tblPhases tbody").html(body_phases);

    let cantidad = 100

    // Agregamos el datatable
    $("#tblPhases").DataTable({
        
        "responsive": true, 
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        "lengthChange": false, 
        "autoWidth": false,
        "scrollX": false,
        "stateSave": false,
        'pageLength': cantidad,
        
        // ocultar columnas
        "columnDefs": [
            {
                "targets": [ 3 ],
                "orderable": false,
                "searchable": false,
                //"visible": false,
            }
        ],
        "select": true,
        initComplete: function () {
            var api = this.api();
            // Se colocan los filtros en las columnas
            $('.filterhead', api.table().footer()).each( function (i) {
                if(i!=3) {
                var column = api.column(i);
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(this).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                } );
                }
            } ); // filter
        } // init
    }).buttons().container().appendTo('#tblPhases_wrapper .col-md-6:eq(0)');

}

// Modal para Agregar una nueva Fase a la Quiniela
const modalPhasesAdd = () => {
    console.log('modalPhasesAdd')

    $('#modal-phases').modal('hide');
    $('#modal-phases-add').modal('show');

}

// Guardar la nueva Fase de la Quiniela
const savePhasesAdd = () => {
    console.log('savePhasesAdd')

    let pool_id = $("#pool_id_new").val()
    let phase_name_new = $("#phase_name_new").val()

    let fecha_inicio_cumulative_new = $("#fecha_inicio_cumulative_new").val()
    let horario_inicio_cumulative_new = $("#horario_inicio_cumulative_new").val()

    let fecha_fin_cumulative_new = $("#fecha_fin_cumulative_new").val()
    let horario_fin_cumulative_new = $("#horario_fin_cumulative_new").val()

    $.ajax({
        url: '/pools/phases_add',
        type: 'POST',
        data: { 
            "pool_id" : pool_id,
            "phase_name" : phase_name_new,
            "fecha_inicio_cumulative" : fecha_inicio_cumulative_new,
            "horario_inicio_cumulative" : horario_inicio_cumulative_new,
            "fecha_fin_cumulative" : fecha_fin_cumulative_new,
            "horario_fin_cumulative" : horario_fin_cumulative_new
        },
        beforeSend: function() {
            $("#loading1").show();
            $("#loading-text-1").html('Procesando, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response){
            //console.log('success')
            //console.log(JSON.parse(response))

            data = JSON.parse(response)
            console.log(data)

            if(data != null){
                //console.log('fase_id: ',data[0].id)
                //console.log('got to nextModalPhases')

                $('#modal-phases-add').modal('hide')

                nextModalPhases('',3,data[0].id,'add_phase')
            }else{

                $("#loading1").hide();

                Swal.fire({
                    icon: 'warning',
                    title: 'Falló la creación de la nueva fase',
                    text: 'Intentalo nuevamente...',
                })
            }
  
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
            $("#loading1").hide();
        }
    })

}


// nextModalPhases
const nextModalPhases = (hideStep,showStep,phase_id,op='') => {
    console.log('nextModalPhases')
    //console.log('hideStep: ',hideStep)
    //console.log('showStep: ',showStep)
    //console.log('phase_id: ',phase_id)
    //console.log('op: ',op)

    let pool_id = $("#pool_id_phases").val()

    if((showStep == 2 && op == '') || (showStep == 3 && op == 'add_phase')){
        if(phase_id != ''){
            $("#phase_id_new").val(phase_id)
        }
    }

    // Entra a editar desde la fase y se sigue con los partidos y preguntas
    if(showStep == 2){
        $("#phase_step").val('edit')
    }

    // Entra directo a partidos y no se actualiza la información de la fase
    if(showStep == 3){
        $("#phase_step").val('add')
    }

    phase_id = $("#phase_id_new").val()

    //console.log('pool_id: '+pool_id)
    //console.log('phase_id: '+phase_id)

    // Step 2 and Step 3
    if( (showStep == 2 && op == '') || (showStep == 3 && op == 'add_phase') ){
        $.ajax({
            url: '/pools/list_phases',
            type: 'GET',
            data: { 
                "pool_id" : pool_id, 
                "phase_id" : phase_id
            },
            beforeSend: function() {
                $("#loading1").show();
                $("#loading-text-1").html('Procesando, espere un momento....');
            },
            complete: function() {
                $("#loading1").hide();
            },
            success: function(response){
                console.log('success list_phases')
                console.log(JSON.parse(response))
                
                data = JSON.parse(response)
                //console.log(data)

                setTimeout(function(){
                }, 1000);

                // Inputs
                $("#phase_name_phases").val(data.pool_phases.actual.name)

                let [fecha_inicio_cumulative,time_inicio_cumulative] = data.pool_phases.actual.start_date.split('T')
                $("#fecha_inicio_cumulative_phases").val(fecha_inicio_cumulative)
                $("#horario_inicio_cumulative_phases").val(time_inicio_cumulative)

                let [fecha_fin_cumulative,time_fin_cumulative] = data.pool_phases.actual.end_date.split('T')
                $("#fecha_fin_cumulative_phases").val(fecha_fin_cumulative)
                $("#horario_fin_cumulative_phases").val(time_fin_cumulative)

                // Inputs Old
                $("#phase_name_phases_old").val(data.pool_phases.actual.name)

                $("#fecha_inicio_cumulative_phases_old").val(fecha_inicio_cumulative)
                $("#horario_inicio_cumulative_phases_old").val(time_inicio_cumulative)

                $("#fecha_fin_cumulative_phases_old").val(fecha_fin_cumulative)
                $("#horario_fin_cumulative_phases_old").val(time_fin_cumulative)

                // Resumen Info
                $("#titulo_resume_phases").html(data.pool_phases.actual.name)
                $("#fecha_inicio_resume_phases").html(data.pool_phases.actual.start_date)
                $("#fecha_fin_resume_phases").html(data.pool_phases.actual.end_date)

                // Sport and Matches
                let league_id = ''
                let sport_id = ''
                let arr_matches = ''
                let arr_matches2 = ''
                let x = 1
   

                // Eliminamos el step3_detail para crearlo de cero
                localStorage.removeItem("step3_detail")

                // Guardamos el step 3 detail
                var step3_detail = localStorage.getItem("step3_detail")
                //console.log("step3_detail: "+step3_detail)

                arrStep3Detail = new Array()
                let body_match_resume = ''
                let body_matches = ''
                let string_match = ''

                console.log('matches')
                console.log(data.matches)

                let total_matches = data.matches.length
                console.log('total_matches: ',total_matches)

                league_id = ''
                sport_id = ''
                $("#matches_status").val('add')

                let divTable = $("#divBracketsMatchesPhasesEdit")
                divTable.html("")
            
                // Creamos la tabla dentro del div
                table = `
                <table id="tblBracketsMatchesPhasesEdit" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Liga</th>
                            <th>Local</th>
                            <th>Visitante</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                `
            
                divTable.append(table)

                

                if(total_matches > 0){
                    console.log('entro a total_matches mayor a cero')

                    $("#matches_status").val('edit')

                    // Es donde buscamos los partidos
                    Object.entries(data.matches).forEach(([key, obj_matches]) => {
                        //console.log(`${key} ${obj_matches}`); 
                        //Object.entries(obj_group).forEach(([key2, obj_matches]) => {
                            //console.log(`${key2} ${obj_matches}`); 

                            if(obj_matches.league !== null){
                                //console.log(obj_matches.league)
                                league_id = obj_matches.league.id
                                sport_id = obj_matches.league.sport_id

                                if(x == 1){
                                    // Creamos el string con el que pintaremos los checkbox en el step 3
                                    arr_matches = obj_matches.id
                                    
                                    // Creamos el step3_detail con toda la información para el step 4
                                    if(step3_detail==null){
                                        arrStep3Detail.push({
                                            'id':obj_matches.id,
                                            'match_id':obj_matches.id,
                                            'fecha':obj_matches.start_date,
                                            'league_name':obj_matches.league.name,
                                            'local_name':obj_matches.local_team.name,
                                            'visitor_name':obj_matches.visitor_team.name
                                        }) 
                                        //console.log("arrStep3Detail",arrStep3Detail)
                                        localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                                    }else{
                                        arrStep3Detail.push({
                                            'id':obj_matches.id,
                                            'match_id':obj_matches.id,
                                            'fecha':obj_matches.start_date,
                                            'league_name':obj_matches.league.name,
                                            'local_name':obj_matches.local_team.name,
                                            'visitor_name':obj_matches.visitor_team.name
                                        }) 
                                        //console.log("arrStep3Detail",arrStep3Detail)
                                        localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                                    }
                                }else{
                                    // Creamos el string con el que pintaremos los checkbox en el step 3
                                    arr_matches += ','+obj_matches.id

                                    // Creamos el step3_detail con toda la información para el step 4
                                    if(step3_detail==null){
                                        arrStep3Detail.push({
                                            'id':obj_matches.id,
                                            'match_id':obj_matches.id,
                                            'fecha':obj_matches.start_date,
                                            'league_name':obj_matches.league.name,
                                            'local_name':obj_matches.local_team.name,
                                            'visitor_name':obj_matches.visitor_team.name
                                        }) 
                                        //console.log("arrStep3Detail",arrStep3Detail)
                                        localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                                    }else{
                                        arrStep3Detail.push({
                                            'id':obj_matches.id,
                                            'match_id':obj_matches.id,
                                            'fecha':obj_matches.start_date,
                                            'league_name':obj_matches.league.name,
                                            'local_name':obj_matches.local_team.name,
                                            'visitor_name':obj_matches.visitor_team.name
                                        }) 
                                        //console.log("arrStep3Detail",arrStep3Detail)
                                        localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                                    }
                                }

                                // Se arman los partidos para mostrar los que ya estan seleccionados
                                body_matches += `
                                <tr>
                                    <td class="text-center" style="padding: 0.4rem; ">
                                    `;
                                    body_matches += '<input type="checkbox" id="match_edit_id_'+obj_matches.id+'" name="match_edit_id['+obj_matches.id+']" class="matches-edit" value="'+obj_matches.id+'" checked onclick="editMatchStorage('+obj_matches.id+')" >';
                                    body_matches += '<input type="hidden" id="match_edit_old_id_'+obj_matches.id+'" name="match_edit_old_id['+obj_matches.id+']" value="checked" >';

                                    body_matches += `
                                    </td>
                                    <td style="padding: 0.4rem;" id="match_league_name_edit_${obj_matches.id}">${obj_matches.league.name}</td>
                                    <td style="padding: 0.4rem;" id="match_local_team_name_edit_${obj_matches.id}">${obj_matches.local_team.name}</td>
                                    <td style="padding: 0.4rem;" id="match_visitor_team_name_edit_${obj_matches.id}">${obj_matches.visitor_team.name}</td>
                                    <td style="padding: 0.4rem;" id="match_start_date_edit_${obj_matches.id}">${obj_matches.start_date}</td>
                                </tr>
                                `;

                                // Se arman los partidos para mostrar el resumen
                                body_match_resume += `
                                <tr style="border-top: 3px solid #999;">
                                    <td><span class="text-bold">Local:</span> ${obj_matches.local_team.name}</td>
                                    <td><span class="text-bold">Visitante:</span> ${obj_matches.visitor_team.name}</td>
                                </tr>
                                <tr>
                                    <td><span class="text-bold">Liga:</span> ${obj_matches.league.name}</td>
                                    <td><span class="text-bold">Fecha:</span>${obj_matches.start_date}</td>
                                </tr>
                                `
                            }
                            x++
                        //})
                    })

                    $('#partidos_resume_phases tbody').html(body_match_resume)

                } // if

                //console.log("league_id: ",league_id)
                //console.log("sport_id: ",sport_id)
                //console.log("arr_matches: ",arr_matches)

                // Pintamos los registros en la tabla
                $("#tblBracketsMatchesPhasesEdit tbody").html(body_matches);
                
                let cantidad = 200
    
                // Agregamos el datatable
                $("#tblBracketsMatchesPhasesEdit").DataTable({
                    "responsive": true, 
                    "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                    "lengthChange": true, 
                    "autoWidth": false,
                    "scrollX": false,
                    "stateSave": false,
                    'pageLength': cantidad,
                    
                    
                });
    
                $("#modal-phases-3").addClass('scroll-vertical')

                $("#sport_id_search_phases").val(sport_id)
                //$("#divBracketsMatchesPhasesEdit").html('')



                // Step 4
                let y = 1
                let z = 1
                let preguntas = ''
                let body_tiebreakers_resume = ''
                // Obtenemos las preguntas para editarlas
                Object.entries(data.tiebreakers).forEach(([key, obj_tiebreakers]) => {
                    //console.log("key: ",key)
                    //console.log(obj_tiebreakers)

                    preguntas += `
                    <div class="form-group" role="list" id="field${y}">
                        <div class="input-group">
                            <input type="text" name="pregunta[${y}]" class="fieldname form-control" placeholder="Pregunta" required="" value="${obj_tiebreakers.question}">
                            <input type="hidden" name="pregunta_id[${y}]" value="${obj_tiebreakers.id}">
                            <input type="hidden" name="pregunta_old[${y}]" value="${obj_tiebreakers.question}">
                            <div class="input-group-append"><button type="button" class="new btn btn-success btn-sm input-group-text" id="new${y}"><i class="fas fa-plus"></i></button></div>
                            <button type="button" id="remove${y}" data-id="${obj_tiebreakers.id}" class="remove-question-phases btn btn-danger btn-sm input-group-text"><i class="far fa-trash-alt"></i></button>
                        </div>
                    `

                    body_tiebreakers_resume += `
                        <tr style="border-top: 3px solid #999; border-bottom: 3px solid #999; background-color: #ebebeb;">
                            <td class="text-bold">${obj_tiebreakers.question}</td>
                        <tr>
                    `

                    let arrOptionsFirst = obj_tiebreakers.options.substring(1);
                    let arrOptionsLast = arrOptionsFirst.substring(0, arrOptionsFirst.length - 1)
                    let arrOptions = arrOptionsLast.split(",");
                    //console.log(arrOptions)
                    let total_respuestas = arrOptions.length
                    //console.log("total_respuestas: ",total_respuestas)

                    for(i=1;i<=total_respuestas;i++){

                        if(z == 1){
                            preguntas += `<fieldset id="subwrapper${y}">`
                        }
                        preguntas += `
                            <aside class="col-md-8 mt-1" id="subfield${z}">
                                <div class="input-group" role="list">
                                    <input type="text" name="opcion_${y}[${z}]" class="form-control" placeholder=" Opción" required="" value="${arrOptions[z-1]}">
                                    <button type="button" class="remove-answer-phases btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
                                    <input type="hidden" name="opcion_old_${y}[${z}]" class="form-control" placeholder=" Opción" required="" value="${arrOptions[z-1]}">
                                </div>
                            </aside>
                        `

                        body_tiebreakers_resume += `
                            <tr>
                                <td>${arrOptions[z-1]}</td>
                            </tr>
                        `

                        if(z == total_respuestas){
                            preguntas += `</fieldset></div>`
                            z = 0
                        }

                        // Aumentamos el contador de respuestas
                        z++

                    } // END for

                    // Aumentamos el contador de preguntas
                    y = y+10
                    
                })

                $('#preguntas_resume_phases tbody').html(body_tiebreakers_resume)

                $("#modal-phases-4").addClass('scroll-vertical')
                $("#buildyourformphases").html(preguntas)
                

            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
            }

        })

    } // END if Step 

    // Step 5
    
    if(showStep == 5){
        
        $("#modal-phases-5").addClass('scroll-vertical')
            
    }
    

    $('#modal-phases-'+hideStep).modal('hide');
    $('#modal-phases-'+showStep).modal('show');
}

// Guardamos o actualizamos las fases de las quinielas
const updatePhases = () => {
    console.log('updatePhases')

    localStorage.removeItem("step3")
    localStorage.removeItem("step3_detail")
    localStorage.removeItem("pools_step1")
    localStorage.removeItem("pools_step2")

    $('#frmPoolPhase').submit()
}


