<?php
// Permitir solicitudes desde tu dominio (Seguridad básica)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y limpiar los datos del formulario
    $nombre    = strip_tags(trim($_POST["nombre"]));
    $telefono  = strip_tags(trim($_POST["telefono"]));
    $servicio  = strip_tags(trim($_POST["servicio"]));
    $mensaje   = htmlspecialchars(trim($_POST["mensaje"]));

    // Correo al que llegará la cotización (Cambia esto por tu correo real del dominio)
    $destinatario = "alfredo.ramirez@masacabados.com"; 

    // Asunto del correo
    $asunto = "Nueva Cotización Web de: " . $nombre;

    // Cuerpo del mensaje
    $cuerpo  = "Has recibido una nueva solicitud de cotización desde la landing page:\n\n";
    $cuerpo .= "Nombre: " . $nombre . "\n";
    $cuerpo .= "Teléfono / WhatsApp: " . $telefono . "\n";
    $cuerpo .= "Servicio de Interés: " . $servicio . "\n";
    $cuerpo .= "Mensaje / Detalles:\n" . $mensaje . "\n";

    // Cabeceras del correo
    $headers = "From: no-reply@tu-dominio.com\r\n"; // Idealmente un correo generado en tu hosting
    $headers .= "Reply-To: " . $telefono . "\r\n";

    // Enviar correo usando la función nativa de PHP
    if (mail($destinatario, $asunto, $cuerpo, $headers)) {
        echo json_encode(["status" => "success", "message" => "¡Mensaje enviado con éxito!"]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Error al enviar el correo."]);
    }
} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Acceso no permitido."]);
}
?>