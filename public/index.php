<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Application\UserUseCase;
use App\Infrastructure\MemoryRepository;

$userRepository = new MemoryRepository();

$userUseCase    = new UserUseCase($userRepository);

$user1 = $userUseCase->registerUser('giovannirm.python@gmail.com', '123456', 'Giovanni Rojas', '920660097');
$user2 = $userUseCase->registerUser('demo1@gmail.com', '123456');
$user3 = $userUseCase->registerUser('demo2@gmail.com', '123456');
$user4 = $userUseCase->registerUser('demo3@gmail.com', '123456');

$userUseCase->deleteUser($user3->getId());

$userUseCase->updateUser($user4->getId(), 'benito@gmail.com', '654321', 'Benito Juarez');

$users = $userUseCase->listUser();

foreach ($users as $user) {
    echo "ID: " . $user->getId() . "<br>";
    echo "Email: " . $user->getEmail() . "<br>";
    echo "Name: " . $user->getName() . "<br>";
    echo "Phone: " . $user->getPhone() . "<br>";
    echo "<hr>";
}