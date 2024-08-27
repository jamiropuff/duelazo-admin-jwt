$(document).ready(function(){
    /*
    let cantidad = 100

    // Agregamos el datatable
    $("#tblBalance").DataTable({
        "responsive": true, 
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
        "lengthChange": false, 
        "autoWidth": false,
        "scrollX": false,
        "stateSave": false,
        'pageLength': cantidad,
        "buttons": [
            'pageLength',            
        ],
        // ocultar columnas
        "columnDefs": [
            {
                "targets": [ 4 ],
                "orderable": false,
                "searchable": false,
                //"visible": false,
            }
        ],
        "select": true,
    }).buttons().container().appendTo('#tblBalance_wrapper .col-md-6:eq(0)');
    */
})

// Mostramos el bañance pendiente
const balancePendiente = () => {
    console.log('balancePendiente')
}

// Mostramos el bañance depositado
const balanceDepositado = () => {
    console.log('balanceDepositado')
}

// Mostramos el bañance Rechazado
const balanceRechazado = () => {
    console.log('balanceRechazado')
}

// Abrimos el modal con la información del balance seleccionado
const modalBalance = (balance_id,user_id,status_id,nombre,banco,cuenta_deposito,cantidad,cuenta_verificada) => {
    console.log('modalBalance')

    console.log(`
        balance_id: ${balance_id}
        user_id: ${user_id}
        status_id: ${status_id}
        nombre: ${nombre}
        banco: ${banco}
        cuenta_deposito: ${cuenta_deposito}
        cantidad: ${cantidad}
        cuenta_verificada: ${cuenta_verificada}
    `)

    // Limpiamos el modal
    $("#nombre").val('')
    $("#banco").val('')
    $("#clabe").val('')
    $("#cantidad").val('')
    $("#cuenta_verificada").val('')
    $("#estado_transferencia option[value=10]").attr("selected",true)

    // Agregamos los datos del balance al modal
    $("#balance_id").val(balance_id)
    $("#nombre").val(nombre)
    $("#banco").val(banco)
    $("#clabe").val(cuenta_deposito)
    $("#cantidad").val(cantidad)
    $("#cuenta_verificada").val(cuenta_verificada)
    $("#estado_transferencia option[value="+status_id+"]").attr("selected",true)
    
    // Abrimos el modal
    $('#modal-balance').modal('show');

}

// Guardamos la selección del balance
const save = () => {
    console.log('save')

    let balance_id = $('#balance_id').val()
    let status_id = $('#estado_transferencia').val()
    let comments = $('#comentarios').val()

    console.log(`
        balance_id: ${balance_id}
        status_id: ${status_id}
        comments: ${comments}
    `)

    let status = ''

    if(status_id == '10'){
        status = 'En progeso'
    }
    if(status_id == '11'){
        status = 'Depositado'
        $("#row_"+balance_id).remove()
    }
    if(status_id == '12'){
        status = 'Rechazado'
    }

    $.ajax({
        url: '/balance/withdrawals',
        type: 'POST',
        data: { 
            "balance_id" : balance_id,
            "status_id" : status_id,
            "comments" : comments
        },
        success: function(response){
            console.log('success withdrawals')
            console.log(JSON.parse(response))

            console.log(`
            balance_id: ${balance_id}
            status_id: ${status_id}
            comments: ${comments}
        `)

            if(status_id == '11' || status_id == '12'){
                $("#row_"+balance_id).remove()
            }

            $('#modal-balance').modal('hide');

            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Se actualizo el estatus a '+status+'...',
            })
  
        },
        error: function (obj, error, objError){
           var error = objError
           console.log('Error al obtener el resultado. '+ error)
        }
    })
    

}