<?php
/**
 * @author Dmitri Liventsev <dmitri.linvetsev@gmail.com>
 */

namespace App\Controller;

use YourOwnFramework\Controller;
use YourOwnFramework\Request\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     */
    public function loginAction(Request $request)
    {
        try {
            $this->auth->login($request->get('email'), $request->get('password'));
        } catch (\Delight\Auth\InvalidEmailException $e) {
            $this->redirect('auth\wrong');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->redirect('auth\wrong');
        }

        $this->redirect('profile');
    }

    /**
     * @param Request $request
     */
    public function logoutAction(Request $request)
    {
        $this->auth->logout();
        $this->redirect('');
    }

    /**
     * @param Request $request
     */
    public function wrongAction(Request $request)
    {
        $this->template = "wrongAuth";
    }
}
