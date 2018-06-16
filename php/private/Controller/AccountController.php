<?php
namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class AccountController extends Controller
{

    private $loginError = "loginError";
    private $loginForm = "loginForm";
    private $registerError = "registerError";
    private $registerForm = "registerForm";
    private $userSession = "user";
    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Account";
        $this->registry->template->description = "Account pagina";
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->loginSend = Util::checkExcistInSession($this->loginError);
        $this->registry->template->registerSend = Util::checkExcistInSession($this->registerError);
        $this->registry->template->show('account');
    }

    function login()
    {
        if (isset($_POST['loginSubmit'])) {
            // Unset previous values
            unset($_SESSION[$this->loginError]);
            unset($_SESSION[$this->loginForm]);

            $user = new \Webshop\Model\User();

            $form = $_POST['login'];
            $emailadres = $form['emailadres'];
            $password = $form['password'];

            $loggedInUser = $user->getOne('emailadres', $emailadres);
            if (is_object($loggedInUser)) {
                $password = password_verify($password, $loggedInUser->password);
                if ($password) {
                    $_SESSION[$this->userSession] = $loggedInUser;
                    header('Location: /');
                    die();
                }
            }

            // Save errors in a session
            $_SESSION[$this->loginForm] = $form;
            Util::redirectWithError('/account', $this->loginError, "Your email or password is incorrect");
        }
    }

    function register()
    {
        if (isset($_POST['registerSubmit'])) {
            // Unset previous values
            unset($_SESSION[$this->registerError]);
            unset($_SESSION[$this->registerForm]);

            $user = new \Webshop\Model\User();

            $errorCatched = false;

            $form = $_POST['register'];
            $emailadres = (string)$form['emailadres'];
            $passwordFirst = (string)$form['passwordFirst'];
            $passwordSecond = (string)$form['passwordSecond'];
            $firstName = (string)$form['firstName'];
            $lastName = (string)$form['lastName'];
            $dayOfBirth = \DateTime::createFromFormat('Y-m-d', $form['dayOfBirth']);
            $sex = (string)$form['sex'];

            foreach ($form as $name => $value) {
                if (empty($value)) {
                    $_SESSION[$this->registerError]['blank'] = 'Some Fields were left blank. Please fill up all fields.';
                    $errorCatched = true;
                }
            }

            switch (true) {
                case !filter_var($emailadres, FILTER_VALIDATE_EMAIL):
                    $_SESSION[$this->registerError]['email'] = 'The emailadres you gave is not valid.';
                    $errorCatched = true;
                    break;
                case ($passwordFirst != $passwordSecond):
                    $_SESSION[$this->registerError]['password'] = 'The Passwords you entered didn\'t match';
                    $errorCatched = true;
                    break;
                case !is_bool($user->getOne('emailadres', $emailadres)):
                    $_SESSION[$this->registerError]['registered'] = 'This email is already registred';
                    $errorCatched = true;
                    break;
            }

            if (!$errorCatched) {
                $user = new \Webshop\Model\User();

                $user->emailadres = $emailadres;
                $user->password = $passwordFirst;
                $user->firstName = $firstName;
                $user->lastName = $lastName;
                $user->dayOfBirth = $dayOfBirth;
                $user->sex = $sex;
                var_dump($emailadres);
                var_dump($user);
                $user->save();

//                header('Location: /');
            } else {
                // There are errors, so redirect back to the account page and save the errors in a session
                $_SESSION[$this->registerForm] = $form;
                header('Location: /account');
            }
        }
    }

    function logout(){
        unset($_SESSION[$this->userSession]);
        unset($_SESSION[$this->registerError]);
        unset($_SESSION[$this->registerForm]);
        unset($_SESSION[$this->loginError]);
        unset($_SESSION[$this->loginForm]);
        $this->registry->template->title = "Account";
        $this->registry->template->description = "Account pagina";
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->show('logout');
    }
}
