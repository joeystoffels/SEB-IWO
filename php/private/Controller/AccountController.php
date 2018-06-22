<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

/**
 * Controller for the accounts
 * It  processes all login, logout en register forms
 *
 * Class AccountController
 * @package Webshop\Controller
 */
class AccountController extends Controller
{

    /**
     * @var string $loginError Name of the loginError value
     */
    private $loginError = "loginError";

    /**
     * @var string $loginForm Name of the loginForm value
     */
    private $loginForm = "loginForm";

    /**
     * @var string $registerError Name of the registerError value
     */
    private $registerError = "registerError";

    /**
     * @var string $registerForm Name of the registerForm value
     */
    private $registerForm = "registerForm";

    /**
     * @var string $user Name of the Usersession value
     */
    private $userSession = "user";

    /**
     * AccountController constructor.
     */
    function __construct()
    {
        // Call parent constructor
        parent::__construct();

        // Set title and description of the page
        $this->registry->template->title = "Account";
        $this->registry->template->description = "Account pagina";
    }

    /**
     * Index and fallback function for the AccountController
     */
    function index()
    {
        // Check if there errors from the forms, and display them.
        $this->registry->template->loginSend = Util::checkExcistInSession($this->loginError);
        $this->registry->template->registerSend = Util::checkExcistInSession($this->registerError);

        // If the user is loggedIn show the logout button
        if ($this->registry->userAccount->isLogedIn()) {
            $this->registry->template->show('account-loggedin');
        } else {
            $this->registry->template->show('account');
        }
    }

    /**
     * Login processing function
     */
    function login()
    {
        // Only process the login form if the login is submitted
        if (isset($_POST['loginSubmit'])) {

            // Unset previous values
            unset($_SESSION[$this->loginError]);
            unset($_SESSION[$this->loginForm]);

            // Create a new user object
            $user = new \Webshop\Model\User();


            $form = $_POST['login'];
            $emailadres = $form['emailadres'];
            $password = $form['password'];

            // Load the user with the given emailadres
            $loggedInUser = $user->getOne('emailadres', $emailadres);
            if (is_object($loggedInUser)) {

                // Verify the user password with the database password
                $password = password_verify($password, $loggedInUser->password);
                if ($password) {
                    // Set the user session
                    $_SESSION[$this->userSession] = $emailadres;

                    // Redirect to the main page
                    header('Location: /');
                    die();
                }
            }

            // Save errors in a session
            $_SESSION[$this->loginForm] = $form;
            Util::redirectWithError('/account', $this->loginError, "Uw email of wachtwoord is incorrect");
        }
    }

    /**
     * Register processing function
     */
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
            $dayOfBirth = (string)$form['dayOfBirth'];
            $sex = (string)$form['sex'];

            foreach ($form as $value) {
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
                default:
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


    /**
     * Account logout function
     */
    function logout()
    {
        // Unset all form, error and user sessions
        unset($_SESSION[$this->userSession]);
        unset($_SESSION[$this->registerError]);
        unset($_SESSION[$this->registerForm]);
        unset($_SESSION[$this->loginError]);
        unset($_SESSION[$this->loginForm]);

        // TODO REMOVE
        session_destroy();

        // Show the logout page
        $this->registry->template->show('logout');
    }
}
