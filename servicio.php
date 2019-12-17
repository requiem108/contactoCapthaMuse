<?php
header('Access-Control-Allow-Origin: *');

if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
}if(!$captcha){
          echo '<h5>Por favor confirme el captcha.</h5>';
          exit;
}else{
    $respuesta= ValidarGoogle();   
    
    if($respuesta=='1'){
        Mandarmail($_POST['nombreContacto'],$_POST['emailContacto'],$_POST['mensaje']);
        
    }else{
        echo '<h5>Error al validar el captcha, intentelo de nuevo</h5>';
    }
}

?>




<?php

function ValidarGoogle(){
    $secret = '6Lc8hccUAAAAAMWXSGSyC9OAKOGHBFCBqtgDvixv';
    $respuesta = $_POST['g-recaptcha-response'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    
    $resultado = file_get_contents($url."?secret=".$secret."&response=".$respuesta."&remoteip=".$ip);
    
    $responseKeys = json_decode($resultado,true);
    
    return $responseKeys["success"];
}

function Mandarmail($nombre, $correo, $mensaje){
    
    //origen
    $mail = "contacto@forgesa.net";

    $header = 'From: ' . $mail . " \r\n";
    $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
    $header .= "Mime-Version: 1.0 \r\n";
    $header .= "Content-Type: text/html; charset=UTF-8";

    $mensaje = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Este es un mensaje</title>
        <style>
            .cuerpo{            
            }
            .titulo{
                background-color: #5a5050;
                color: #e5e3e3;
            }   
        </style>
    </head>
    <body>
        <div class="cabecera">
            <h1 class="titulo">Contacto desde la web</h1>
        </div>
        <div class="cuerpo">
           <h3>Datos-Cotizacion</h3>
            <li>Nombre:</li>'.$nombre.'<br>
            <li>Correo:</li>'.$correo.'<br>
            <li>Mensaje:</li>'.$mensaje.'<br>
            
        </div>
    </body>
    ';

    //destino
    $para = 'contacto@forgesa.net';
    $asunto = 'Cotizacion de mi sitio web';

    $respuesta=mail($para, $asunto, utf8_decode($mensaje), $header);

    //$para2 = '';
    //mail($para2,$asunto, utf8_decode($mensaje), $header);

    if($respuesta){
        echo '<h5>Correo enviado</h5>' ;
    }else{
        echo '<h5>Error al mandar el correo</h5>';
    }
}

?>