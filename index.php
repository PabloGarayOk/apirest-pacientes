<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API - Pacientes</title>
    <link rel="stylesheet" href="assets/estilos.css" type="text/css">
</head>
<body>
    <div class="container">
        <h1>Api de Pacientes</h1>
        <div class="divbody">
            <h3>Auth - login</h3>
            <code>
                <h4>POST  /auth</h4>
                {
                    <br>
                    &nbsp;&nbsp;"user": "", -> REQUERIDO
                    <br>
                    &nbsp;&nbsp;"pass": "" &nbsp;-> REQUERIDO
                    <br>
                }
                <br><br><br>
                <h5>Test:</h5>
                {
                    <br>
                    &nbsp;&nbsp;"user": "hola@pablogaray.com.ar",
                    <br>
                    &nbsp;&nbsp;"pass": "123456"
                    <br>
                }
            </code>
        </div>      
        <div class="divbody">   
            <h3>Pacientes - methods</h3>
            <code>
                <h4>GET  /pacientes</h4>
                &nbsp;&nbsp;/pacientes.php?page=$numeroPagina
                <br>
                &nbsp;&nbsp;/pacientes.php?id=$pacienteId
            </code>
            <code>
                <h4>POST  /pacientes</h4>
                {
                    <br>
                    &nbsp;&nbsp;"dni": "", &nbsp;&nbsp;&nbsp;-> REQUERIDO
                    <br> 
                    &nbsp;&nbsp;"nombre": "", -> REQUERIDO
                    <br> 
                    &nbsp;&nbsp;"apellido": "",
                    <br>  
                    &nbsp;&nbsp;"genero": "",
                    <br>        
                    &nbsp;&nbsp;"fechaNacimiento": "",
                    <br>
                    &nbsp;&nbsp;"direccion": "",
                    <br>
                    &nbsp;&nbsp;"tel": "",
                    <br> 
                    &nbsp;&nbsp;"email": "", &nbsp;-> REQUERIDO
                    <br>         
                    &nbsp;&nbsp;"token": "" &nbsp;&nbsp;-> REQUERIDO
                    <br>       
                }
            </code>
            <code>            
                <h4>PUT  /pacientes</h4>
                {
                    <br>
                    &nbsp;&nbsp;"pacienteId": "", -> REQUERIDO
                    <br>
                    &nbsp;&nbsp;"dni": "",
                    <br> 
                    &nbsp;&nbsp;"nombre": "",
                    <br> 
                    &nbsp;&nbsp;"apellido": "",
                    <br>  
                    &nbsp;&nbsp;"genero": "",
                    <br>        
                    &nbsp;&nbsp;"fechaNacimiento": "",
                    <br>
                    &nbsp;&nbsp;"direccion": "",
                    <br>
                    &nbsp;&nbsp;"tel": "",
                    <br> 
                    &nbsp;&nbsp;"email": "",
                    <br>         
                    &nbsp;&nbsp;"token": "" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> REQUERIDO
                    <br>       
                }
            </code>
            <code>
                <h4>DELETE  /pacientes (body)</h4>
                {   
                    <br>    
                    &nbsp;&nbsp;"pacienteId": "", -> REQUERIDO
                    <br>       
                    &nbsp;&nbsp;"token": "" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> REQUERIDO
                    <br>
                }
            </code>
            <code>
                <h4>DELETE  /pacientes (headers)</h4>
                {   
                    <br>    
                    &nbsp;&nbsp;"Paciente-Id": "", -> REQUERIDO
                    <br>       
                    &nbsp;&nbsp;"Token": "" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-> REQUERIDO
                    <br>
                }
            </code>
        </div>
    </div>
    
</body>
</html>