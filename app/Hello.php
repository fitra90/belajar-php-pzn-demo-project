<?php

namespace Baim\Belajar\PHP\MVC;

class Hello
{
    public function sayHello(): void
    {
        echo "hello";
    }

}

$hello = new Hello;

$hello->sayHello();