<?php

// Asegúrate de que las solicitudes sean POST, ya que la mayoría de los webhooks usan POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtén los datos enviados en formato JSON (la mayoría de los servicios de webhook lo envían así).
    $input = file_get_contents('php://input');
    
    // Decodificar el JSON en un arreglo de PHP
    $data = json_decode($input, true);

    // Verificar que los datos fueron correctamente decodificados
    if ($data === null) {
        // Responder con un error si los datos no son válidos
        http_response_code(400);  // Bad Request
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Aquí, puedes manejar los datos recibidos como desees.
    // Por ejemplo, si recibimos un pago exitoso, puedes actualizar la base de datos o enviar un correo.

    // Imprimir los datos recibidos (esto es solo para depuración, puedes removerlo después)
    file_put_contents('webhook_log.txt', print_r($data, true), FILE_APPEND);

    // Dependiendo del tipo de webhook, puedes hacer diferentes acciones.
    // Supongamos que tienes un campo "event" en el JSON recibido:
    if (isset($data['event']) && $data['event'] == 'payment.success') {
        // Lógica cuando el pago es exitoso
        // Por ejemplo, actualizar un pedido en la base de datos, enviar un correo, etc.
        echo json_encode(['status' => 'success', 'message' => 'Payment successful']);
    } else {
        // Si el evento no es el que esperamos
        echo json_encode(['status' => 'error', 'message' => 'Unhandled event type']);
    }

    // Responder con un 200 OK, que indica que todo fue recibido y procesado correctamente.
    http_response_code(200);  // OK
} else {
    // Si no es un POST, responder con un error 405 (Método no permitido)
    http_response_code(405);  // Method Not Allowed
    echo json_encode(['error' => 'Only POST requests are allowed']);
}
?>
