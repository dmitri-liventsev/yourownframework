<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use YourOwnFramework\Controller;

class ProfileController extends Controller
{
    public function indexAction()
    {
        $this->template = 'form';
    }
}
