<?php

namespace App\Controllers;

use App\Config\Configuration;
use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\Responses\ViewResponse;
use App\Models\User;

/**
 * Class AuthController
 * Controller for authentication actions
 * @package App\Controllers
 */
class AuthController extends AControllerBase
{
    /**
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Login a user
     * @return Response
     */
    public function login(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        $logged = null;
        if (isset($formData['submit'])) {
            $logged = $this->app->getAuth()->login($formData['email'], $formData['password']);
            if ($logged) {
                return $this->redirect($this->url("admin.index"));
            }
            
            // if ($logged->admin) {
            //     return $this->redirect($this->url("admin.index"));
            // } else {
            //     return $this->redirect($this->url("customer.index"));
            // }
        }

        $data = ($logged === false ? ['message' => 'Nesprávne prihlasovacie údaje'] : []);
        return $this->html($data);
    }

    public function register(): Response
    {
        $formData = $this->app->getRequest()->getPost();
        if (isset($formData['submit'])) {
            $name = strip_tags($formData['name']);
            $email = strip_tags($formData['email']);
            $pass = strip_tags($formData['password']);
            $cpass = strip_tags($formData['confirmPassword']);
    
            if (strcmp($name, $formData['name']) !== 0) {
                $data = (['message' => 'Meno obsahuje nepovolené znaky!']);
                return $this->html($data);
            }
            if (strcmp($email, $formData['email']) !== 0) {
                $data = (['message' => 'Email obsahuje nepovolené znaky!']);
                return $this->html($data);
            }
            if (strcmp($pass, $formData['password']) !== 0) {
                $data = (['message' => 'Heslo obsahuje nepovolené znaky!']);
                return $this->html($data);
            }
            if (strcmp($cpass, $formData['confirmPassword']) !== 0) {
                $data = (['message' => 'Heslo obsahuje nepovolené znaky!']);
                return $this->html($data);
            }
            if (strcmp($pass, $cpass) !== 0) {
                $data = (['message' => 'Heslá sa nezhodujú']);
                return $this->html($data);
            }
            if (strlen($pass) < 8) {
                $data = (['message' => 'Heslo by malo mať aspoň 8 znakov']);
                return $this->html($data);
            }

            $atPos = -1;
            $atCount = 0;
            $counter = 0;
            foreach (mb_str_split($email) as $char) {
                if (strcmp($char, '@') === 0) {
                    $atCount++;
                    $atPos = $counter;
                }
                $counter++;
            }
            if ($atCount !== 1 || $atPos === 0 || $atPos === (strlen($email) - 1)) {
                $data = (['message' => 'E-mail je neplatný']);
                return $this->html($data);
            }

            foreach (User::getAll('`email` = ?', [$email]) as $user) {
                $data = (['message' => 'Tento e-mail už je registrovaný']);
                return $this->html($data);
            }

            $registered = new User();
            $registered->setName($name);
            $registered->setEmail($email);
            $registered->setPass(password_hash($pass, PASSWORD_DEFAULT));
            $registered->setRole('customer');
            $registered->save();
            
            $data = (['message' => 'Registrácia úspešná']);
            return $this->html($data);
        }
        $data = ([]);
        return $this->html($data);
    }

    /**
     * Logout a user
     * @return ViewResponse
     */
    public function logout(): Response
    {
        $this->app->getAuth()->logout();
        return $this->redirect($this->url("home.index"));
    }
}
