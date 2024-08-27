// Buscar usuario
const searchUser = () => {
    console.log('searchUser')

    let nickname = $("#nickname").val()
    let email = $("#email").val()
    let user_id = $("#user_id").val()
    let type_search = ''
    let search = ''

    if(nickname != ''){
        type_search = 'nickname'
        search = nickname;
    }

    if(email != ''){
        type_search = 'email'
        search = email;
    }

    if(user_id != ''){
        type_search = 'id'
        search = user_id;
    }

    $("#search_type").val(type_search)

    console.log('type_search: ',type_search)
    console.log('search: ',search)

    // Buscamos el registro del usuario
    if(search != ''){
        $.ajax({
            url: '/users/search',
            type: 'POST',
            data: { 
                "type_search" : type_search,
                "search" : search
            },
            beforeSend: function() {
                $("#loading1").show();
                $("#loading-text-1").html('Procesando Ligas, espere un momento....');
            },
            complete: function() {
                $("#loading1").hide();
            },
            success: function(response){
                //console.log('success')
                //console.log(JSON.parse(response))

                data = JSON.parse(response)

                if(data != null){
                    listarUsers(response,type_search)
                }else{

                    $("#loading1").hide();

                    Swal.fire({
                        icon: 'warning',
                        title: 'No se encontro ningún resultado',
                        text: 'Intentalo con otra búsqueda...',
                    })
                }
    
                
      
            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                $("#loading1").hide();
            }
        })
    }else{
        Swal.fire({
            icon: 'warning',
            title: 'Por favor introduce un Nickname, Email o ID del usuario',
            text: 'Es necesario para realizar la búsqueda...',
        })
    }

}

// listar a los usuarios
const listarUsers = (response,type_search) => {
    console.log('listarUsers')
    console.log('type_search: ',type_search)

    // Seleccionamos el div donde colocaremos el contenido de la tabla
    let divTable = $("#divUsers")
    divTable.html("")

    // Creamos la tabla dentro del div
    table = `
    <table id="tblUsers" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol de Usuario</th>
                <th>Nombre</th>
                <th>Apellido(s)</th>
                <th>Nickname</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Fecha de nacimiento</th>
                <th>Diamantes</th>
                <th>Tokens</th>
                <th>Comodines</th>
                <th>Correo confirmado</th>
                <th>Teléfono confirmado</th>
                <th>Usuario verificado</th>
                <th>Balance</th>
                <th>Suscriptor</th>
                <th>Tipo de Suscripción</th>
                <th>Suscriptor desde</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    `
    divTable.append(table)

    let body_users = ''
    data = JSON.parse(response)
    console.log(data)

    if(type_search == 'id'){

        let suscriber_until = ''

        if(data.subscriber_until != null){
            suscriber_until = data.subscriber_until
        }
        console.log('suscriber_until: ', suscriber_until)

        let birthday = ''

        if(data.birthday != null){
            [birthday,timebd] = data.birthday.split('T')
        }

        let confirmed_email = ''

        if(data.confirmed_email == 1){
            confirmed_email = '<i class="fas fa-check"></i>'
        }

        let confirmed_phone = ''

        if(data.confirmed_phone == 1){
            confirmed_phone = '<i class="fas fa-check"></i>'
        }

        let verified = ''

        if(data.verified == 1){
            verified = '<i class="fas fa-check"></i>'
        }

        let is_subscriber = ''

        if(data.is_subscriber == 1){
            is_subscriber = '<i class="fas fa-check"></i>'
        }

        let suscription_type = ''

        switch(data.suscription_type_id){
            case 1:
                suscription_type = 'Campeón'
                break;

            case 2: 
                suscription_type = 'MVP'
                break;

            case 3:
                suscription_type = 'G.O.A.T'
                break;
        }

        let rol_user = ''

        switch(data.role_id){
            case 1:
                rol_user = 'Admin'
                break;

            case 2: 
                rol_user = 'Tester'
                break;

            case 3:
                rol_user = 'Usuario'
                break;
        }


        body_users += `
        <tr id="row_${data.id}">
            <td>${data.id}</td>
            <td class="text-center">${rol_user}</td>
            <td>${data.name}</td>
            <td>${data.last_name}</td>
            <td>${data.nickname}</td>
            <td>${data.email}</td>
            <td>${data.phone}</td>
            <td>${birthday}</td>
            <td>${data.diamonds}</td>
            <td>${data.tokens}</td>
            <td>${data.boosts}</td>
            <td>${confirmed_email}</td>
            <td>${confirmed_phone}</td>
            <td>${verified}</td>
            <td>${data.balance}</td>
            <td>${is_subscriber}</td>
            <td>${suscription_type}</td>
            <td>${suscriber_until}</td>
            <td class="text-center">
                <button class="btn" onclick="modalEdit(${data.id})" title="editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn" onclick="delUser(${data.id})" title="eliminar"><i class="far fa-trash-alt"></i></button>

                <button class="btn" onclick="modalUsersShopping(${data.id})" title="compras"><i class="fas fa-shopping-cart"></i></button>
                <button class="btn" onclick="modalWinnerRecords(${data.id})" title="registros de ganador"><i class="fas fa-trophy"></i></button>
                
            </td>
        </tr>
        `
    }

    if(type_search == 'nickname' || type_search == 'email'){
        data.forEach(response_data=>{
            console.log('response_data email listar')
            console.log(response_data)

            let suscriber_until = ''

            if(response_data.subscriber_until != null){
                suscriber_until = response_data.subscriber_until
            }

            console.log('suscriber_until: ', suscriber_until)

            let birthday = ''

            if(response_data.birthday != null){
                [birthday,timebd] = response_data.birthday.split('T')
            }

            let confirmed_email = ''

            if(response_data.confirmed_email == 1){
                confirmed_email = '<i class="fas fa-check"></i>'
            }

            let confirmed_phone = ''

            if(response_data.confirmed_phone == 1){
                confirmed_phone = '<i class="fas fa-check"></i>'
            }

            let verified = ''

            if(response_data.verified == 1){
                verified = '<i class="fas fa-check"></i>'
            }

            let is_subscriber = ''

            if(response_data.is_subscriber == 1){
                is_subscriber = '<i class="fas fa-check"></i>'
            }

            let suscription_type = ''

            switch(response_data.suscription_type_id){
                case "1":
                    suscription_type = 'Campeón'
                    break;
    
                case "2": 
                    suscription_type = 'MVP'
                    break;
    
                case "3":
                    suscription_type = 'G.O.A.T'
                    break;
            }

            let rol_user = ''

            switch(response_data.role_id){
                case 1:
                    rol_user = 'Admin'
                    break;

                case 2: 
                    rol_user = 'Tester'
                    break;

                case 3:
                    rol_user = 'Usuario'
                    break;
            }

            body_users += `
            <tr id="row_${response_data.id}">
                <td>${response_data.id}</td>
                <td class="text-center">${rol_user}</td>
                <td>${response_data.name}</td>
                <td>${response_data.last_name}</td>
                <td>${response_data.nickname}</td>
                <td>${response_data.email}</td>
                <td>${response_data.phone}</td>
                <td>${birthday}</td>
                <td class="text-center">${response_data.diamonds}</td>
                <td class="text-center">${response_data.tokens}</td>
                <td class="text-center">${response_data.boosts}</td>
                <td class="text-center">${confirmed_email}</td>
                <td class="text-center">${confirmed_phone}</td>
                <td class="text-center">${verified}</td>
                <td class="text-center">${response_data.balance}</td>
                <td class="text-center">${is_subscriber}</td>
                <td class="text-center">${suscription_type}</td>
                <td class="text-center">${suscriber_until}</td>
                <td class="text-center">
                    <button class="btn" onclick="modalEdit(${response_data.id})"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn" onclick="delUser(${response_data.id})"><i class="far fa-trash-alt"></i></button>

                    <button class="btn" onclick="modalUsersShopping(${response_data.id})" title="compras"><i class="fas fa-shopping-cart"></i></button>
                    <button class="btn" onclick="modalWinnerRecords(${response_data.id})" title="registros de ganador"><i class="fas fa-trophy"></i></button>
    
                </td>
            </tr>
            `
        })
    }
    

    // Pintamos los registros en la tabla
    $("#tblUsers tbody").html(body_users);

    let cantidad = 100

    // Agregamos el datatable
    $("#tblUsers").DataTable({
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
                title: 'Duelazo Usuarios',
                className: 'btn-dark',
                exportOptions: {
                    columns: [0,1,2]
                }  
            },
            { 
                extend: 'pdfHtml5', 
                text: 'PDF', 
                header: true,
                title: 'Duelazo Usuarios',
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
    }).buttons().container().appendTo('#tblUsers_wrapper .col-md-6:eq(0)');


}

// Modal para editar la información del usuario
const modalEdit = id => {
    //console.log('modalEdit')
    //console.log('id',id)

    // Limpiamos los inputs del modal antes de mostrar los nuevos datos
    $("#name_edit").val() 
    $("#last_name_edit").val()
    $("#nickname_edit").val()
    $("#email_edit").val()
    $("#phone_edit").val()
    $("#birthday_edit").val()
    $("#diamonds_edit").val() 
    $("#tokens_edit").val()
    $("#boosts_edit").val()
    $("#confirmed_email_edit").val('')
    $("#confirmed_email_edit").prop("checked", false)
    $("#confirmed_phone_edit").val('')
    $("#confirmed_phone_edit").prop("checked", false)
    $("#verified_edit").val('')
    $("#verified_edit").prop("checked", false)
    $("#is_subscriber_edit").val('')
    $("#is_subscriber_edit").prop("checked", false)
    $("#suscription_type_id_edit").prop("selected", false)

    // Limpiamos los inputs old del modal antes de mostrar los nuevos datos
    $("#name_edit_old").val() 
    $("#last_name_edit_old").val() 
    $("#nickname_edit_old").val() 
    $("#email_edit_old").val() 
    $("#phone_edit_old").val() 
    $("#birthday_edit_old").val() 
    $("#diamonds_edit_old").val() 
    $("#tokens_edit_old").val() 
    $("#boosts_edit_old").val() 

    $("#confirmed_email_edit_old").val('')
    $("#confirmed_email_edit_old").prop("checked", false)
    $("#confirmed_email_edit_source").val('')
    $("#confirmed_email_edit_source").prop("checked", false)

    $("#confirmed_phone_edit_old").val('')
    $("#confirmed_phone_edit_old").prop("checked", false)
    $("#confirmed_phone_edit_source").val('')
    $("#confirmed_phone_edit_source").prop("checked", false)

    $("#verified_edit_old").val('')
    $("#verified_edit_old").prop("checked", false)
    $("#verified_edit_source").val('') 
    $("#verified_edit_source").prop("checked", false)

    $("#is_subscriber_edit_old").val('')
    $("#is_subscriber_edit_old").prop("checked", false)
    $("#is_subscriber_edit_source").val('')
    $("#is_subscriber_edit_source").prop("checked", false)

    $("#suscription_type_id_edit_old").val('') 


    let x = 1

    $("#row_"+id+" td").each(function(){
        //console.log($(this).text())

        if(x==1){ $("#user_id_edit").val($(this).text()) }

        if(x==2){ 
            let rol_user = $(this).text()
            let rol_id = ''
            let options = ''
            let check_1 = ''
            let check_2 = ''
            let check_3 = ''

            switch(rol_user){
                case 'Admin':
                    rol_id = 1
                    check_1 = 'selected'
                    break;

                case 'Tester':
                    rol_id = 2
                    check_2 = 'selected'
                    break;

                case 'Usuario':
                    rol_id = 3
                    check_3 = 'selected'
                    break;
            }
            
            options = `
                <option value="1" ${check_1}>Admin</option>
                <option value="2" ${check_2}>Tester</option>
                <option value="3" ${check_3}>Usuario</option>
            `
            $("#rol_user_edit").html(options) 
            $("#rol_user_edit_old").val(rol_id) 

        }

        if(x==3){ 
            $("#name_edit").val($(this).text()) 
            $("#name_edit_old").val($(this).text()) 
        }
        if(x==4){ 
            $("#last_name_edit").val($(this).text())
            $("#last_name_edit_old").val($(this).text()) 
        }
        if(x==5){ 
            $("#nickname_edit").val($(this).text())
            $("#nickname_edit_old").val($(this).text()) 
        }
        if(x==6){ 
            $("#email_edit").val($(this).text())
            $("#email_edit_old").val($(this).text()) 
        }
        if(x==7){ 
            $("#phone_edit").val($(this).text())
            $("#phone_edit_old").val($(this).text()) 
        }
        if(x==8){ 
            $("#birthday_edit").val($(this).text())
            $("#birthday_edit_old").val($(this).text()) 
        }

        if(x==9){ 
            $("#diamonds_edit").val($(this).text()) 
            $("#diamonds_edit_old").val($(this).text()) 
        }
        if(x==10){ 
            $("#tokens_edit").val($(this).text())
            $("#tokens_edit_old").val($(this).text()) 
        }
        if(x==11){ 
            $("#boosts_edit").val($(this).text())
            $("#boosts_edit_old").val($(this).text()) 
        }

        if(x==12){ 
            //console.log('12')
            //console.log('<i class="fas fa-check"></i>')
            //console.log($(this).html())
            $("#confirmed_email_edit").val('0')
            $("#confirmed_email_edit_old").val('0')
            $("#confirmed_email_edit_source").val('0')
            if($(this).html() == '<i class="fas fa-check"></i>'){
                //console.log('entro al check')
                $("#confirmed_email_edit").prop("checked", true)
                $("#confirmed_email_edit").val('1')
                $("#confirmed_email_edit_old").val('1')
                $("#confirmed_email_edit_source").val('1')
            }
        }

        if(x==13){ 
            $("#confirmed_phone_edit").val('0')
            $("#confirmed_phone_edit_old").val('0')
            $("#confirmed_phone_edit_source").val('0')
            if($(this).html() == '<i class="fas fa-check"></i>'){
                $("#confirmed_phone_edit").prop("checked", true)
                $("#confirmed_phone_edit").val('1')
                $("#confirmed_phone_edit_old").val('1')
                $("#confirmed_phone_edit_source").val('1')
            }
        }

        if(x==14){
            $("#verified_edit").val('0')
            $("#verified_edit_old").val('0')
            $("#verified_edit_source").val('0') 
            if($(this).html() == '<i class="fas fa-check"></i>'){
                $("#verified_edit").prop("checked", true)
                $("#verified_edit").val('1')
                $("#verified_edit_old").val('1')
                $("#verified_edit_source").val('1')
            }
        }

        if(x==15){ 
            $("#balance_edit").val($(this).text()) 
            $("#balance_edit_old").val($(this).text()) 
        }

        if(x==16){ 
            $("#is_subscriber_edit").val('0')
            $("#is_subscriber_edit_old").val('0')
            $("#is_subscriber_edit_source").val('0')
            if($(this).html() == '<i class="fas fa-check"></i>'){
                $("#is_subscriber_edit").prop("checked", true)
                $("#is_subscriber_edit").val('1')
                $("#is_subscriber_edit_old").val('1')
                $("#is_subscriber_edit_source").val('1')
            }
        }

        if(x==17){ 
            let suscription_type = $(this).text()
            let suscription_type_id = ''
            let options = ''
            let check_1 = ''
            let check_2 = ''
            let check_3 = ''

            switch(suscription_type){
                case 'Campeón':
                    suscription_type_id = 1
                    check_1 = 'selected'
                    break;

                case 'MVP':
                    suscription_type_id = 2
                    check_2 = 'selected'
                    break;

                case 'G.O.A.T':
                    suscription_type_id = 3
                    check_3 = 'selected'
                    break;
            }
            
            options = `
                <option value="1" ${check_1}>Campeón</option>
                <option value="2" ${check_2}>MVP</option>
                <option value="3" ${check_3}>G.O.A.T</option>
            `
            $("#suscription_type_id_edit").html(options) 
            $("#suscription_type_id_edit_old").val(suscription_type_id) 

        }

        if(x==18){ 
            if($(this).text() != ''){
                //let [fecha_suscriber,horario_suscriber] = $(this).text().split('T')
                //$("#suscriber_until_edit").val(fecha_suscriber) 
                //$("#suscriber_until_edit_old").val(fecha_suscriber) 

                $("#suscriber_until_edit").val($(this).text()) 
                $("#suscriber_until_edit_old").val($(this).text()) 
            }
            
        }

        x++;    
    });

    $('#modal-edit').modal('show');
}

// Modificamos el valor del Correo Confirmado
$("#confirmed_email_edit").change(function() {
    let confirmed_email = $("#confirmed_email_edit").val()

    if(confirmed_email == '0'){
        $("#confirmed_email_edit").prop("checked", true)
        $("#confirmed_email_edit").val('1')
    }

    if(confirmed_email == '1'){
        $("#confirmed_email_edit").prop("checked", false)
        $("#confirmed_email_edit").val('0')
    }
});
// Modificamos el valor del Teléfono Confirmado
$("#confirmed_phone_edit").change(function() {
    let confirmed_phone = $("#confirmed_phone_edit").val()

    if(confirmed_phone == '0'){
        $("#confirmed_phone_edit").prop("checked", true)
        $("#confirmed_phone_edit").val('1')
    }

    if(confirmed_phone == '1'){
        $("#confirmed_phone_edit").prop("checked", false)
        $("#confirmed_phone_edit").val('0')
    }
});
// Modificamos el valor del Usuario Verificado
$("#verified_edit").change(function() {
    let verified = $("#verified_edit").val()

    if(verified == '0'){
        $("#verified_edit").prop("checked", true)
        $("#verified_edit").val('1')
    }

    if(verified == '1'){
        $("#verified_edit").prop("checked", false)
        $("#verified_edit").val('0')
    }
});
// Modificamos el valor de Suscriptor VIP
$("#is_subscriber_edit").change(function() {
    let is_subscriber = $("#is_subscriber_edit").val()

    if(is_subscriber == '0'){
        $("#is_subscriber_edit").prop("checked", true)
        $("#is_subscriber_edit").val('1')
    }

    if(is_subscriber == '1'){
        $("#is_subscriber_edit").prop("checked", false)
        $("#is_subscriber_edit").val('0')
    }
});

// Guardar cambios del usuario
const update = () => {
    console.log('update')

    // Inputs
    var user_id_edit =  $("#user_id_edit").val()

    var rol_user_edit =  $("#rol_user_edit").val()
    var name_edit =  $("#name_edit").val()
    var last_name_edit =  $("#last_name_edit").val()
    var nickname_edit =  $("#nickname_edit").val()
    var email_edit =  $("#email_edit").val()
    var phone_edit =  $("#phone_edit").val()
    var birthday_edit =  $("#birthday_edit").val()
    var diamonds_edit =  $("#diamonds_edit").val()
    var tokens_edit =  $("#tokens_edit").val()
    var boosts_edit =  $("#boosts_edit").val()
    var balance_edit =  $("#balance_edit").val()
    var suscription_type_id_edit =  $("#suscription_type_id_edit").val()
    var suscriber_until_edit = $("#suscriber_until_edit").val()

    var confirmed_email_edit =  0
    if( $('#confirmed_email_edit').prop('checked') ) {
        confirmed_email_edit =  1
    }
    var confirmed_phone_edit =  0
    if( $('#confirmed_phone_edit').prop('checked') ) {
        confirmed_phone_edit =  1
    }
    var verified_edit =  0
    if( $('#verified_edit').prop('checked') ) {
        verified_edit =  1
    }
    var is_subscriber_edit =  0
    if( $('#is_subscriber_edit').prop('checked') ) {
        is_subscriber_edit =  1
    }

    // Inputs Old
    var rol_user_edit_old =  $("#rol_user_edit_old").val()
    var name_edit_old =  $("#name_edit_old").val()
    var last_name_edit_old =  $("#last_name_edit_old").val()
    var nickname_edit_old =  $("#nickname_edit_old").val()
    var email_edit_old =  $("#email_edit_old").val()
    var phone_edit_old =  $("#phone_edit_old").val()
    var birthday_edit_old =  $("#birthday_edit_old").val()
    var diamonds_edit_old =  $("#diamonds_edit_old").val()
    var tokens_edit_old =  $("#tokens_edit_old").val()
    var boosts_edit_old =  $("#boosts_edit_old").val()
    var confirmed_email_edit_old =  $("#confirmed_email_edit_old").val()
    var confirmed_email_edit_source =  $("#confirmed_email_edit_source").val()
    var confirmed_phone_edit_old =  $("#confirmed_phone_edit_old").val()
    var confirmed_phone_edit_source =  $("#confirmed_phone_edit_source").val()
    var verified_edit_old =  $("#verified_edit_old").val()
    var verified_edit_source =  $("#verified_edit_source").val()
    var is_subscriber_edit_old =  $("#is_subscriber_edit_old").val()
    var is_subscriber_edit_source =  $("#is_subscriber_edit_source").val()
    var balance_edit_old =  $("#balance_edit_old").val()
    var suscription_type_id_edit_old =  $("#suscription_type_id_edit_old").val()
    var suscriber_until_edit_old = $("#suscriber_until_edit_old").val()

    $.ajax({
        url: '/users/update',
        type: 'POST',
        data: { 
            "user_id_edit" : user_id_edit,
            "rol_user_edit" : rol_user_edit,
            "name_edit" : name_edit,
            "last_name_edit" : last_name_edit,
            "nickname_edit" : nickname_edit,
            "email_edit" : email_edit,
            "phone_edit" : phone_edit,
            "birthday_edit" : birthday_edit,
            "diamonds_edit" : diamonds_edit,
            "tokens_edit" : tokens_edit,
            "boosts_edit" : boosts_edit,
            "confirmed_email_edit" : confirmed_email_edit,
            "confirmed_phone_edit" : confirmed_phone_edit,
            "verified_edit" : verified_edit,
            "is_subscriber_edit" : is_subscriber_edit,
            "balance_edit" : balance_edit,
            "suscription_type_id_edit" : suscription_type_id_edit,
            "suscriber_until_edit" : suscriber_until_edit_old,
            "rol_user_edit_old" : rol_user_edit_old,
            "name_edit_old" : name_edit_old,
            "last_name_edit_old" : last_name_edit_old,
            "nickname_edit_old" : nickname_edit_old,
            "email_edit_old" : email_edit_old,
            "phone_edit_old" : phone_edit_old,
            "birthday_edit_old" : birthday_edit_old,
            "diamonds_edit_old" : diamonds_edit_old,
            "tokens_edit_old" : tokens_edit_old,
            "boosts_edit_old" : boosts_edit_old,
            "confirmed_email_edit_old" : confirmed_email_edit_old,
            "confirmed_email_edit_source" : confirmed_email_edit_source,
            "confirmed_phone_edit_old" : confirmed_phone_edit_old,
            "confirmed_phone_edit_source" : confirmed_phone_edit_source,
            "verified_edit_old" : verified_edit_old,
            "verified_edit_source" : verified_edit_source,
            "is_subscriber_edit_old" : is_subscriber_edit_old,
            "is_subscriber_edit_source" : is_subscriber_edit_source,
            "balance_edit_old" : balance_edit_old,
            "suscription_type_id_edit_old" : suscription_type_id_edit_old,
            "suscriber_until_edit_old" : suscriber_until_edit_old
        },
        success: function(response){
            console.log('success update user')
            console.log(JSON.parse(response))

            let type_search = 'email'
            listarUsers(response,type_search)

            $('#modal-edit').modal('hide');
  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })

    //$("#frmUserEdit").submit()
}

// Eliminar usuario
const delUser = id => {
    console.log('delUser')

    let nickname = $("#nickname").val()
    let email = $("#email").val()
    let user_id = $("#user_id").val()

    console.log(`
    user_id: ${id}
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
                url: '/users/delete',
                type: 'POST',
                data: { 
                    "user_id" : id,
                },
                success: function(response){
                    //console.log('success matches delete')
                    //console.log(JSON.parse(response))

                    $("#nickname").val(nickname)
                    $("#email").val(email)
                    $("#user_id").val(user_id)
                    let type_search = ''
                    let search = ''

                    if(nickname != ''){
                        type_search = 'nickname'
                        search = nickname;
                    }
                
                    if(email != ''){
                        type_search = 'email'
                        search = email;
                    }
                
                    if(user_id != ''){
                        type_search = 'id'
                        search = user_id;
                    }
                
                    $("#search_type").val(type_search)

                    searchUser()
        

                    Swal.fire(
                        '¡Eliminado!',
                        'Su registro ha sido eliminado.',
                        'success'
                    )
          
                },
                error: function (obj, error, objError){
                   var error = objError
                   console.log('Error al obtener el resultado. '+ error)
                }
            })
            
        }
    })
}

// Modal para Verificación de Usuarios
const modalVerify = (user_id,nombre,nickname,curp,bank,deposit_number,file_ine,file_domicilio,c_domicilio,c_ine,c_clabe,c_curp,status_id_curp,status_id_ine,status_id_estado_de_cuenta,status_id_comprobante_de_domicilio) => {
    console.log('modalVerify')

    console.log(`
        user_id: ${user_id}
        nombre: ${nombre}
        nickname: ${nickname}
        curp: ${curp}
        bank: ${bank}
        deposit_number: ${deposit_number}
        file_ine: ${file_ine}
        file_domicilio: ${file_domicilio}
        status_id_curp: ${status_id_curp}
        status_id_ine: ${status_id_ine}
        status_id_estado_de_cuenta: ${status_id_estado_de_cuenta}
        status_id_comprobante_de_domicilio: ${status_id_comprobante_de_domicilio}
    `)

    // Limpiamos los inputs
    $("#userID").html('')

    $("#user_id").val('')
    $("#nombre").val('')
    $("#nickname").val('')
    $("#curp").val('')
    $("#banco").val('')
    $("#cuenta").val('')

    $("#file_ine").val('')
    $("#file_domicilio").val('')

    $("#circle_comprobante").attr('class','')
    $("#circle_identificacion").attr('class','')
    $("#circle_curp").attr('class','')
    $("#circle_banco").attr('class','')

    // Colocamos los valores en los inputs
    $("#userID").html(user_id)

    $("#user_id").val(user_id)
    $("#nombre").val(nombre)
    $("#nickname").val(nickname)
    $("#curp").val(curp)
    $("#banco").val(bank)
    $("#cuenta").val(deposit_number)

    $("#file_ine").val(file_ine)
    $("#file_domicilio").val(file_domicilio)

    $("#circle_comprobante").attr('class','fas fa-circle ' + c_domicilio)
    $("#circle_identificacion").attr('class','fas fa-circle ' + c_ine)
    $("#circle_curp").attr('class','fas fa-circle ' + c_curp)
    $("#circle_banco").attr('class','fas fa-circle ' + c_clabe)

    $("#status_id_comprobante_de_domicilio").val(status_id_comprobante_de_domicilio)
    $("#status_id_comprobante_de_domicilio_old").val(status_id_comprobante_de_domicilio)

    $("#status_id_ine").val(status_id_ine)
    $("#status_id_ine_old").val(status_id_ine)

    $("#status_id_curp").val(status_id_curp)
    $("#status_id_curp_old").val(status_id_curp)

    $("#status_id_estado_de_cuenta").val(status_id_estado_de_cuenta)
    $("#status_id_estado_de_cuenta_old").val(status_id_estado_de_cuenta)
    
    $('#modal-verify').modal('show');
}

// Mostramos la Identificación Oficial
const showIdentification = () => {
    console.log('showIdentification')

    let file_ine = $("#file_ine").val()
    
    $("#card-title-file").html('')
    $("#file-image").removeAttr('src')

    if(file_ine != '' && file_ine > 0){
        $.ajax({
            url: '/brackets/file/'+file_ine,
            type: 'GET',
            
            beforeSend: function() {
                $("#loading1").show();
                $("#loading-text-1").html('Procesando Ligas, espere un momento....');
            },
            complete: function() {
                $("#loading1").hide();
            },
            
            success: function(response){
                console.log('success file')
                //console.log(JSON.parse(response))
                
                data = JSON.parse(response)

                if(data != null){

                    $("#card-title-file").html('Identificación')
                    $("#file-image").attr('src',data)

                    $('#modal-file').modal('show');

                }else{

                    $("#loading1").hide();

                    Swal.fire({
                        icon: 'warning',
                        title: 'No se encontro ningún resultado',
                        text: 'Intentalo con otra búsqueda...',
                    })
                }
                
                
      
            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                $("#loading1").hide();
            }
        })
    }else{
        console.log('no se tiene una imagen por parte del usuario')
    }
}

// Mostramos el Comprobante de Domicilio
const showDomicilio = () => {
    console.log('showDomicilio')

    let file_domicilio = $("#file_domicilio").val()
    
    $("#card-title-file").html('')
    $("#file-image").removeAttr('src')

    if(file_domicilio != '' && file_domicilio > 0){
        $.ajax({
            url: '/brackets/file/'+file_domicilio,
            type: 'GET',
            
            beforeSend: function() {
                $("#loading1").show();
                $("#loading-text-1").html('Procesando Ligas, espere un momento....');
            },
            complete: function() {
                $("#loading1").hide();
            },
            
            success: function(response){
                console.log('success file')
                //console.log(JSON.parse(response))
                
                data = JSON.parse(response)

                if(data != null){

                    $("#card-title-file").html('Comprobante de Domicilio')
                    $("#file-image").attr('src',data)

                    $('#modal-file').modal('show');

                }else{

                    $("#loading1").hide();

                    Swal.fire({
                        icon: 'warning',
                        title: 'No se encontro ningún resultado',
                        text: 'Intentalo con otra búsqueda...',
                    })
                }
                
                
      
            },
            error: function (obj, error, objError){
                var error = objError
                console.log('Error al obtener el resultado. '+ error)
                $("#loading1").hide();
            }
        })
    }else{
        console.log('no se tiene una imagen por parte del usuario')
    }
}

// Cambiamos el status del Comprobante de Domicilio
const statusDomicilio = id => {
    console.log('statusDomicilio')
    console.log('id: ',id)

    $("#circle_comprobante").attr('class','')
    let c_comprobante = ''

    // Aceptado
    if(id == 7){
        c_comprobante = 'c-green'
    }
    // Rechazado
    if(id == 8){
        c_comprobante = 'c-red'
    }

    $("#circle_comprobante").attr('class','fas fa-circle ' + c_comprobante)
    $("#status_id_comprobante_de_domicilio").val(id)
}

// Cambiamos el status de la Identificación
const statusIdentificacion = id => {
    console.log('statusIdentificacion')
    console.log('id: ',id)

    $("#circle_identificacion").attr('class','')
    let c_identificacion = ''

    // Aceptado
    if(id == 7){
        c_identificacion = 'c-green'
    }
    // Rechazado
    if(id == 8){
        c_identificacion = 'c-red'
    }

    $("#circle_identificacion").attr('class','fas fa-circle ' + c_identificacion)
    $("#status_id_ine").val(id)
}

// Cambiamos el status del CURP
const statusCURP = id => {
    console.log('statusCURP')
    console.log('id: ',id)

    $("#circle_curp").attr('class','')
    let c_curp = ''

    // Aceptado
    if(id == 7){
        c_curp = 'c-green'
    }
    // Rechazado
    if(id == 8){
        c_curp = 'c-red'
    }

    $("#circle_curp").attr('class','fas fa-circle ' + c_curp)
    $("#status_id_curp").val(id)
}

// Cambiamos el status del Comprobante de Estado de Cuenta
const statusCuenta = id => {
    console.log('statusCuenta')
    console.log('id: ',id)

    $("#circle_banco").attr('class','')
    let c_banco = ''

    // Aceptado
    if(id == 7){
        c_banco = 'c-green'
    }
    // Rechazado
    if(id == 8){
        c_banco = 'c-red'
    }

    $("#circle_banco").attr('class','fas fa-circle ' + c_banco)
    $("#status_id_estado_de_cuenta").val(id)
}

// Guardamos los cambios de la Verificación de Usuarios
const saveVerify = () => {
    console.log('saveVerify')

    let cambios = 0
    let user_id = $("#user_id").val()

    // Verificamos si cambio el comprobante de domicilio
    let comprobante_domicilio = $("#status_id_comprobante_de_domicilio").val()
    let comprobante_domicilio_old = $("#status_id_comprobante_de_domicilio_old").val()

    if(comprobante_domicilio != comprobante_domicilio_old){
        cambios = 1
    }

    // Verificamos si cambio la identificación
    let identificacion = $("#status_id_ine").val()
    let identificacion_old = $("#status_id_ine_old").val()

    if(identificacion != identificacion_old){
        cambios = 1
    }

    // Verificamos si cambio el curp
    let curp = $("#status_id_curp").val()
    let curp_old = $("#status_id_curp_old").val()

    if(curp != curp_old){
        cambios = 1
    }

    // Verificamos si cambio el estado de cuenta
    let cuenta = $("#status_id_estado_de_cuenta").val()
    let cuenta_old = $("#status_id_estado_de_cuenta_old").val()

    if(cuenta != cuenta_old){
        cambios = 1
    }

    // 
    let comentarios = $("#comentarios").val()
    let comentarios_old = $("#comentarios_old").val()

    // Verificamos si existe algun cambio y lo guardamos
    if(cambios == 1){
        $.ajax({
            url: '/users/save_verify',
            type: 'POST',
            data: { 
                "user_id" : user_id,
                "comprobante_domicilio" : comprobante_domicilio,
                "comprobante_domicilio_old" : comprobante_domicilio_old,
                "identificacion" : identificacion,
                "identificacion_old" : identificacion_old,
                "curp" : curp,
                "curp_old" : curp_old,
                "cuenta" : cuenta,
                "cuenta_old" : cuenta_old,
                "comentarios" : comentarios,
                "comentarios_old" : comentarios_old
            },
            success: function(response){
                console.log('success verificación')
                console.log(JSON.parse(response))
    
                $("#row_"+user_id).remove()
    
                $('#modal-verify').modal('hide');
    
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'Se actualizó el estatus del usuario...',
                })
      
            },
            error: function (obj, error, objError){
               var error = objError
               console.log('Error al obtener el resultado. '+ error)
            }
        })
    }else{
        console.log('No existe ningun cambio en la verificación')
    }

}

const modalUsersShopping = user_id => {
    console.log('modalUsersShopping')

    $.ajax({
        url: '/users/store_transactions',
        type: 'POST',
        data: { 
            "user_id" : user_id
        },
        success: function(response){
            console.log('success verificación')
            console.log(JSON.parse(response))    

            data = JSON.parse(response)

            let body_compras = ''

            data.forEach(response_data=>{

                let pagado_con = ''
                let img_pagado_con = ''

                switch(response_data.product.coin_id_bought_with){
                    case 1:
                        pagado_con = 'token'
                        img_pagado_con = '<img src="/images/icons/token.png"> '
                        break;
    
                    case 2:
                        pagado_con = 'diamond'
                        img_pagado_con = '<img src="/images/icons/diamond.png"> '
                        break;
    
                    case 3:
                        pagado_con = 'mxn'
                        break;
                }

                body_compras += `
                <tr>
                    <td>${response_data.product.name}</td>
                    <td>${response_data.product.description}</td>
                    <td>${img_pagado_con} ${pagado_con}</td>
                    <td>$ ${number_format(response_data.product.price,2)}</td>
                    <td>${response_data.created_at}</td>
                </tr>
                `    
            })


            $("#tblCompras tbody").html(body_compras)

  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })

    $("#modal-compras").modal('show')
    $("#modal-compras").addClass('scroll-vertical')
}

const modalWinnerRecords = user_id => {
    console.log('modalWinnerRecords')

    $.ajax({
        url: '/users/winners_records',
        type: 'POST',
        data: { 
            "user_id" : user_id
        },
        success: function(response){
            console.log('success verificación')
            console.log(JSON.parse(response))    

            data = JSON.parse(response)

            let body_winner = ''

            data.forEach(response_data=>{

                let game = ''
                let title = ''

                // Pools
                if(response_data.pool != null){
                    game = 'quinielas'
                    title = response_data.pool.title
                }

                // Streaks
                if(response_data.streak_tournament != null){
                    game = 'rachas'
                    title = response_data.streak_tournament.title
                }


                body_winner += `
                <tr>
                    <td>${game}</td>
                    <td>${title}</td>
                    <td>$ ${number_format(response_data.price,2)}</td>
                    <td>${response_data.created_at}</td>
                </tr>
                `    
            })


            $("#tblRegistroGanadores tbody").html(body_winner)

  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })

    $("#modal-registros-ganador").modal('show')
    $("#modal-registros-ganador").addClass('scroll-vertical')
}

function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}