<?php

namespace Baim\Belajar\PHP\MVC\Controller;

use Baim\Belajar\PHP\MVC\App\View;

class HomeController 
{
    function index(): void 
    {
        $model = [
            "title" => "Belajar PHP MVC",
            "content" => "Selamat Belajar PHP MVC dari Programmer Zaman Now!"
        ];
        
        View::render('Home/index', $model);
    }

    function hellow(): void 
    {
        echo "home controller.hellow()";
    }

    function world(): void 
    {
        echo "home controller.world()";
    }

    function author(): void 
    {
        echo "author name: fitra fadilana";
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