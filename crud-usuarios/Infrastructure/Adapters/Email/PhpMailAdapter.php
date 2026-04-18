<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PhpMailAdapter implements SendEmailPort {
    
    public function send(string $to, string $subject, string $body): void {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'aperezm15@unicartagena.edu.co';
            $mail->Password   = 'hovl srxg dcve tqpv'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('aperezm15@unicartagena.edu.co', 'Sistema CRUD');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;

            // --- LÓGICA DE PLANTILLAS ---
            if (strpos($subject, 'Recuperar') !== false) {
                // Plantilla para Recuperación de Contraseña
                // $body aquí contiene solo la clave temporal
                $tempPassword = $body;
                $email = $to;
                $name = "Usuario"; 

                ob_start();
                // Ruta hacia tu plantilla bonita de email
                include __DIR__ . '/../../Entrypoints/Web/Presentation/Views/email/forgot-password.php';
                $mail->Body = ob_get_clean();
            } else {
                // Plantilla para Activación de Cuenta
                // $body aquí contiene el link completo
                $mail->Body = "
                    <div style='font-family: sans-serif; border: 1px solid #ddd; padding: 20px; max-width: 600px;'>
                        <h2 style='color: #333;'>¡Bienvenido!</h2>
                        <p>Por favor, haz clic en el botón de abajo para confirmar tu registro:</p>
                        <div style='text-align: center; margin: 30px 0;'>
                            <a href='{$body}' style='background-color: #28a745; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold;'>
                                ACTIVAR CUENTA
                            </a>
                        </div>
                        <p style='font-size: 0.8em; color: #777;'>Si el botón no funciona, copia este link:<br>{$body}</p>
                    </div>";
            }

            $mail->send();
            file_put_contents("simulador_emails.txt", "[REAL-SENT] PARA: $to | " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

        } catch (Exception $e) {
            file_put_contents("error_email.txt", "ERROR: {$mail->ErrorInfo} | " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
        }
    }
}