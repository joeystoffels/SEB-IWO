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
        // Check if there errors from the forms, and display them.
        $this->registry->template->loginSend = Util::checkExcistInSession($this->loginError);
        $this->registry->template->registerSend = Util::checkExcistInSession($this->registerError);

        if($this->registry->userAccount->isLogedIn()){
            $this->registry->template->show('account-loggedin');
        } else {
            $this->registry->template->show('account');
        }
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
                    $_SESSION[$this->userSession] = $emailadres;
                    header('Location: /');
                    die();
                }
            }

            // Save errors in a session
            $_SESSION[$this->loginForm] = $form;
            Util::redirectWithError('/account', $this->loginError, "Uw email of wachtwoord is incorrect");
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
            $dayOfBirth = (string) $form['dayOfBirth'];
            $sex = (string)$form['sex'];

            foreach ($form as $name => $value) {
                if (empty($value)) {
                    $_SESSION[$this->registerError]['blank'] = 'Some Fields were left blank. Please fill up all fields.';
                    $errorCatched = true;
                }
            }

            switch (true) {
                case !filter_var($emailadres, FILTER_VALIDATE_EMAIL):
                    $_SESSION[$this->registerError]['email'] = 'Ongeldig emailadres';
                    $errorCatched = true;
                    break;
                case ($passwordFirst != $passwordSecond):
                    $_SESSION[$this->registerError]['password'] = 'De opgegeven wachtwoorden kwamen niet overeen';
                    $errorCatched = true;
                    break;
                case !is_bool($user->getOne('emailadres', $emailadres)):
                    $_SESSION[$this->registerError]['registered'] = 'Er bestaat al een account met dit emailadres';
                    $errorCatched = true;
                    break;
                case !isset($form['accept']):
                    $_SESSION[$this->registerError]['accept'] = 'Je moet de algemene voorwaarden accepteren om een account ';
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
                $user->save();

                // Save user in session
                $_SESSION[$this->userSession] = $emailadres;
                header('Location: /');
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
