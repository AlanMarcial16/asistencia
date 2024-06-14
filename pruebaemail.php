<?php
$to_email = "jamitmarcial@gmail.com";
$subject = "Correo de prueba";
$body = "Hola, este es un correo de prueba enviado desde PHP usando la función mail().";

$headers = "From: 201758356am@gmail.com\r\n";
$headers .= "Reply-To: 201758356am@gmail.com\r\n";
$headers .= "Content-type: text/html\r\n";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Correo enviado correctamente a $to_email";
} else {
    echo "Error al enviar el correo.";
}
?>
