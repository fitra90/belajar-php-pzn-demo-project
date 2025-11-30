<?php

namespace Baim\Belajar\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Domain\Session;
use Baim\Belajar\PHP\MVC\Repository\SessionRepository;
use Baim\Belajar\PHP\MVC\Domain\User;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;

// dummy header response for testing
function setCookie(string $name, string $value)
{
    echo "$name: $value";
}

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp(): void 
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
        
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = "rahasia123";
        $this->userRepository->save($user);
    }

    public function testCreate()
    {
        $session = $this->sessionService->create("eko");

        $this->expectOutputRegex("[X-BAIMNDUT-SESSION: $session->id]");

        $result = $this->sessionRepository->findById($session->id);

        self::assertEquals("eko", $result->userId);
    }

    public function testDestroy()
    {
        //buat user session dummy dulu
        $session = new Session();
        $session->id = uniqid(); 
        $session->userId = "eko";

        $this->sessionRepository->save($session);

        //set cookie
        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;
        
        //panggil function destory di SessionService
        $this->sessionService->destroy();

        // cek apakah session sudah hilang
        $this->expectOutputRegex("[X-BAIMNDUT-SESSION: ]");

        // cek apakah terhapus di database dengan mencari by session id
        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testCurrent()
    {
        //buat user session dummy dulu
        $session = new Session();
        $session->id = uniqid(); 
        $session->userId = "eko";

        $this->sessionRepository->save($session);

        //set cookie
        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $user = $this->sessionService->current();

        self::assertEquals($session->userId, $user->id);
    }

}