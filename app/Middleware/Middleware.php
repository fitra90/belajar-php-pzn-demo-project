<?php

namespace Baim\Belajar\PHP\MVC\Middleware;

interface Middleware 
{
    function before(): void;
}