<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Este es el adaptador que implementa el contrato (el puerto)
class PhpMailAdapter implements SendEmailPort {
    
    public function send(string $to, string $subject, string $body): void {
        $mail = new PHPMailer(true);

        try {
            // --- CONFIGURACIÓN DEL SERVIDOR SMTP ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';         // Servidor de Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aperezm15@unicartagena.edu.co';    // Tu correo real
            $mail->Password   = 'hovl srxg dcve tqpv';    // Tu contraseña de aplicación (16 letras)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            // --- DESTINATARIOS ---
            $mail->setFrom('TU_CORREO@gmail.com', 'Sistema CRUD');
            $mail->addAddress($to);

            // --- CONTENIDO ---
            $mail->isHTML(true); // Habilitamos HTML para que el link sea clickeable
            $mail->Subject = $subject;
            
            // Diseñamos un cuerpo de correo más profesional
            $mail->Body = "
                <div style='font-family: sans-serif; border: 1px solid #ddd; padding: 20px; max-width: 600px;'>
                    <h2 style='color: #333;'>¡Bienvenido!</h2>
                    <p>Has recibido este mensaje para activar tu cuenta en nuestro sistema.</p>
                    <p>Por favor, haz clic en el botón de abajo para confirmar tu registro:</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$body}' style='background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                            ACTIVAR CUENTA
                        </a>
                    </div>
                    <p style='font-size: 0.8em; color: #777;'>Si el botón no funciona, copia este link en tu navegador:<br>{$body}</p>
                </div>
            ";

            $mail->send();

            // Guardamos registro en el TXT de que el envío real fue exitoso
            $log = "[REAL-SENT] PARA: $to | FECHA: " . date('Y-m-d H:i:s') . "\n";
            file_put_contents("simulador_emails.txt", $log, FILE_APPEND);

        } catch (Exception $e) {
            // Si falla el envío real, guardamos el error detallado en un archivo log
            $errorLog = "ERROR enviando a $to: {$mail->ErrorInfo} | " . date('Y-m-d H:i:s') . "\n";
            file_put_contents("error_email.txt", $errorLog, FILE_APPEND);
            
            // Opcional: seguimos guardando en el simulador para que no pierdas el token si falla el internet
            $log = "[FAILED-REAL] PARA: $to \nCONTENIDO: $body \n" . str_repeat("-", 30) . "\n";
            file_put_contents("simulador_emails.txt", $log, FILE_APPEND);
        }
    }
}