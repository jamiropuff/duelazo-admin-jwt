/* Initializing the sports. */
$( document ).ready(function() {
	// Inicializamos la especialidad
    initGetSports();
});


/**
 * It gets a list of sports from the server, and then it creates a list of sports in the DOM.
 */
const initGetSports = () => {
    console.log('initGetSports');

    let resources_sport_file = $("#resources_sport_file").val();
    let resources_sport_file_exist = $("#resources_sport_file_exist").val();
    let resources_sport_id = $("#resources_sport_id").val();

    let arr_sport_file = resources_sport_file.split(',');
    let arr_sport_file_exist = resources_sport_file_exist.split(',');
    let arr_sport_id = resources_sport_id.split(',');
    //console.log(arr_sport_file);
    //console.log(arr_sport_id);

    let resultSports = '';
    let resultSportsAdd = '';
    let resultSportsEdit = '';

    for(var i = 0; i < arr_sport_file.length; i++){

        // console.log('i: ', i);
        // console.log('id: ', arr_sport_id[i]);
        // console.log('file: ', arr_sport_file[i]);

        let sport_id = arr_sport_id[i];
        let file_id = arr_sport_file[i];

        //console.log('sport_id: ',sport_id)
        //console.log('file_id: ',file_id)

        // Verificamos si existe el file_id en el arreglo, esto quiere decir que la imagen la tenemos en el servidor local, de lo contrario la pedimos
        if(arr_sport_file_exist.indexOf(file_id)){
            //console.log('imagen local')
            // Creamos los deportes para la consulta
            resultSports = `
                <label id="sport_match_id_${sport_id}" class="cur-pointer">
                <img id="sport_img_${sport_id}" src="images/icons/${file_id}.png" class="img-fluid mrg-lr-10 sport" width="50px">
                </label>
            `;

            // Pintamos el resultSports en el div correspondiente
            $("#resultSports").append(resultSports);

            // Creamos el onclick para los deportes de la consulta
            document.getElementById("sport_match_id_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match')");

            /******************************************/

            // Creamos los deportes para el modal de la creación de quinielas
            resultSportsAdd = `
                <label id="sport_match_id_add_${sport_id}" class="cur-pointer">
                <img id="sport_image_add_${sport_id}" src="images/icons/${file_id}.png" class="img-fluid mrg-lr-10 sport" width="50px">
                </label>
            `;

            // Pintamos el resultSportsAdd en el div correspondiente
            $("#resultSportsAdd").append(resultSportsAdd);

            // Creamos el onclick para los deportes del modal de la creación de la quiniela
            document.getElementById("sport_match_id_add_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match_add')");

            /******************************************/

            // Creamos los deportes para el modal de la edición de quinielas
            resultSportsEdit = `
                <label id="sport_match_id_edit_${sport_id}" class="cur-pointer">
                <img id="sport_image_add_${sport_id}" src="images/icons/${file_id}.png" class="img-fluid mrg-lr-10 sport" width="50px">
                </label>
            `;

            // Pintamos el resultSportsEdit en el div correspondiente
            $("#resultSportsEdit").append(resultSportsEdit);

            // Creamos el onclick para los deportes del modal de la edición de la quiniela
            document.getElementById("sport_match_id_edit_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match_edit')");
        }else{
            // No existe la iamgen en el servidor local, la pedimos al API
            //console.log('pedimos la imagen al servidor')
            $.ajax({
                url: '/brackets/file/'+file_id,
                type: 'GET',
                
                beforeSend: function() {
                    $("#loading1").show();
                    $("#loading-text-1").html('Procesando, espere un momento....');
                },
                complete: function() {
                    $("#loading1").hide();
                },
                
                success: function(response){
                    //console.log('success file')
                    //console.log(JSON.parse(response))
                    
                    data = JSON.parse(response)
    
                    if(data != null){
    
                        // Creamos los deportes para la consulta
                        resultSports = `
                            <label id="sport_match_id_${sport_id}" class="cur-pointer">
                            <img id="sport_img_${sport_id}" src="${data}" class="img-fluid mrg-lr-10 sport" width="50px">
                            </label>
                        `;
    
                        // Pintamos el resultSports en el div correspondiente
                        $("#resultSports").append(resultSports);
    
                        // Creamos el onclick para los deportes de la consulta
                        document.getElementById("sport_match_id_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match')");
    
                        /******************************************/
    
                        // Creamos los deportes para el modal de la creación de quinielas
                        resultSportsAdd = `
                            <label id="sport_match_id_add_${sport_id}" class="cur-pointer">
                            <img id="sport_image_add_${sport_id}" src="${data}" class="img-fluid mrg-lr-10 sport" width="50px">
                            </label>
                        `;
    
                        // Pintamos el resultSportsAdd en el div correspondiente
                        $("#resultSportsAdd").append(resultSportsAdd);
    
                        // Creamos el onclick para los deportes del modal de la creación de la quiniela
                        document.getElementById("sport_match_id_add_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match_add')");
    
                        /******************************************/
    
                        // Creamos los deportes para el modal de la edición de quinielas
                        resultSportsEdit = `
                            <label id="sport_match_id_edit_${sport_id}" class="cur-pointer">
                            <img id="sport_image_add_${sport_id}" src="${data}" class="img-fluid mrg-lr-10 sport" width="50px">
                            </label>
                        `;
    
                        // Pintamos el resultSportsEdit en el div correspondiente
                        $("#resultSportsEdit").append(resultSportsEdit);
    
                        // Creamos el onclick para los deportes del modal de la edición de la quiniela
                        document.getElementById("sport_match_id_edit_"+sport_id).setAttribute("onclick","selectSport("+sport_id+",'match_edit')");
    
                    }else{
    
                        $("#loading1").hide();
    
                        Swal.fire({
                            icon: 'warning',
                            title: 'No se encontro ninguna imagen del deporte',
                            text: 'Comunicate con el Administrador...',
                        })
                    }
                    
                    
        
                },
                error: function (obj, error, objError){
                    var error = objError
                    console.log('Error al obtener el resultado. '+ error)
                    $("#loading1").hide();
                }
            })

        } // else
    } // for
    
}

/*
 * It makes an ajax call to get the leagues, then it makes another ajax call to get the teams, then it
 * populates the select boxes with the results.
 */
// selectSport
const selectSport = (id,op = '',data = '') => {
    console.log('selectSport')

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
    console.log('selectMatches');

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

        /*
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
        */
    }

    // Consultamos la Liga
    $.ajax({
        url: '/matches/leagues',
        type: 'GET',
        data: { "sport_id" : id },
        beforeSend: function() {
            $("#loading1").show();
            //$("#loading-text-1").html('Procesando Ligas, espere un momento....');
        },
        complete: function() {
            $("#loading1").hide();
        },
        success: function(response_league){
            //console.log('success leagues')
            //console.log(JSON.parse(response_league))
            
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
                    //$("#loading-text-2").html('Procesando Equipos, espere un momento....');
                },
                complete: function() {
                    $("#loading2").hide();
                },
                success: function(response_teams){
                    //console.log('success teams')
                    //console.log(JSON.parse(response_teams))
        
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
                    $("#loading1").hide();
                }
            })
  
        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
            $("#loading1").hide();
        }
    })
}

/**
 * I'm using ajax to get data from the server, then I'm using the data to populate a table, then I'm
 * using the datatable plugin to format the table. 
 * 
 * I'm using the datatable plugin to format the table because I need to be able to export the table to
 * excel, pdf, and print. 
 */
// listarMatches
const listarMatches = () => {
    //console.log('listarMatches')

    // Seleccionamos el div donde colocaremos el contenido de la tabla
    let divTable = $("#divMatches")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblMatches" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Liga</th>
                <th>Local</th>
                <th>Visitante</th>
                <th>Horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    `
    divTable.append(table)

    // recuperamos las variables para la consulta
    let sport_id = $("#sport_id_search").val()
    let date = $("#start_date_search").val()

    if(sport_id != '' && sport_id > 0) {

        if(date != ''){
            /*
            console.log(`
            sport_id: ${sport_id}
            date: ${date}
            `)
            */

            // Realizamos la consulta
            $.ajax({
                url: '/matches/date',
                type: 'GET',
                data: { 
                    "sport_id" : sport_id, 
                    "date" : date
                },
                beforeSend: function() {
                    $("#loading2").show();
                    $("#loading-text-2").html('Procesando Ligas, espere un momento....');
                },
                complete: function() {
                    $("#loading2").hide();
                },
                success: function(response_matches){
                    //console.log('success matches')
                    //console.log(JSON.parse(response_matches))
                    
                    data = JSON.parse(response_matches)

                    let body_matches = ''

                    try {
                        data.forEach(response_data=>{
                            var res_fecha_edit = ''
                            var res_horario_edit = ''
                            var league_name = ''
                            var league_sport_id = ''
                            var league_id = ''

                            // MArcadores del partido
                            var local_team_score = ''
                            var visitor_team_score = ''
                            var status = ''
                            var result = ''

                            if(response_data.start_date != '' && response_data.start_date != null){
                                [res_fecha_edit,res_horario_edit] = response_data.start_date.split('T')
                            }

                            if(response_data.league != '' && response_data.league != null){
                                league_name = response_data.league.name
                                league_sport_id = response_data.league.sport_id
                                league_id = response_data.league_id
                            }

                            // local_team_score
                            if(response_data.local_team_score != '' && response_data.local_team_score != null) {
                                local_team_score = response_data.local_team_score
                            }

                            // visitor_team_score
                            if(response_data.visitor_team_score != '' && response_data.visitor_team_score != null) {
                                visitor_team_score = response_data.visitor_team_score
                            }

                            // status
                            if(response_data.status != '' && response_data.status != null) {
                                status = response_data.status
                            }

                            // result
                            if(response_data.result != '' && response_data.result != null) {
                                result = response_data.result
                            }

                            body_matches += `
                            <tr>
                                <td>${league_name}</td>
                                <td>${response_data.local_team.name}</td>
                                <td>${response_data.visitor_team.name}</td>
                                <td>${res_fecha_edit}<br>${res_horario_edit}</td>
                                <td class="text-center">
                                    <button class="btn" onclick="matchesModalEdit('${league_sport_id}',${response_data.id},'${league_id}',${response_data.local_team_id},${response_data.visitor_team_id},'${res_fecha_edit}','${res_horario_edit}','${response_data.spread}','${local_team_score}','${visitor_team_score}','${status}','${result}')" data-toggle="modal" data-target="#modal-edit"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="btn" onclick="delMatches(${response_data.id})"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            `
                        })

                        // Pintamos los registros en la tabla
                        $("#tblMatches tbody").html(body_matches);
                        
                        let cantidad = 100

                        // Agregamos el datatable
                        $("#tblMatches").DataTable({
                            dom: 'Bfrtip',
                            "responsive": true, 
                            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                            "lengthChange": false, 
                            "autoWidth": false,
                            "scrollX": false,
                            "stateSave": false,
                            'pageLength': cantidad,
                            "buttons": [
                                'pageLength',
                                { 
                                    extend: 'excel', 
                                    text: 'Excel', 
                                    title: 'Duelazo Matches',
                                    className: 'btn-dark',
                                    exportOptions: {
                                        columns: [0,1,2]
                                    }  
                                },
                                { 
                                    extend: 'pdfHtml5', 
                                    text: 'PDF', 
                                    header: true,
                                    title: 'Duelazo Matches',
                                    duplicate:true,
                                    className: 'btn-dark',
                                    pageOrientation: 'landscape',
                                    pageSize: 'A4',
                                    /*
                                    pageSize: {
                                        width: 215.43,
                                        height: 144.56,
                                    },
                                    */
                                    pageMargins: [ 5, 5, 5, 5 ],
                                    customize: function ( doc ) {
                                        if (doc) {
                                            //console.log("length: ", doc.content[1].table.body.length)
                                            /*
                                            for (var i = 0; i < doc.content[1].table.body.length; i++) {
                                    
                                                var tmptext = doc.content[1].table.body[i][0].text;
                                                //console.log("tmptext: ", tmptext)
                                                tmptext = tmptext.substring(10, tmptext.indexOf("width=") - 2);
                                    
                                                doc.content[1].table.body[i][0] = {
                                                    margin: [0, 0, 0, 18],
                                                    alignment: 'center',
                                                    image: tmptext,
                                                    width: 60,
                                                    height: 58
                                                };
                                                
                                            }
                                            */
                                        }
                                
                                    },
                                    exportOptions: {
                                        columns: [0,1,2],
                                        alignment: 'center',
                                        stripHtml: false
                                    },
                                    pageBreak: 'after',
                                },
                                { 
                                    extend: 'print', 
                                    text: 'Imprimir', 
                                    className: 'btn-dark',
                                    pageSize : 'A4',
                                    orientation: 'landscape',
                                    exportOptions: {
                                        columns: [0,1,2]
                                    } 
                                },
                                { 
                                    extend: 'colvis', 
                                    text: 'Columnas', 
                                    className: 'btn-dark' 
                                },
                                /*
                                { 
                                    extend: 'selectAll', 
                                    text: 'Seleccionar Todo', 
                                    className: 'btn-info' 
                                },
                                { 
                                    extend: 'selectNone', 
                                    text: 'Quitar Seleccion' 
                                },
                                */
                            ],
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
                        }).buttons().container().appendTo('#tblMatches_wrapper .col-md-6:eq(0)');

                    } // try
                    catch(err) {
                        console.log(err.message);
                        $("#loading2").hide();
                    }
        
                },
                error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                $("#loading2").hide();
                }
            })

        }else {
            //console.log('seleccione una fecha para realizar la búsqueda')
            Swal.fire(
                '¡Error!',
                'Seleccione una fecha para realizar la búsqueda.',
                'warning'
            )
        } // else date
    }else {
        //console.log('seleccione un deporte para realizar la búsqueda')
        Swal.fire(
            '¡Error!',
            'Seleccione un deporte para realizar la búsqueda.',
            'warning'
        )
    } // else sport_id


}

/**
 * It takes the values of the form and sends them to the server via ajax.
 */
// saveMatches
const saveMatches = () => {
    //console.log('saveMatches')

    let league_id = $("#league_id").val()
    let local_team = $("#local_team").val()
    let visitor_team = $("#visitor_team").val()
    let start_date = $("#start_date").val()
    let start_time = $("#start_time").val()
    let spread = $("#spread").val()
    let sport_id = $("#sport_id").val()

    if( league_id != '' && local_team != '' && visitor_team != '' && start_date != '' && start_time != '' ){

        /*
        console.log(`
        league_id: ${league_id}
        local_team: ${local_team}
        visitor_team: ${visitor_team}
        start_date: ${start_date}
        start_time: ${start_time}
        spread: ${spread}
        sport_id: ${sport_id}
        `)
        */

        $.ajax({
            url: '/matches/save',
            type: 'POST',
            data: { 
                "league_id" : league_id, 
                "local_team" : local_team, 
                "visitor_team" : visitor_team,
                "start_date" : start_date,
                "start_time" : start_time,
                "spread" : spread,
                "sport_id" : sport_id,
            },
            success: function(response){
                //console.log('success matches save')
                //console.log(JSON.parse(response))

                $("#league_id").val('')
                $("#local_team").val('')
                $("#visitor_team").val('')
                $("#start_date").val('')
                $("#start_time").val('')

                Swal.fire({
                    icon: 'success',
                    title: '¡Creado!',
                    text: 'Tu partido se creo exitosamente',
                })
    
            },
            error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
            }
        })

    }else{
        Swal.fire({
            icon: 'warning',
            title: 'Campos vacios',
            text: 'Por favor, llena los campos marcados con un (*) ',
        })
    }
}

/**
 * It takes 8 parameters, and then it calls another function, passing it 2 parameters.
 * @param sport_id - 1
 * @param match_id - 1
 * @param league_id - 1
 * @param local_id - 1
 * @param visitor_id - 1
 * @param fecha - 2019-01-01
 * @param horario - "2019-01-01 00:00:00"
 * @param spread - 1.5
 */
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

/**
 * It takes the values of the inputs and sends them to the server via ajax.
 */
// editMatches
const editMatches = () => {
    //console.log('editMatches')

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

            listarMatches()
  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })

}

/**
 * It's a function that deletes a record from the database.
 */
// delMatches
const delMatches = id => {
    //console.log('delMatches')

    console.log(`
    match_id: ${id}
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
                url: '/matches/delete',
                type: 'POST',
                data: { 
                    "match_id" : id,
                },
                success: function(response){
                    //console.log('success matches delete')
                    //console.log(JSON.parse(response))

                    Swal.fire(
                        '¡Eliminado!',
                        'Su registro ha sido eliminado.',
                        'success'
                    )

                    listarMatches()
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
        
        }
    })
}