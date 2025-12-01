<?php

namespace Baim\Belajar\PHP\MVC\Controller;

use Baim\Belajar\PHP\MVC\App\View;
use Baim\Belajar\PHP\MVC\Repository\SessionRepository;
use Baim\Belajar\PHP\MVC\Service\UserService;
use Baim\Belajar\PHP\MVC\Service\SessionService;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Model\UserRegisterRequest;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\Exception\ValidationException;
use Baim\Belajar\PHP\MVC\Model\UserLoginRequest;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct() {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
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

    public function login()
    {
        View::render('User/login', [
            'title' => 'Login User',
        ]);
    }

    public function postLogin()
    {
        $request = new UserLoginRequest();
        $request->id = $_POST['id'];
        $request->password = $_POST['password'];

        try {
            $response = $this->userService->login($request);

            //set cookie
            $this->sessionService->create($response->user->id);
            View::redirect('/');
        } catch (ValidationException $exception) {
            View::render('User/login', [
                'title' => 'Login User',
                'error' => $exception->getMessage(),
            ]);
        }
        
    }

    public function logout() 
    {
        $this->sessionService->destroy();
        View::redirect("/");
    }
}