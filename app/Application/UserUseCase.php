<?php
namespace App\Application;

use App\Domain\UserRepository;
use App\Domain\UserEntity;
use Exception;

class UserUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findUserById(string $id): ?UserEntity
    {
        return $this->userRepository->findById($id);
    }
    
    public function listUser(): array
    {
        return $this->userRepository->list();
    }

    public function registerUser(
        string $email,
        string $password,
        ?string $name  = null,
        ?string $phone = null
    ): UserEntity
    {
        $user = new UserEntity($email, $password, $name, $phone);
        $this->userRepository->save($user);

        return $user;
    }

    public function updateUser(
        string $id,
        ?string $email = null,
        ?string $password = null,
        ?string $name  = null,
        ?string $phone = null
    ): void
    {
        $user = $this->userRepository->findById($id);

        if ($user !== null) {
            $user->update($email, $password, $name, $phone);
            $this->userRepository->update($user);
        } else {
            throw new Exception("El objeto con ID $id no existe en el arreglo.");
        }
    }

    public function deleteUser(string $id): void
    {
        $this->userRepository->delete($id);
    }
}
