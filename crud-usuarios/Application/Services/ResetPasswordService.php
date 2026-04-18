<?php
declare(strict_types=1);

final class ResetPasswordService {
    private GetUserByEmailPort $getUserByEmailPort;
    private SaveUserPort $saveUserPort;
    private SendEmailPort $sendEmailPort;

    public function __construct(
        GetUserByEmailPort $getUserByEmailPort,
        SaveUserPort $saveUserPort,
        SendEmailPort $sendEmailPort
    ) {
        $this->getUserByEmailPort = $getUserByEmailPort;
        $this->saveUserPort = $saveUserPort;
        $this->sendEmailPort = $sendEmailPort;
    }

    public function execute(string $email): void {
        $userEmail = new UserEmail($email);
        $user = $this->getUserByEmailPort->getByEmail($userEmail);
        
        // Si el usuario no existe, no hacemos nada (seguridad)
        if (!$user) return;

        // 1. Generar contraseña temporal de 8 caracteres
        $tempPassword = substr(bin2hex(random_bytes(4)), 0, 8); 
        $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
        
        // 2. Actualizar en la base de datos
        // Asegúrate de que tu SaveUserPort y Repository tengan este método
        $this->saveUserPort->updatePassword($user->id(), $hashedPassword);

        // 3. Enviar el email
        $subject = "Recuperar contraseña - " . $user->name()->value();
        
        // Enviamos un array o un formato que el Adaptador entienda para la plantilla
        // En este caso, mandamos la clave temporal como cuerpo
        $this->sendEmailPort->send($email, $subject, $tempPassword);
    }
}