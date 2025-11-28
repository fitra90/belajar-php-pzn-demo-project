<?php

namespace Baim\Belajar\PHP\MVC\Controller;

use PHPUnit\Framework\TestCase;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\Controller\UserController;

class UserControllerTest extends TestCase
{
    private UserController $userController;

    public function testRegister()
    {
        $this->userController = new UserController();

        $userRepository = new UserRepository(Database::getConnection());
        $userRepository->deleteAll();
    }
    
    public function testPostRegister()
    {
        $this->userController->register();
        
        $this->expectOutputRegex('[Register]');
        $this->expectOutputRegex('[Id]');
        $this->expectOutputRegex('[Name]');
        $this->expectOutputRegex('[Password]');
        $this->expectOutputRegex('[Register new User]');
    }
    
    public function testPostRegisterSuccess()
    {
        
    }
    
    public function testPostRegisterValidationError()
    {

    }
    
    public function testPostRegisterDuplicate()
    {

    }
}