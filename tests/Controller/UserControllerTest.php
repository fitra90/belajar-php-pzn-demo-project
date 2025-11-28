<?php

namespace Baim\Belajar\PHP\MVC\App {
    function header(string $value) 
    {
        echo $value;
    }
}

namespace Baim\Belajar\PHP\MVC\Controller{
        
    use PHPUnit\Framework\TestCase;
    use Baim\Belajar\PHP\MVC\Config\Database;
    use Baim\Belajar\PHP\MVC\Repository\UserRepository;
    use Baim\Belajar\PHP\MVC\Controller\UserController;
    use Baim\Belajar\PHP\MVC\Domain\User;

    class UserControllerTest extends TestCase
    {
        private UserController $userController;
        private UserRepository $userRepository;

        protected function setUp(): void
        {
            $this->userController = new UserController();

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userRepository->deleteAll();

            putenv("mode=test");
        }
        
        public function testRegister()
        {
            $this->userController->register();
            
            $this->expectOutputRegex('[Register]');
            $this->expectOutputRegex('[Id]');
            $this->expectOutputRegex('[Name]');
            $this->expectOutputRegex('[Password]');
            $this->expectOutputRegex('[Register New User]');
        }
        
        public function testPostRegisterSuccess()
        {
            $_POST['id'] = "eko";
            $_POST['name'] = "Eko";
            $_POST['password'] = "eko123";

            $this->userController->postRegister();

            $this->expectOutputRegex("[Location: /users/login]");
        }
        
        public function testPostRegisterValidationError()
        {
            $_POST['id'] = "";
            $_POST['name'] = "Eko";
            $_POST['password'] = "eko123";

            $this->userController->postRegister();

            $this->expectOutputRegex('[Register]');
            $this->expectOutputRegex('[Id]');
            $this->expectOutputRegex('[Name]');
            $this->expectOutputRegex('[Password]');
            $this->expectOutputRegex('[Register New User]');
            $this->expectOutputRegex('[Id, name, password jangan kosong]');

        }
        
        public function testPostRegisterDuplicate()
        {
            $user = new User();
            $user->id = "eko";
            $user->name = "Eko";
            $user->password = "eko123";

            $this->userRepository->save($user);

            $_POST['id'] = "eko";
            $_POST['name'] = "Eko";
            $_POST['password'] = "eko123";

            $this->userController->postRegister();

            $this->expectOutputRegex('[Register]');
            $this->expectOutputRegex('[Id]');
            $this->expectOutputRegex('[Name]');
            $this->expectOutputRegex('[Password]');
            $this->expectOutputRegex('[Register New User]');
            $this->expectOutputRegex('[user already exist]');

        }
    }
}
