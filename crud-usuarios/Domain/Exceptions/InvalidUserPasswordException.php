<?php

class InvalidUserPasswordException extends InvalidArgumentException {

    public static function becauseValueIsEmpty() {
        return new self("La contraseña no puede estar vacia");
    }

    public static function becauseLengthIsTooShort($min) {
        return new self("La constraseña es muy corta");
    }
}