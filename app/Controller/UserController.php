<?php

namespace Baim\Belajar\PHP\MVC\Controller;

use Baim\Belajar\PHP\MVC\App\View;
use Baim\Belajar\PHP\MVC\Service\UserService;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Model\UserRegisterRequest;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\Exception\ValidationException;

class UserController
{
    private UserService $userService;

    public function __construct() {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
    }

    public function register() 
    {
        View::render('User/register', [
            'title' => 'Register New User',
            // 'error' => 'A simple primary alert—check it out!'
        ]);

    }

    public function postRegister() 
    {
        $request = new UserRegisterRequest();
        $request->id = $_POST['id'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try {
            $this->userService->register($request);
            
            //redirect to  /user/login
            View::redirect('/users/login');
            
        } catch (ValidationException $exception) {
            View::render('User/register', [
                'title' => 'Register New User',
                'error' => $exception->getMessage()
            ]);
        }
    }
}