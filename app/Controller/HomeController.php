<?php

namespace Baim\Belajar\PHP\MVC\Controller;

use Baim\Belajar\PHP\MVC\App\View;
use Baim\Belajar\PHP\MVC\Repository\SessionRepository;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\Service\SessionService;

class HomeController 
{
    private SessionService $sessionService;

    public function __construct() {
        $connection = Database::getConnection();
        $sessionRepository = new SessionRepository($connection);
        $userRepository = new UserRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }
    public function index(): void 
    {
        $user = $this->sessionService->current();
        // var_dump($user); exit();
        if ($user == null) {
            $model = [
                "title" => "PHP Login Management",
                "content" => "Selamat Belajar PHP MVC dari Programmer Zaman Now!"
            ];
            
            View::render('Home/index', $model);
        } else {
            View::render('Home/dashboard', [
                "title" => "Dashboard",
                "user" => [
                    "name" => $user->name
                ]
                ]);
        }
        
    }

    function login(): void 
    {
        // $request = [
        //     "username" => $_POST['username'],
        //     "password" => $_POST['password'],
        // ];

        echo "login dulu";
    }
}