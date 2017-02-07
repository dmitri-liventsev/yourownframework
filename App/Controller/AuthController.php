<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use YourOwnFramework\Controller;

class AuthController extends Controller
{
    public function loginAction()
    {
        try {
            $this->auth->login($this->request->get('email'), $this->request->get('password'));
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->redirect('auth\wrong');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->redirect('auth\wrong');
        }

        $this->redirect('profile');
    }

    public function logoutAction()
    {
        $this->auth->logout();
        $this->redirect('');
    }

    public function wrongAction()
    {
        $this->template = "wrongAuth";
    }
}
