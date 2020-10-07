<?php

use projectorangebox\app\App;
use projectorangebox\request\Request;
use projectorangebox\container\Container;

define('__ROOT__', dirname(__DIR__));

require __ROOT__ . '/vendor/autoload.php';

mergeDotEnv();

(new App(new Container(require __ROOT__ . '/config/services.php')))->dispatch(/* optional request object */)->display();
