/* Checking if the user is leaving the page, and if so, it is sending a request to the server to log
the user out. */
/*
$(document).ready(function(){  

    var validNavigation = false

    // Attach the event keypress to exclude the F5 refresh (includes normal refresh)
    $(document).bind('keypress', function(e) {
        if (e.keyCode == 116){
            validNavigation = true
        }
    })

    // Attach the event click for all links in the page
    $("a").bind("click", function() {
        validNavigation = true
    });

    // Attach the event submit for all forms in the page
    $("form").bind("submit", function() {
        validNavigation = true
    })

    // Attach the event click for all inputs in the page
    $("input[type=submit]").bind("click", function() {
        validNavigation = true
    })

    $(document).keydown(function(e) {
        if (e.keyCode == 65 && e.ctrlKey) {
            validNavigation = true
        }
    })

    $(document).keydown(function(e) {
        if (e.keyCode == 65+17 && e.ctrlKey) {
            validNavigation = true
        }
    })

    $(document).keydown(function (e) {        
        
        if (e.key=="F5") {
            validNavigation = true
        }
        else if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") {
            validNavigation = true
        }
        else if (e.key.toUpperCase() == "R" && prevKey == "CONTROL") {
            validNavigation = true
        }
        else if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
            window.onbeforeunload = ConfirmLeave
        }
    })
                    
    window.onbeforeunload = function() {                
        if (!validNavigation) {
            $.ajax({
                type: 'get',
                url: '/logout',
            })
        }
    }
})
*/

/**
 * It takes the values of the input fields, sends them to the server, and if the server responds with a
 * status of 0, it displays an error message. Otherwise, it redirects the user to the /matches page.
 */
// Login
const login = () => {
    //console.log('login')
 
    let user = $("#usuario").val()
    let pass = $("#password").val()
 
    //console.log(`user: ${user}, pass: ${pass}`)
 
    $.ajax({
        url: '/login',
        type: 'POST',
        data: { "usuario" : user, "clave" : pass },
        success: function(response){
            //console.log('success login')
            //console.log(JSON.parse(response))

            respuesta = JSON.parse(response)

            if(respuesta.status == 0){
                //console.log("error")
                error_message = ` ** Las credenciales son incorrectas <br> ${respuesta.message} `
                $("#error_login").html(error_message)

                setTimeout(function(){ 
                $("#error_login").html('');
            }, 5000);

            }else{
                //console.log("success process")
                window.self.location='/matches';
            }


        },
        error: function (obj, error, objError){
            var error = objError
            console.log('Error al obtener el resultado. '+ error)
        }
    })
}
