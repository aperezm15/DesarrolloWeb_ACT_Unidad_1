<?php
declare(strict_types=1);

/**
 * Este es mi contrato para enviar correos. 
 * No me importa si usamos Gmail, Mailtrap o una paloma mensajera,
 * mientras cumpla con tener esta función 'send'.
 */
interface SendEmailPort {
    public function send(string $to, string $subject, string $body): void;
}