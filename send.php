<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$data = json_decode(file_get_contents('php://input'), true);

$correo = $data['correo'] ?? 'No disponible';
$direccion = $data['direccion'] ?? 'No disponible';
$guia = $data['guia'] ?? 'No disponible';
$pago = $data['pago'] ?? 'No disponible';
$celular = $data['celular'] ?? 'No disponible';
$ciudad = $data['ciudad'] ?? 'No disponible';
$barrio = $data['barrio'] ?? 'No disponible';
$productos = $data['productos'] ?? '';
$total = $data['total'] ?? '0.00';

// Identificador único y fecha/hora
$pedidoID = strtoupper(uniqid('PED-'));
$fecha = date("d/m/Y");
$hora = date("H:i:s");

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yonkis527@gmail.com';
    $mail->Password   = 'wllh eehd hzft ddnv'; // App password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom('yonkis527@gmail.com', 'D-TopTech');
    $mail->addAddress('yonkis527@gmail.com');

    



// Enviar copia al cliente
$mail->addAddress($correo);

    $mail->isHTML(true);
    $mail->Subject = "Pedido Confirmado - $pedidoID";

    $mail->Body = "
    <div style='font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f4f5; padding: 40px;'>
      <div style='max-width: 600px; margin: auto; background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);'>

        <!-- Logo -->
        <div style='text-align: center; margin-bottom: 30px;'>
          <img src='https://i.ibb.co/LD09hgGy/piclumen-1743631128816-removebg-preview.png' alt='Logo Empresa' width='80' style='margin-bottom: 10px;' />
          <h2 style='margin: 0; font-size: 22px; color: #111;'>Pedido Confirmado</h2>
          <p style='color: #888; font-size: 14px;'>ID Pedido: <strong>$pedidoID</strong></p>
          <p style='color: #888; font-size: 13px;'>Fecha: $fecha — Hora: $hora</p>
        </div>

        <!-- Datos del cliente -->
        <div style='margin-bottom: 25px;'>
          <h3 style='border-bottom: 1px solid #eee; padding-bottom: 10px; color: #111;'>Datos del Cliente</h3>
          <p><strong>Correo:</strong> $correo</p>
          <p><strong>Dirección:</strong> $direccion</p>
          <p><strong>Guía:</strong> $guia</p>
          <p><strong>Pago:</strong> $pago</p>
          <p><strong>Celular:</strong> $celular</p>
          <p><strong>Ciudad:</strong> $ciudad</p>
          <p><strong>Barrio:</strong> $barrio</p>
        </div>

        <!-- Pedido -->
        <div style='margin-bottom: 20px;'>
          <h3 style='border-bottom: 1px solid #eee; padding-bottom: 10px; color: #111;'>Resumen del Pedido</h3>
          <table style='width: 100%; border-collapse: collapse; font-size: 14px;'>
            <thead>
              <tr style='background: #f8f8f8; text-align: left;'>
                <th style='padding: 8px; border: 1px solid #ddd;'>Producto</th>
                <th style='padding: 8px; border: 1px solid #ddd;'>Cantidad</th>
                <th style='padding: 8px; border: 1px solid #ddd;'>Precio</th>
              </tr>
            </thead>
            <tbody>
              $productos
            </tbody>
          </table>
          <p style='margin-top: 10px; font-size: 16px; text-align: right;'><strong>Total: $total</strong></p>
        </div>

        <!-- Footer -->
        <div style='text-align: center; color: #999; font-size: 12px; margin-top: 30px;'>
          <p>Gracias por tu compra ❤️</p>
          <p>D-TopTech - Todos los derechos reservados</p>
          <p>Si tienes alguna duda o inquietud contactanos</p> 
        </div>

      </div>
    </div>
    ";

    $mail->send();
    echo 'Correo enviado correctamente.';
} catch (Exception $e) {
    echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
}
