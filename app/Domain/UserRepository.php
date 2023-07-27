<?php
namespace App\Domain;

use App\Domain\UserEntity;

interface UserRepository {
    public function findById(string $id): ?UserEntity;
    public function list(): array;
    public function save(UserEntity $user): void;
    public function update(UserEntity $user): void;
    public function delete(string $id): void;
}