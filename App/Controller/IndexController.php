<?php

namespace App\Controller;
use YourOwnFramework\Controller;

/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */
class IndexController extends Controller
{
    public function indexAction()
    {

        return ['test' => $userId];
    }
}
