<?php

require_once __DIR__ . '/../../Services/Dto/Commands/LoginCommand.php';
require_once __DIR__ . '/../../../Domain/Models/UserModel.php';

interface LoginUseCase
{


    
    public function execute(LoginCommand $command): UserModel;
}