<?php
declare(strict_types=1);

// Este es el adaptador que implementa el contrato (el puerto) de arriba.
class PhpMailAdapter implements SendEmailPort {
    
    public function send(string $to, string $subject, string $body): void {
        // 1. Usamos la función nativa de PHP para enviar el mail.
        // Nota: En localhost (XAMPP/Laragon) esto a veces no sale de tu PC,
        // pero es el comando correcto.
        @mail($to, $subject, $body, "From: sistema@tu-web.com");

        // Voy a crear un archivo .txt para ver el correo que se acaba de enviar.
        // Así puedo copiar el link de activación desde aquí.
        $log = "PARA: $to \nASUNTO: $subject \nCONTENIDO: $body \n" . str_repeat("-", 30) . "\n";
        file_put_contents("simulador_emails.txt", $log, FILE_APPEND);
    }
}