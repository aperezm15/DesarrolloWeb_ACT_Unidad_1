<?php

class UserAlreadyExistsException extends InvalidArgumentException {
    public static function becauseEmailAlreadyExists($email) {
        return new self("El usuario con el email ". $email ." ya existe");
    }
}