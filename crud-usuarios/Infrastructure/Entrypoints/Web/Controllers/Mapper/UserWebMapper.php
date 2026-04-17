<?php



declare(strict_types=1);

final class UserWebMapper
{
    /**
     * Convierte la respuesta del dominio a un formato simple para la vista
     */
    public function mapResponse(UserModel $user): UserResponse
    {
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->role(),
            $user->status()
        );
    }

    /**
     * Convierte una lista de usuarios del dominio a una lista de respuestas
     * @param User[] $users
     * @return UserResponse[]
     */
    public function mapCollection(array $users): array
    {
        return array_map(fn(UserModel $user) => $this->mapResponse($user), $users);
    }
}