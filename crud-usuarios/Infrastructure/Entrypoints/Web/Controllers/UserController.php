<?php
declare(strict_types=1);

final class UserController
{
    private CreateUserUseCase $createUserUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private GetUserByIdUseCase $getUserByIdUseCase;
    private GetAllUsersUseCase $getAllUsersUseCase;
    private DeleteUserUseCase $deleteUserUseCase;
    private ResetPasswordService $resetPasswordService;
    private UserWebMapper $mapper;

    public function __construct(
        CreateUserUseCase $createUserUseCase,
        UpdateUserUseCase $updateUserUseCase,
        GetUserByIdUseCase $getUserByIdUseCase,
        GetAllUsersUseCase $getAllUsersUseCase,
        DeleteUserUseCase $deleteUserUseCase,
        ResetPasswordService $resetPasswordService,
        UserWebMapper $mapper
    ) {
        $this->createUserUseCase = $createUserUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->getUserByIdUseCase = $getUserByIdUseCase;
        $this->getAllUsersUseCase = $getAllUsersUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->resetPasswordService = $resetPasswordService;
        $this->mapper = $mapper;
    }

    public function index(): array
    {
        $users = $this->getAllUsersUseCase->execute(new GetAllUsersQuery());
        return $this->mapper->fromModelsToResponses($users);
    }

    public function show(string $id): UserResponse
    {
        $query = $this->mapper->fromIdToGetByIdQuery($id);
        $user = $this->getUserByIdUseCase->execute($query);
        return $this->mapper->fromModelToResponse($user);
    }

    public function store(CreateUserWebRequest $request): void
    {
        $command = $this->mapper->fromCreateRequestToCommand($request);
        $this->createUserUseCase->execute($command);
    }

    public function update(UpdateUserWebRequest $request): void
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);
        $this->updateUserUseCase->execute($command);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteUserUseCase->execute($command);
    }

    public function sendResetLink(string $email): void
    {
        $this->resetPasswordService->execute($email);
    }
}