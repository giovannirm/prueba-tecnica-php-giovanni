<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Application\UserUseCase;
use App\Infrastructure\MemoryRepository;

class UserTest extends TestCase
{
    public function testRegisterUser()
    {
        $userRepository = new MemoryRepository();
        $userUseCase = new UserUseCase($userRepository);

        $user1 = $userUseCase->registerUser('giovannirm.python@gmail.com', '123456', 'Giovanni Rojas', '920660097');

        $this->assertEquals('giovannirm.python@gmail.com', $user1->getEmail());
        $this->assertEquals('Giovanni Rojas', $user1->getName());
        $this->assertEquals(true, $user1->verifyPassword('123456'));
        $this->assertEquals('920660097', $user1->getPhone());
    }

    public function testDeleteUser()
    {
        $userRepository = new MemoryRepository();
        $userUseCase = new UserUseCase($userRepository);

        $user1 = $userUseCase->registerUser('giovannirm.python@gmail.com', '123456', 'Giovanni Rojas', '920660097');
        $user2 = $userUseCase->registerUser('demo1@gmail.com', '123456');
        $user3 = $userUseCase->registerUser('demo2@gmail.com', '123456');

        $userUseCase->deleteUser($user3->getId());
        $users = $userUseCase->listUser();

        $this->assertCount(2, $users);
    }

    public function testUpdateUser()
    {
        $userRepository = new MemoryRepository();
        $userUseCase = new UserUseCase($userRepository);

        $user1 = $userUseCase->registerUser('giovannirm.python@gmail.com', '123456', 'Giovanni Rojas', '920660097');
        $user2 = $userUseCase->registerUser('demo3@gmail.com', '123456');

        $userUseCase->updateUser($user2->getId(), 'benito@gmail.com', '654321', 'Benito Juarez');
        $updatedUser = $userRepository->findById($user2->getId());

        $this->assertEquals('benito@gmail.com', $updatedUser->getEmail());
        $this->assertEquals('Benito Juarez', $updatedUser->getName());
        $this->assertEquals(true, $updatedUser->verifyPassword('654321'));
    }
}
