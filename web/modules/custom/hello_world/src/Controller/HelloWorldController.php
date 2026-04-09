<?php

declare(strict_types=1);

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

class HelloWorldController extends ControllerBase {
    public function greeting(){
        return [
            "#markup" => '<h1>Hello world!</h1>', 
        ];
    }
}