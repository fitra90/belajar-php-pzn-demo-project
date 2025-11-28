<?php

namespace Baim\Belajar\PHP\MVC\Service;

use Baim\Belajar\PHP\MVC\Model\UserRegisterRequest;
use Baim\Belajar\PHP\MVC\Model\UserRegisterResponse;
use Baim\Belajar\PHP\MVC\Repository\UserRepository;
use Baim\Belajar\PHP\MVC\Domain\User;
use Baim\Belajar\PHP\MVC\Config\Database;
use Baim\Belajar\PHP\MVC\Exception\ValidationException;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);
        
       try {
            Database::beginTransaction();

            $user = $this->userRepository->findById($request->id);
            if($user != null) {
                throw new ValidationException("user already exist");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            Database::commitTransaction();
            return $response;
            
       } catch (\Exception $e){
            Database::rollBackTransaction();
            throw $e;
       } 
       
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if ($request->id == null || $request->name == null || $request->password == null || trim($request->id == "" || trim($request->name) == "" || trim($request->password) == "")) {
            throw new ValidationException("Id, name, password jangan kosong");
        }

    }
}