<?php

namespace App\Infrastructure;

use App\Domain\UserRepository;
use App\Domain\UserEntity;
use Exception;

class MemoryRepository implements UserRepository
{
    private $users = [];

    public function findById(string $id): ?UserEntity
    {
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                return $user;
            }
        }
        
        return null;
    }

    public function list(): array
    {
        return $this->users;
    }

    public function save(UserEntity $user): void
    {
        $this->users[] = $user;
    }

    public function update(UserEntity $user): void
    {
        $this->users = array_map(function($u) use ($user) {
            if ($u->getId() === $user->getId()) {
                return $user;
            }

            return $u;
        }, $this->users);
    }

    public function delete(string $id): void
    {
        $existUser = false;
        foreach ($this->users as $user) {
            if ($user->getId() === $id) {
                $existUser = true;
                break;
            }
        }

        if (!$existUser) {
            throw new Exception("El objeto con ID $id no existe en el arreglo.");
        }

        $this->users = array_filter($this->users, function($user) use ($id) {
            return $user->getId() !== $id;
        });
    }
}