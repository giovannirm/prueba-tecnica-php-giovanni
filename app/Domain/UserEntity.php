<?php
namespace App\Domain;

class UserEntity {
    private string $id;
    private string $email;
    private string $password;
    private ?string $name;
    private ?string $phone;

    public function __construct(
        string  $email,
        string  $password,
        ?string $name  = null,
        ?string $phone = null
    ) {
        $this->id       = uniqid();
        $this->email    = $email;
        $this->password = $this->hashPassword($password);
        $this->name     = $name ?: "";
        $this->phone    = $phone ?: "";
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    // No se debe tener un método para obtener la contraseña, solo se puede verificar si coincide.
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    // Método para cambiar la contraseña de forma segura.
    public function changePassword(string $newPassword): void
    {
        $this->password = $this->hashPassword($newPassword);
    }

    // Método privado para generar el hash de la contraseña.
    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {   
        $this->name = $name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {   
        $this->phone = $phone;
    }

    public function update(
        ?string $email    = null,
        ?string $password = null,
        ?string $name     = null,
        ?string $phone    = null
    ): void
    {
        $this->email    = $email ?: $this->email;
        $this->name     = $name  ?: $this->name;
        $this->phone    = $phone ?: $this->phone;
        $this->password = $this->hashPassword($password) ?: $this->password;
    }
}