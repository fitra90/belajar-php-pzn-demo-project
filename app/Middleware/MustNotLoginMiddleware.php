<?php

namespace Baim\Belajar\PHP\MVC\Middleware;

use Baim\Belajar\PHP\MVC\Repository\SessionRepository;
use Baim\Belajar\PHP\MVC\Service\SessionService;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\App\View;

class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct() {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());

        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void 
    {
        $user = $this->sessionService->current();
        if ($user != null) {
            View::redirect('/');
        }
    }

}