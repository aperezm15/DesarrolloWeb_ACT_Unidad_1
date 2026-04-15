<?php

class InvalidUserIdException extends InvalidArgumentException {

    public static function becauseValueIsEmpty(){
        return new self("El ID del Usuario no puede estar vacio");
    }

}