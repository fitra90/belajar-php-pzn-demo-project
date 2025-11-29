<?php

namespace Baim\Belajar\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;
use Baim\Belajar\PHP\MVC\Domain\User;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Exception\ValidationException;
use Baim\Belajar\PHP\MVC\Model\UserLoginRequest;
use Baim\Belajar\PHP\MVC\Model\UserRegisterRequest;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private UserRepository $userRepository;

    protected function setUp(): void 
    {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);

        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new UserRegisterRequest();
        $request->id = "edko";
        $request->name = "Eko";
        $request->password = "abc123";

        $response = $this->userService->register($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertEquals($request->name, $response->user->name);
        self::assertNotEquals($request->password, $response->user->password);
        
        self::assertTrue(password_verify($request->password, $response->user->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);
        $request = new UserRegisterRequest();
        $request->id = "";
        $request->name = "";
        $request->password = "";

        $this->userService->register($request);
    }

    public function testRegisterDuplicate()
    {
        $user = new User();
        $user->id = "edko";
        $user->name = "Eko";
        $user->password = "abc123";

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->id = "edko";
        $request->name = "Eko";
        $request->password = "abc123";

        $this->userService->register($request);

    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "eko";
        $request->password = "eko123";

        $this->userService->login($request);
        
    }

    public function testLoginSuccess()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = password_hash("eko123", PASSWORD_BCRYPT);
        
        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "eko";
        $request->password = "eko123";

         $response = $this->userService->login($request);

        self::assertEquals($request->id, $response->user->id);
        self::assertTrue(password_verify($request->password, $response->user->id));
    }

    public function testLoginWrongPassword()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = password_hash("eko", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);

        $request = new UserLoginRequest();
        $request->id = "eko";
        $request->password = "salah123";

        $this->userService->login($request);
    }
}