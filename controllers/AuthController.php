<?php


namespace app\controllers;


use app\services\Security;
use Framework\Controllers\BaseController;
use Framework\Registry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Throwable
     */
    public function authenticationAction(Request $request)
    {
        if (Registry::getService('user.security')->isLogged()) {
            return $this->redirect('index');
        }

        $username = $request->get('username');
        $password = $request->get('password');
        /* @var $security Security */
        if ($this->getRequest()->isMethod('POST') && $username && $password) {
            $security = Registry::getService('user.security');
            if ($security->authentication($username, $password)) {
                return $this->redirect('index');
            }

            return $this->redirect('login');
        }

        return $this->render('/auth/authentication.php');
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function logoutAction(): Response
    {
        Registry::getService('user.security')->logout();

        return $this->redirect('index');
    }

}
