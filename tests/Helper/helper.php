<?php

namespace Baim\Belajar\PHP\MVC\App {
    function header(string $value) 
    {
        echo $value;
    }

}

namespace Baim\Belajar\PHP\MVC\Service {
    // dummy header response for testing
    function setCookie(string $name, string $value)
    {
        echo "$name: $value";
    }

}
