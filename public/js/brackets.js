// nextModalAdd
const nextModalAdd = (hideStep,showStep) => {
    console.log('nextModalAdd')

    // Verificamos que se haya seleccionado el Sponsor
    if(showStep == 2){
        let sponsor = $("#sponsor_add_id").val()
        if( sponsor == '' ){

            hideStep = ''
            showStep = 1

            Swal.fire({
                icon: 'warning',
                title: 'Sponsor',
                text: 'Por favor, selecciona un sponsor...',
            })

        }
    }
    
    $('#modal-add-'+hideStep).modal('hide');
    $('#modal-add-'+showStep).modal('show');

    // STEP 1 - localstorage
    if(hideStep == 1 && showStep == 2){
        var step1 = localStorage.getItem("step1")
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
    
            localStorage.setItem('step1', JSON.stringify(arrStep1))
        }else{
            
            arrStep1.push({
                'sponsor_id':sponsor_id,
                'titulo':titulo,
                'subtitulo':subtitulo,
                'fecha_inicio':fecha_inicio,
                'fecha_fin':fecha_fin
            }) 
            console.log("arrStep1Edit",arrStep1)

            localStorage.setItem('step1', JSON.stringify(arrStep1))
        }
    }

    // STEP 2 - localstorage
    if(hideStep == 2 && showStep == 3){
        var step2 = localStorage.getItem("step2")
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
            localStorage.setItem('step2', JSON.stringify(arrStep2))
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

// Step 2/5
const createAwards = (op='') => {
    console.log('createAwards')

    let total_awards = $("#total_awards").val()

    let body_awards = ''

    for (i=1; i<=total_awards; i++){

        body_awards += `
        <tr>
            <td class="text-center" style="padding: .4rem">${i}°</td>
            <td style="padding: .4rem">
                <div class="form-group" style="margin: 0;">
                    <input type="text" id="award_add_${i}" name="award_add_${i}" class="form-control cantidades" onchange="sumarAward('add')">
                </div>
            </td>
            <td class="text-center" style="padding: .4rem">
                <input type="hidden"  id="physical_award_add_id_${i}" name="physical_award_add_id_${i}" class="physical_award">
                <input type="hidden"  id="physical_award_add_title_${i}" name="physical_award_add_title_${i}" class="physical_title">
                <button type="button" id="btn_physical_award_add_${i}" class="btn btn-dark" onclick="physicalAwards(${i},'add')"><i class="fas fa-plus"></i> Premio físico</button>
            </td>
        </tr>
        `
    }

    if(op == 'add'){
        op = 'Add'
    }
    if(op == 'edit'){
        op = 'Edit'
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

const sumarAward = () => {

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

        }

        x++
        
    })
		
    // Colocar el resultado de la suma en el control "span".
    $('#awards').val(total)
    $('#cantidad_award').html(total)
}


// Step 3/5
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
            
  
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })

}

// listarBrackets
const listarBrackets = () => {
    console.log('listarBrackets')

    // Realizamos la consulta de los brackets
    $.ajax({
        url: '/brackets/list',
        type: 'GET',
        data: { },
        beforeSend: function() {
            $("#loading2").show();
            $("#loading-text-2").html('Procesando registros, espere un momento....');
        },
        complete: function() {
            $("#loading2").hide();
        },
        success: function(response_brackets){
            console.log('success brackets')
            console.log(JSON.parse(response_brackets))
            
            data = JSON.parse(response_brackets)

            let body_brackets = ''
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
                            break;

                        case 'running':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-gray-light';
                            break;

                        case 'fase 1':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-gray-light';
                            break;

                        case 'fase 2':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-gray-light';
                            break;
    
                        case 'finished':
                            color_status1 = 'c-green';
                            color_status2 = 'c-blue';
                            color_status3 = 'c-red';
                            break;
                    } // switch
                } // if

                body_brackets += `
                <tr>
                    <td>${response_data.title}</td>
                    <td>${response_data.subtitle}</td>
                    <td>
                        <img id="sport_img_${response_data.sport_id}" src="/images/icons/${response_data.sport_id}.png" class="img-fluid mrg-lr-10 sport" width="20px">
                        ${response_data.sport.name}
                    </td>
                    <td class="text-center">
                            <i class="fas fa-circle ${color_status1}"></i><i class="fas fa-minus ${color_status2}"></i><i class="fas fa-circle ${color_status2}"></i><i class="fas fa-minus ${color_status3}"></i><i class="fas fa-circle ${color_status3}"></i><br>
                            ${response_data.status}
                    </td>
                    <td class="text-center">${response_data.start_date}</td>
                    <td class="text-center">
                        <button class="btn" onclick="" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn" onclick="delBrackets(${response_data.id})"><i class="far fa-trash-alt"></i></button>
                    </td>
                </tr>
                `

                x++
            })

            // Pintamos los registros en la tabla
            $("#tblBrackets tbody").html(body_brackets);

        },
        error: function (obj, error, objError){
        var error = objError
        console.log('Error al obtener el resultado. '+ error)
        }
    })

}

// listarBracketsMatches dentro de los Steps
const listarBracketsMatches = () => {
    console.log('listarBrackets')

    let divTable = $("#divBracketsMatches")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblBracketsMatchesAdd" class="table table-bordered table-striped">
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
    let sport_id = $("#sport_id_search").val()
    let league_id = $("#league_id").val()
    let date = $("#start_date_search").val()

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
                        body_matches += `
                        <tr>
                            <td class="text-center" style="padding: 0.4rem; ">
                                <input type="checkbox" id="match_edit_id_${x}" name="match_edit_id_${x}" class="matches-add" value="${response_data.id}" >
                            </td>
                            <td style="padding: 0.4rem;" id="match_league_name_${response_data.id}">${response_data.league.name}</td>
                            <td style="padding: 0.4rem;" id="match_local_team_name_${response_data.id}">${response_data.local_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_visitor_team_name_${response_data.id}">${response_data.visitor_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_start_date_${response_data.id}">${response_data.start_date}</td>
                        </tr>
                        `

                        x++
                    })

                    // Pintamos los registros en la tabla
                    $("#tblBracketsMatchesAdd tbody").html(body_matches);
                    
                    let cantidad = 100

                    // Agregamos el datatable
                    $("#tblBracketsMatchesAdd").DataTable({
                        "responsive": true, 
                        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                        "lengthChange": false, 
                        "autoWidth": false,
                        "scrollX": false,
                        "stateSave": false,
                        'pageLength': cantidad,
                        
                        
                    });

                    $("#modal-add-3").addClass('scroll-vertical')
        
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
                            body_matches += `
                            <tr>
                                <td class="text-center" style="padding: 0.4rem; ">
                                    <input type="checkbox" id="match_id_${x}" name="match_id[${x}]" class="matches-add" value="${response_data.id}" >
                                </td>
                                <td style="padding: 0.4rem;" id="match_league_name_${response_data.id}">${response_data.league.name}</td>
                                <td style="padding: 0.4rem;" id="match_local_team_name_${response_data.id}">${response_data.local_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_visitor_team_name_${response_data.id}">${response_data.visitor_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_start_date_${response_data.id}">${response_data.start_date}</td>
                            </tr>
                            `
                            x++
                        })

                        // Pintamos los registros en la tabla
                        $("#tblBracketsMatchesAdd tbody").html(body_matches);
                        
                        let cantidad = 200

                        // Agregamos el datatable
                        $("#tblBracketsMatchesAdd").DataTable({
                            "responsive": true, 
                            "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                            "lengthChange": true, 
                            "autoWidth": false,
                            "scrollX": false,
                            "stateSave": false,
                            'pageLength': cantidad,
                            
                            
                        });

                        $("#modal-add-3").addClass('scroll-vertical')
            
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


const listarBracketsMatchesEdit = () => {
    console.log('listarBracketsEdit')

    let divTable = $("#divBracketsMatchesEdit")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblBracketsMatchesEdit" class="table table-bordered table-striped">
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
    let sport_id = $("#sport_id_search_edit").val()
    let league_id = $("#league_id_edit").val()
    let date = $("#start_date_search_edit").val()

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
                        body_matches += `
                        <tr>
                            <td class="text-center" style="padding: 0.4rem; ">
                                <input type="checkbox" id="match_edit_id_${x}" name="match_edit_id_${x}" class="matches-add" value="${response_data.id}" >
                            </td>
                            <td style="padding: 0.4rem;" id="match_league_name_edit_${response_data.id}">${response_data.league.name}</td>
                            <td style="padding: 0.4rem;" id="match_local_team_name_edit_${response_data.id}">${response_data.local_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_visitor_team_name_edit_${response_data.id}">${response_data.visitor_team.name}</td>
                            <td style="padding: 0.4rem;" id="match_start_date_edit_${response_data.id}">${response_data.start_date}</td>
                        </tr>
                        `

                        x++
                    })

                    // Pintamos los registros en la tabla
                    $("#tblBracketsMatchesEdit tbody").html(body_matches);
                    
                    let cantidad = 100

                    // Agregamos el datatable
                    $("#tblBracketsMatchesEdit").DataTable({
                        "responsive": true, 
                        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                        "lengthChange": false, 
                        "autoWidth": false,
                        "scrollX": false,
                        "stateSave": false,
                        'pageLength': cantidad,
                        
                        
                    });

                    $("#modal-edit-3").addClass('scroll-vertical')
        
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
                        let string_match = ''

                        data.forEach(response_data=>{
                            console.log(response_data)

                            let selectedCheckMatch = ''
                            var res_fecha_edit = ''
                            var res_horario_edit = ''
                            if(response_data.start_date != '' && response_data.start_date != null){
                                [res_fecha_edit,res_horario_edit] = response_data.start_date.split('T')
                            }

                            // Es un partido nuevo que se va agregar al bracket
                            string_match = `${response_data.id},${response_data.start_date},${response_data.league.name},${response_data.local_team.name},${response_data.visitor_team.name}`

                            body_matches += `
                            <tr>
                                <td class="text-center" style="padding: 0.4rem; ">
                                `
                            body_matches += '<input type="checkbox" id="match_edit_id_'+response_data.id+'" name="match_edit_id['+response_data.id+']" class="matches-add" value="'+response_data.id+'" onclick="addMatchStorage('+response_data.id+',\''+string_match+'\')" >'
                            body_matches += '<input type="hidden" id="match_edit_old_id_'+response_data.id+'" name="match_edit_old_id['+response_data.id+']" value="'+selectedCheckMatch+'" >';
                            
                            body_matches += `
                                </td>
                                <td style="padding: 0.4rem;" id="match_league_name_edit_${response_data.id}">${response_data.league.name}</td>
                                <td style="padding: 0.4rem;" id="match_local_team_name_edit_${response_data.id}">${response_data.local_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_visitor_team_name_edit_${response_data.id}">${response_data.visitor_team.name}</td>
                                <td style="padding: 0.4rem;" id="match_start_date_edit_${response_data.id}">${response_data.start_date}</td>
                            </tr>
                            `
                            x++
                        })

                        // Pintamos los registros en la tabla
                        $("#tblBracketsMatchesEdit tbody").html(body_matches);
                        
                        let cantidad = 200

                        // Agregamos el datatable
                        $("#tblBracketsMatchesEdit").DataTable({
                            "responsive": true, 
                            "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                            "lengthChange": true, 
                            "autoWidth": false,
                            "scrollX": false,
                            "stateSave": false,
                            'pageLength': cantidad,
                            
                            
                        });

                        $("#modal-edit-3").addClass('scroll-vertical')
            
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

/**
 * It loops through all the checked checkboxes, and for each one, it gets the values of the other
 * elements in the row, and then it adds a row to the table with those values.
 */
// getMatches
const getMatches = () => {
    console.log('getMatches')

    var body_group = '';    

    $("input:checkbox:checked").each(function() {
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

const getResume = () => {
    console.log('getResume')

    let titulo = $('#titulo').val()
    let subtitulo = $('#subtitulo').val()
    let fecha_inicio = $('#fecha_inicio').val()
    let fecha_fin = $('#fecha_fin').val()

    let sponsor_id = $('#sponsor_id').val()
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
    var resume_table = document.getElementById("tblBracketsGroup");

    for (var i = 1, row; row = resume_table.rows[i]; i++) {
        /*
        // Recorrer celdas
        for (var j = 0, col; col = row.cells[j]; j++) {
            console.log(`Txt: ${col.innerText} \tFila: ${i} \t Celda: ${j}`)
        }
        */
        partido_liga = row.cells[0].innerText
        partido_local = row.cells[1].innerText
        partido_visitante = row.cells[2].innerText
        partido_fecha = row.cells[3].innerText

        console.log('partido_liga',partido_liga)

        body_partidos += `
        <tr>
            <td>${partido_local}</td>
            <td>${partido_visitante}</td>
        </tr>
        <tr>
            <td>${partido_liga}</td>
            <td>${partido_fecha}</td>
        </tr>
        <tr>
            <td id="grupo_resume_${i}"></td>
            <td id="jornada_resume_${i}"></td>
        </tr>
        `

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


    // Mostramos el resumen
    $('#titulo_resume').html(titulo)
    $('#subtitulo_resume').html(subtitulo)
    $('#fecha_inicio_resume').html(fecha_inicio)
    $('#fecha_fin_resume').html(fecha_fin)

    $('#sponsor_image_add_resume').attr('src',sponsor_img)
    $('#sport_image_add_resume').attr('src',sport_img)

    $("#modal-add-5").addClass('scroll-vertical')

}

const save = () => {
    console.log('save')

    $('#frmBracketAdd').submit()

    localStorage.removeItem("step3")
    localStorage.removeItem("step3_detail")
}

// delBrackets
const delBrackets = id => {
    //console.log('delBrackets')

    console.log(`
    bracket_id: ${id}
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
                url: '/brackets/delete',
                type: 'POST',
                data: { 
                    "bracket_id" : id,
                },
                success: function(response){
                    //console.log('success matches delete')
                    //console.log(JSON.parse(response))

                    Swal.fire(
                        '¡Eliminado!',
                        'Su registro ha sido eliminado.',
                        'success'
                    )

                    listarBrackets()
          
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
const modalEdit = bracket_id => {
    console.log('modalEdit')

    $.ajax({
        url: '/brackets/list_phase1/'+bracket_id,
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

            // Step 1
            // Datos generales del bracket
            let arrStartDate = data.start_date.split("T");
            let arrEndDate = data.end_date.split("T");
            let arrLimitDate = data.phase2_limit_date.split("T");

            $("#bracket_edit_id").val(data.id)

            $("#titulo_edit").val(data.title)
            $("#subtitulo_edit").val(data.subtitle)
            $("#fecha_inicio_edit").val(arrStartDate[0])
            $("#horario_inicio_edit").val(arrStartDate[1])
            $("#fecha_fin_edit").val(arrEndDate[0])
            $("#horario_fin_edit").val(arrEndDate[1])
            $("#fecha_limite_edit").val(arrLimitDate[0])
            $("#horario_limite_edit").val(arrLimitDate[1])

            $("#titulo_edit_old").val(data.title)
            $("#subtitulo_edit_old").val(data.subtitle)
            $("#fecha_inicio_edit_old").val(arrStartDate[0])
            $("#horario_inicio_edit_old").val(arrStartDate[1])
            $("#fecha_fin_edit_old").val(arrEndDate[0])
            $("#horario_fin_edit_old").val(arrEndDate[1])
            $("#fecha_limite_edit_old").val(arrLimitDate[0])
            $("#horario_limite_edit_old").val(arrLimitDate[1])

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

                if(data.monetary_awards == true){
                    awardNumber1 = arrAwards[i].replace(/[$,]/g, "");
                    awardNumber = parseInt(awardNumber1)
                }else{
                    awardNumber = arrAwards[i]
                }
                //console.log(parseInt(awardNumber1))

                //console.log(data.physical_awards)

                //Buscamos el premio físico
                let premio_fisico = data.physical_awards.find(element => element.place === i+1);
                console.log("premio_fisico: ", premio_fisico)

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
            let league_id = ''
            let sport_id = ''
            let arr_matches = ''
            let arr_matches2 = ''
            let x = 1

            // Eliminamos el step3_detail para crearlo de cero
            localStorage.removeItem("step3_detail")

            // Guardamos el step 3 detail
            var step3_detail = localStorage.getItem("step3_detail")
            console.log("step3_detail: "+step3_detail)

            arrStep3Detail = new Array()


            // Es donde buscamos los partidos
            Object.entries(data.matches).forEach(([key, obj_group]) => {
                //console.log(`${key} ${obj_group}`); 
                Object.entries(obj_group).forEach(([key2, obj_matches]) => {
                    //console.log(`${key2} ${obj_matches}`); 

                    if(obj_matches.match.league !== null){
                        league_id = obj_matches.match.league_id
                        sport_id = obj_matches.match.league.sport_id

                        if(x == 1){
                            // Creamos el string con el que pintaremos los checkbox en el step 3
                            arr_matches = obj_matches.match_id
                            
                            // Creamos el step3_detail con toda la información para el step 4
                            if(step3_detail==null){
                                arrStep3Detail.push({
                                    'id':obj_matches.id,
                                    'match_id':obj_matches.match_id,
                                    'fecha':obj_matches.match.start_date,
                                    'league_name':obj_matches.match.league.name,
                                    'local_name':obj_matches.match.local_team.name,
                                    'visitor_name':obj_matches.match.visitor_team.name,
                                    'grupo':obj_matches.group,
                                    'jornada':obj_matches.phase
                                }) 
                                //console.log("arrStep3Detail",arrStep3Detail)
                                localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                            }else{
                                arrStep3Detail.push({
                                    'id':obj_matches.id,
                                    'match_id':obj_matches.match_id,
                                    'fecha':obj_matches.match.start_date,
                                    'league_name':obj_matches.match.league.name,
                                    'local_name':obj_matches.match.local_team.name,
                                    'visitor_name':obj_matches.match.visitor_team.name,
                                    'grupo':obj_matches.group,
                                    'jornada':obj_matches.phase
                                }) 
                                //console.log("arrStep3Detail",arrStep3Detail)
                                localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                            }
                        }else{
                            // Creamos el string con el que pintaremos los checkbox en el step 3
                            arr_matches += ','+obj_matches.match_id

                            // Creamos el step3_detail con toda la información para el step 4
                            if(step3_detail==null){
                                arrStep3Detail.push({
                                    'id':obj_matches.id,
                                    'match_id':obj_matches.match_id,
                                    'fecha':obj_matches.match.start_date,
                                    'league_name':obj_matches.match.league.name,
                                    'local_name':obj_matches.match.local_team.name,
                                    'visitor_name':obj_matches.match.visitor_team.name,
                                    'grupo':obj_matches.group,
                                    'jornada':obj_matches.phase
                                }) 
                                //console.log("arrStep3Detail",arrStep3Detail)
                                localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                            }else{
                                arrStep3Detail.push({
                                    'id':obj_matches.id,
                                    'match_id':obj_matches.match_id,
                                    'fecha':obj_matches.match.start_date,
                                    'league_name':obj_matches.match.league.name,
                                    'local_name':obj_matches.match.local_team.name,
                                    'visitor_name':obj_matches.match.visitor_team.name,
                                    'grupo':obj_matches.group,
                                    'jornada':obj_matches.phase
                                }) 
                                //console.log("arrStep3Detail",arrStep3Detail)
                                localStorage.setItem('step3_detail', JSON.stringify(arrStep3Detail))
                            }
                        }
                        
                    }
                    x++
                })
            })

            console.log("league_id: ",league_id)
            console.log("sport_id: ",sport_id)
            console.log("arr_matches: ",arr_matches)

            $("#sport_id_search_edit").val(sport_id)

            setTimeout(function(){
                // Si existe el league_id llamamos la función para construir los inputs checkbox
                if(league_id != ''){
                    selectSportModalEdit(league_id,sport_id,arr_matches,arr_matches2)
                }    
            }, 2000);

            // Step 4
            // Agregamos el grupo y la jornada
            let body_match = ''
            let body_match_resume = ''
            let league_name = ''

            Object.entries(data.matches).forEach(([key, obj_group]) => {
                //console.log(`${key} ${obj_group}`); 
                Object.entries(obj_group).forEach(([key2, obj_matches]) => {
                    //console.log(`${key2} ${obj_matches}`); 

                    if(obj_matches.match.league !== null){
                        league_name = obj_matches.match.league.name
                    }
                    
                    body_match += `
                    <tr>
                        <td>${league_name}</td>
                        <td>${obj_matches.match.local_team.name}</td>
                        <td>${obj_matches.match.visitor_team.name}</td>
                        <td>${obj_matches.match.start_date}</td>
                        <td>
                            <input type="text" id="grupo_${obj_matches.match_id}" name="grupo[${obj_matches.match_id}]" class="form-control grupo-edit" value="${obj_matches.group}">
                            <input type="hidden" id="grupo_old_${obj_matches.match_id}" name="grupo_old[${obj_matches.match_id}]" class="form-control grupo-edit" value="${obj_matches.group}">
                        </td>
                        <td>
                            <input type="text" id="jornada_${obj_matches.match_id}" name="jornada[${obj_matches.match_id}]" class="form-control jornada-edit" value="${obj_matches.phase}">
                            <input type="hidden" id="jornada_old_${obj_matches.match_id}" name="jornada_old[${obj_matches.match_id}]" class="form-control jornada-edit" value="${obj_matches.phase}">
                        </td>
                    </tr>
                    `

                    body_match_resume += `
                    <tr>
                        <td>${obj_matches.match.local_team.name}</td>
                        <td>${obj_matches.match.visitor_team.name}</td>
                    </tr>
                    <tr>
                        <td>${league_name}</td>
                        <td>${obj_matches.match.start_date}</td>
                    </tr>
                    <tr>
                        <td>${obj_matches.group}</td>
                        <td>${obj_matches.phase}</td>
                    </tr>
                    `
                    
                })
            })

            //console.log(body_match)

            $("#tblBracketsGroupEdit tbody").html(body_match)
            $("#modal-edit-4").addClass('scroll-vertical')

            // Step 5
            // Resumen
            $("#titulo_resume_edit").html(data.title)
            $("#subtitulo_resume_edit").html(data.subtitle)
            $("#fecha_inicio_resume_edit").html(arrStartDate[0])
            $("#fecha_fin_resume_edit").html(arrEndDate[0])

            $("#partidos_resume_edit tbody").html(body_match_resume)
            $("#premios_resume_edit tbody").html(body_awards_resume)

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

    localStorage.removeItem("step3")
    localStorage.removeItem("step3_detail")

    $('#frmBracketEdit').submit()
}


// nextModalEdit
const nextModalEdit = (hideStep,showStep) => {
    console.log('nextModalEdit')

    // Step 4
    if(showStep == 4){
        var step3_detail = localStorage.getItem("step3_detail")

        let body_match = ''
        let body_match_resume = ''

        if(step3_detail != null){
            step3_detail = JSON.parse(step3_detail);
            console.log(step3_detail)

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
                <tr>
                    <td>${value.local_name}</td>
                    <td>${value.visitor_name}</td>
                </tr>
                <tr>
                    <td>${value.league_name}</td>
                    <td>${value.fecha}</td>
                </tr>
                    <td>${value.grupo}</td>
                    <td>${value.jornada}</td>
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
const selectSportModalEdit = (league_id,sport_id,arreglo) => {
    console.log('selectSportModalEdit')

    // Convertimos el string en array, match_id
    arr_matches = arreglo.split(',')
    console.log(arr_matches)


    let divTable = $("#divBracketsMatchesEdit")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblBracketsMatchesEdit" class="table table-bordered table-striped">
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
            console.log(JSON.parse(response_matches))
            
            data = JSON.parse(response_matches)

            // Eliminamos el step3 para crearlo de cero
            localStorage.removeItem("step3")

            // Guardamos el step 3
            var step3 = localStorage.getItem("step3")
            console.log("step3: "+step3)

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
            $("#tblBracketsMatchesEdit tbody").html(body_matches);
            
            let cantidad = 200

            // Agregamos el datatable
            $("#tblBracketsMatchesEdit").DataTable({
                "responsive": true, 
                "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
                "lengthChange": true, 
                "autoWidth": false,
                "scrollX": false,
                "stateSave": false,
                'pageLength': cantidad,
                
                
            });

            $("#modal-edit-3").addClass('scroll-vertical')

        },
        error: function (obj, error, objError){
        var error = objError
        console.log('Error al obtener el resultado. '+ error)
        }
    })
}


// addMatchStorage
// Desvinculamos el partido seleccionado del bracket
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
// Agregamos el partido seleccionado al bracket
const editMatchStorage = id => {
    console.log('editMatchStorage')
    //console.log('id: ',id)

    Swal.fire({
        title: '¿Deseas desvincular este partido del bracket?',
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

            if(id_desvincular_partido != ''){
                
                $.ajax({
                    url: '/brackets/remove_match',
                    type: 'POST',
                    data: { 
                        "bracket_match_id" : id_desvincular_partido
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


const phase1 = (bracket_id = '') => {
    console.log('phase1')

    if(bracket_id != ''){

        $.ajax({
            url: '/brackets/list_phase1/'+bracket_id,
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

                let arr_matches_all = []
                let element = {}

                let x = 0
                let index = ''

                // Es donde buscamos los partidos
                Object.entries(data.matches).forEach(([key, obj_group]) => {
                    //console.log(`${key} ${obj_group}`); 
                    Object.entries(obj_group).forEach(([key2, obj_matches]) => {
                        //console.log(`${key2} ${obj_matches}`); 

                        //console.log('x: ',x)
                        //console.log(obj_matches.match.local_team.id)
                        //console.log(obj_matches.match.local_team.name)

                        /*
                        if(obj_matches.match.league !== null){
                            league_id = obj_matches.match.league_id
                            sport_id = obj_matches.match.league.sport_id
                        }
                        */
                        
                        arr_matches_all[x] = {
                            'id': obj_matches.match.local_team.id,
                            'name': obj_matches.match.local_team.name
                            //'grupo': obj_matches.group
                        }
                        
                        x++

                        arr_matches_all[x] = {
                            'id': obj_matches.match.visitor_team.id,
                            'name': obj_matches.match.visitor_team.name
                            //'grupo': obj_matches.group
                        }
                        
                        x++
                        
                    })
                })

                //console.log(arr_matches_all)

                let set = new Set( arr_matches_all.map( JSON.stringify ) )
                let arr_matches = Array.from( set ).map( JSON.parse );

                //console.log(arr_matches)

                arr_matches.sort(function (a, b) {
                    if (a.name > b.name) {
                      return 1
                    }
                    if (a.name < b.name) {
                      return -1
                    }
                    // a must be equal to b
                    return 0
                })

                console.log(arr_matches)

            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
            }

        }) // END ajax
    } // END if
}

const selectBubble = (item,position,match_number,match_id) => {
    console.log('selectBubble')
    console.log(`item: ${item}, position: ${position}, match_number: ${match_number}, match_id: ${match_id}`)

    $("#bubble_item").val(item)
    $("#bubble_position").val(position)
    $("#match_number").val(match_number)
    $("#match_id").val(match_id)


}

const selectTeamPhase2 = (id,name) => {
    console.log('selectTeam')
    console.log(`id: ${id}, name: ${name}`)

    let item = $("#bubble_item").val()
    let position = $("#bubble_position").val()
    let match_number = $("#match_number").val()
    let match_id = $("#match_id").val()

    let bubble = item+'_'+position

    $("#"+bubble+" .item-text").html(name)

    

    switch(bubble){
        // match number 1
        case 'item1_left8':
            $("#match_number_1").val(match_number)
            $("#match_id_1").val(match_id)
            $("#local_team_id_1").val(id)
        break;

        case 'item2_left8':
            $("#match_number_1").val(match_number)
            $("#match_id_1").val(match_id)
            $("#visitor_team_id_1").val(id)
        break;

        // match number 2
        case 'item3_left8':
            $("#match_number_2").val(match_number)
            $("#match_id_2").val(match_id)
            $("#local_team_id_2").val(id)
        break;

        case 'item4_left8':
            $("#match_number_2").val(match_number)
            $("#match_id_2").val(match_id)
            $("#visitor_team_id_2").val(id)
        break;

        // match number 3
        case 'item5_left8':
            $("#match_number_3").val(match_number)
            $("#match_id_3").val(match_id)
            $("#local_team_id_3").val(id)
        break;

        case 'item6_left8':
            $("#match_number_3").val(match_number)
            $("#match_id_3").val(match_id)
            $("#visitor_team_id_3").val(id)
        break;

        // match number 4
        case 'item7_left8':
            $("#match_number_4").val(match_number)
            $("#match_id_4").val(match_id)
            $("#local_team_id_4").val(id)
        break;

        case 'item8_left8':
            $("#match_number_4").val(match_number)
            $("#match_id_4").val(match_id)
            $("#visitor_team_id_4").val(id)
        break;

        // match number 5
        case 'item1_right8':
            $("#match_number_5").val(match_number)
            $("#match_id_5").val(match_id)
            $("#local_team_id_5").val(id)
        break;

        case 'item2_right8':
            $("#match_number_5").val(match_number)
            $("#match_id_5").val(match_id)
            $("#visitor_team_id_5").val(id)
        break;

        // match number 6
        case 'item3_right8':
            $("#match_number_6").val(match_number)
            $("#match_id_6").val(match_id)
            $("#local_team_id_6").val(id)
        break;

        case 'item4_right8':
            $("#match_number_6").val(match_number)
            $("#match_id_6").val(match_id)
            $("#visitor_team_id_6").val(id)
        break;

        // match number 7
        case 'item5_right8':
            $("#match_number_7").val(match_number)
            $("#match_id_7").val(match_id)
            $("#local_team_id_7").val(id)
        break;

        case 'item6_right8':
            $("#match_number_7").val(match_number)
            $("#match_id_7").val(match_id)
            $("#visitor_team_id_7").val(id)
        break;

        // match number 8
        case 'item7_right8':
            $("#match_number_8").val(match_number)
            $("#match_id_8").val(match_id)
            $("#local_team_id_8").val(id)
        break;

        case 'item8_right8':
            $("#match_number_8").val(match_number)
            $("#match_id_8").val(match_id)
            $("#visitor_team_id_8").val(id)
        break;

        // match number 9
        case 'item1_left4':
            $("#match_number_9").val(match_number)
            $("#match_id_9").val(match_id)
            $("#local_team_id_9").val(id)
        break;

        case 'item2_left4':
            $("#match_number_9").val(match_number)
            $("#match_id_9").val(match_id)
            $("#visitor_team_id_9").val(id)
        break;

        // match number 10
        case 'item3_left4':
            $("#match_number_10").val(match_number)
            $("#match_id_10").val(match_id)
            $("#local_team_id_10").val(id)
        break;

        case 'item4_left4':
            $("#match_number_10").val(match_number)
            $("#match_id_10").val(match_id)
            $("#visitor_team_id_10").val(id)
        break;

        // match number 11
        case 'item1_right4':
            $("#match_number_11").val(match_number)
            $("#match_id_11").val(match_id)
            $("#local_team_id_11").val(id)
        break;

        case 'item2_right4':
            $("#match_number_11").val(match_number)
            $("#match_id_11").val(match_id)
            $("#visitor_team_id_11").val(id)
        break;

        // match number 12
        case 'item3_right4':
            $("#match_number_12").val(match_number)
            $("#match_id_12").val(match_id)
            $("#local_team_id_12").val(id)
        break;

        case 'item4_right4':
            $("#match_number_12").val(match_number)
            $("#match_id_12").val(match_id)
            $("#visitor_team_id_12").val(id)
        break;

        // match number 13
        case 'item1_left2':
            $("#match_number_13").val(match_number)
            $("#match_id_13").val(match_id)
            $("#local_team_id_13").val(id)
        break;

        case 'item2_left2':
            $("#match_number_13").val(match_number)
            $("#match_id_13").val(match_id)
            $("#visitor_team_id_13").val(id)
        break;

        // match number 14
        case 'item1_right2':
            $("#match_number_14").val(match_number)
            $("#match_id_14").val(match_id)
            $("#local_team_id_14").val(id)
        break;

        case 'item2_right2':
            $("#match_number_14").val(match_number)
            $("#match_id_14").val(match_id)
            $("#visitor_team_id_14").val(id)
        break;

        // match number 15
        case 'item1_left1':
            $("#match_number_15").val(match_number)
            $("#match_id_15").val(match_id)
            $("#local_team_id_15").val(id)
        break;

        case 'item1_right1':
            $("#match_number_15").val(match_number)
            $("#match_id_15").val(match_id)
            $("#visitor_team_id_15").val(id)
        break;

    }

    $("#btnSavePhase2").show('slow')
    $('#modal-equipos').modal('hide')

}

const savePhase2 = () => {
    console.log('savePhase2')

    Swal.fire({
        title: '¿Deseas agregar o modificar los partidos?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#frmFase2').submit()
        }
    })
}

// matchesModalEdit
const matchesModalEdit = (sport_id,match_id,league_id,local_id,visitor_id,fecha,horario,spread,local_team_score,visitor_team_score,status,result) => {
    //console.log('matchesModalEdit')

    /*
    console.log(`
    sport_id: ${sport_id}
    match_id: ${match_id}
    league_id: ${league_id}
    local: ${local_id}
    visitante: ${visitor_id}
    fecha: ${fecha}
    horario: ${horario}
    spread: ${spread}
    `)
    */

    data = `${sport_id},${match_id},${league_id},${local_id},${visitor_id},${fecha},${horario},${spread},${local_team_score},${visitor_team_score},${status},${result}`

    selectSport(sport_id,'match_edit',data)
}

/*
 * It makes an ajax call to get the leagues, then it makes another ajax call to get the teams, then it
 * populates the select boxes with the results.
 */
// selectSport
const selectSport = (id,op = '',data = '') => {
    //console.log('selectSport')

    switch(op) {
        case 'match':
            $("#sport_id_search").val(id)
            $(".sport").removeClass('sport-selected')
            $("#sport_img_"+id).addClass('sport-selected')                
            break;

        case 'match_add':
            $("#sport_id").val(id)
            $(".sport-add").removeClass('sport-selected')
            $("#sport_image_add_"+id).addClass('sport-selected')    
    
            selectMatches(id)
            break;

        case 'match_edit':
            $("#sport_edit_id").val(id)
            $(".sport-edit").removeClass('sport-selected')
            $("#sport_image_edit_"+id).addClass('sport-selected') 
        
            selectMatches(id,'edit',data)
            break;
    }

}

/**
 * It takes an id, an optional op, and an optional dataMatches, and then it does a bunch of stuff.
 * @param id - 1
 * @param [op] - edit
 * @param [dataMatches] - "1,1,1,1,2020-01-01,00:00:00,0"
 */
// selectMatches
const selectMatches = (id, op= '',dataMatches='') => {

    /*
    console.log(`
    id: ${id}
    op: ${op}
    dataMatches: ${dataMatches}
    `)
    */

    var sport_edit_id = ''
    var match_edit_id = ''
    var league_edit_id = ''
    var local_edit_id = ''
    var visitor_edit_id = ''
    var fecha_edit = ''
    var horario_edit = ''
    var spread_edit = ''

    var local_team_score = ''
    var visitor_team_score = ''
    var status = ''
    var result = ''

    if(dataMatches != ''){
        [sport_edit_id,match_edit_id,league_edit_id,local_edit_id,visitor_edit_id,fecha_edit,horario_edit,spread_edit,local_team_score,visitor_team_score,status,result] = dataMatches.split(',')

        
        console.log(`
        sport_edit_id: ${sport_edit_id}
        match_edit_id: ${match_edit_id}
        league_edit_id: ${league_edit_id}
        local_edit_id: ${local_edit_id}
        visitor_edit_id: ${visitor_edit_id}
        fecha_edit: ${fecha_edit}
        horario_edit: ${horario_edit}
        spread_edit: ${spread_edit}

        local_team_score: ${local_team_score}
        visitor_team_score: ${visitor_team_score}
        status: ${status}
        result: ${result}
        `)
        
    }

    // Consultamos la Liga
    $.ajax({
        url: '/matches/leagues',
        type: 'GET',
        data: { "sport_id" : id },
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

                if(league_id == league_edit_id){
                    option_status_league = 'selected'
                }

                input_league += `
                    <option value="${league_id}" ${option_status_league}>${league_name}</option>
                `
            })

            if(op == 'edit'){
                $("#league_edit_id").html(input_league);
            }else{
                $("#league_id").html(input_league);
            }
            
            // Consultamos los Equipos
            $.ajax({
                url: '/matches/teams',
                type: 'GET',
                data: { "sport_id" : id },
                beforeSend: function() {
                    $("#loading2").show();
                    $("#loading-text-2").html('Procesando Equipos, espere un momento....');
                },
                complete: function() {
                    $("#loading2").hide();
                },
                success: function(response_teams){
                    //console.log('success teams')
                    console.log(JSON.parse(response_teams))
        
                    data_teams = JSON.parse(response_teams)
        
                    var input_team_local = '<option value="">Seleccionar</option>'
                    var input_team_visitor = '<option value="">Seleccionar</option>'
        
                    data_teams.forEach(response_data_teams=>{
                        var team_id = response_data_teams.id
                        var team_name = response_data_teams.name
                        var option_status_local_team = ''
                        var option_status_visitor_team = ''

                        if(team_id == local_edit_id){
                            option_status_local_team = 'selected'
                        }

                        if(team_id == visitor_edit_id){
                            option_status_visitor_team = 'selected'
                        }
        
                        input_team_local += `
                            <option value="${team_id}" ${option_status_local_team}>${team_name}</option>
                        `
                        input_team_visitor += `
                            <option value="${team_id}" ${option_status_visitor_team}>${team_name}</option>
                        `
                    })

                    if( spread_edit == null ){
                        spread_edit = ''
                    }

                    if(op == 'edit'){
                        // inputs
                        $("#local_team_edit").html(input_team_local);
                        $("#visitor_team_edit").html(input_team_visitor);
                        $("#start_date_edit").val(fecha_edit)
                        $("#start_time_edit").val(horario_edit)
                        $("#spread_edit").val(spread_edit)

                        $("#local_team_score").val(local_team_score)
                        $("#visitor_team_score").val(visitor_team_score)
                        $("#status_edit").val(status)
                        $("#result_edit").val(result)

                        $("#match_edit_id").val(match_edit_id)

                        // inputs old
                        $("#league_edit_id_old").val(league_edit_id)
                        $("#local_team_edit_old").val(local_edit_id)
                        $("#visitor_team_edit_old").val(visitor_edit_id)
                        $("#start_date_edit_old").val(fecha_edit)
                        $("#start_time_edit_old").val(horario_edit)
                        $("#spread_edit_old").val(spread_edit)

                        $("#local_team_score_old").val(local_team_score)
                        $("#visitor_team_score_old").val(visitor_team_score)
                        $("#status_edit_old").val(status)
                        $("#result_edit_old").val(result)


                    }else{
                        $("#local_team").html(input_team_local);
                        $("#visitor_team").html(input_team_visitor);    
                    }
          
                },
                error: function (obj, error, objError){
                    var error = objError
                    console.log('Error al obtener el resultado. '+ error)
                }
            })
  
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })
}

/**
 * It takes the values of the inputs and sends them to the server via ajax.
 */
// editMatches
const editMatches = () => {
    console.log('editMatches')

    // inputs
    let league_id = $("#league_edit_id").val()
    let local_team = $("#local_team_edit").val()
    let visitor_team = $("#visitor_team_edit").val()
    let start_date = $("#start_date_edit").val()
    let start_time = $("#start_time_edit").val()
    let spread = $("#spread_edit").val()
    let sport_id = $("#sport_edit_id").val()
    let match_id = $("#match_edit_id").val()

    let local_team_score = $("#local_team_score").val()
    let visitor_team_score = $("#visitor_team_score").val()
    let status_edit = $("#status_edit").val()
    let result_edit = $("#result_edit").val()

    // inputs old
    let league_edit_id_old = $("#league_edit_id_old").val()
    let local_team_edit_old = $("#local_team_edit_old").val()
    let visitor_team_edit_old = $("#visitor_team_edit_old").val()
    let start_date_edit_old = $("#start_date_edit_old").val()
    let start_time_edit_old = $("#start_time_edit_old").val()
    let spread_edit_old = $("#spread_edit_old").val()

    let local_team_score_old = $("#local_team_score_old").val()
    let visitor_team_score_old = $("#visitor_team_score_old").val()
    let status_edit_old = $("#status_edit_old").val()
    let result_edit_old = $("#result_edit_old").val()



    /*
    console.log(`
    league_id: ${league_id}
    local_team: ${local_team}
    visitor_team: ${visitor_team}
    start_date: ${start_date}
    start_time: ${start_time}
    spread: ${spread}
    sport_id: ${sport_id}
    match_id: ${match_id}

    local_team_score: ${local_team_score}
    visitor_team_score: ${visitor_team_score}
    status_edit: ${status_edit}
    result_edit: ${result_edit}

    league_edit_id_old: ${league_edit_id_old}
    local_team_edit_old: ${local_team_edit_old}
    visitor_team_edit_old: ${visitor_team_edit_old}
    start_date_edit_old: ${start_date_edit_old}
    start_time_edit_old: ${start_time_edit_old}
    spread_edit_old: ${spread_edit_old}

    local_team_score_old: ${local_team_score_old}
    visitor_team_score_old: ${visitor_team_score_old}
    status_edit_old: ${status_edit_old}
    result_edit_old: ${result_edit_old}
    `)
    */

    $.ajax({
        url: '/matches/update',
        type: 'POST',
        data: { 
            "league_id" : league_id, 
            "local_team" : local_team, 
            "visitor_team" : visitor_team,
            "start_date" : start_date,
            "start_time" : start_time,
            "spread" : spread,
            "sport_id" : sport_id,
            "match_id" : match_id,

            "local_team_score" : local_team_score,
            "visitor_team_score" : visitor_team_score,
            "status_edit" : status_edit,
            "result_edit" : result_edit,

            "league_edit_id_old" : league_edit_id_old,
            "local_team_edit_old" : local_team_edit_old,
            "visitor_team_edit_old" : visitor_team_edit_old,
            "start_date_edit_old" : start_date_edit_old,
            "start_time_edit_old" : start_time_edit_old,
            "spread_edit_old" : spread_edit_old,

            "local_team_score_old" : local_team_score_old,
            "visitor_team_score_old" : visitor_team_score_old,
            "status_edit_old" : status_edit_old,
            "result_edit_old" : result_edit_old,
        },
        success: function(response){
            console.log('success matches edit')
            console.log(JSON.parse(response))

            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Tu partido se modificó exitosamente',
            })

            // inputs
            $("#league_edit_id").val('')
            $("#local_team_edit").val('')
            $("#visitor_team_edit").val('')
            $("#start_date_edit").val('')
            $("#start_time_edit").val('')
            $("#spread_edit").val('')
            $("#sport_edit_id").val('')
            $("#match_edit_id").val('')

            $("#local_team_score").val('')
            $("#visitor_team_score").val('')
            $("#status_edit").val('')
            $("#result_edit").val('')

            // inputs old
            $("#league_edit_id_old").val('')
            $("#local_team_edit_old").val('')
            $("#visitor_team_edit_old").val('')
            $("#start_date_edit_old").val('')
            $("#start_time_edit_old").val('')
            $("#spread_edit_old").val('')

            $("#local_team_score_old").val('')
            $("#visitor_team_score_old").val('')
            $("#status_edit_old").val('')
            $("#result_edit_old").val('')

            $('#modal-edit').modal('hide')

            location.reload()
  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })

}

// Mostrar el modal para cambiar el estatus de las quinielas
const chageStatus = (bracket_id,status) => {
    console.log('chageStatus')

    $("#status_streak_id").val(bracket_id)

    let inputStatus = ''

    let status_open = ''
    let status_running = ''
    let status_finished = ''

    switch(status){
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
        <input type="hidden" name="status_bracket_id" id="status_bracket_id" value="${bracket_id}">
        <input type="radio" name="status" value="open" ${status_open}> abierto <br>
        <input type="radio" name="status" value="running" ${status_running}> en curso <br>
        <input type="radio" name="status" value="finished" ${status_finished}> finalizado <br>
    `
    
    $("#divStatus").html(inputStatus)
    $('#modal-status').modal('show');

}

// Cambiar estatus de las quinielas
const saveStatus = () => {
    let bracket_id = $("#status_bracket_id").val()
    let status = $('input:radio[name=status]:checked').val()

    //console.log('pool_id', pool_id)
    //console.log('status', status)

    Swal.fire({
        title: '¿Deseas modificar el estatus del bracket?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, cambiar estatus!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/brackets/status',
                type: 'POST',
                data: { 
                    "bracket_id" : bracket_id,
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

                    window.self.location='/brackets'
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
        
        }
    })
}