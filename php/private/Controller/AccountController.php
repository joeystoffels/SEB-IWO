<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:37
 */

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;
use Webshop\Model\User;

class AccountController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->cartItems = Util::getNrCartItems();
        $this->registry->template->show('account');
    }

    function login()
    {
        if (isset($_POST['loginSubmit'])) {
            $user = new \Webshop\Model\User();

            $formulier      = $_POST['login'];
            $emailadres     = $formulier['emailadres'];
            $password       = $formulier['password'];

            $loggedInUser = $user->getOne('emailadres', $emailadres);
            if(is_object($loggedInUser)){
                $password =  password_verify($password, $loggedInUser->password);
                if($password) {
                    $_SESSION['user'] = $loggedInUser;
                }else {
                    $_SESSION['loginFormError'] = "Your email or password is incorrect";
                }
            } else {
                $_SESSION['loginFormError'] = "Your email or password is incorrect";
            }
            var_dump($_SESSION);
        }
    }

    function register()
    {
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
        if (isset($_POST['registerSubmit'])) {
            $user = new \Webshop\Model\User();


            $errorCatched = false;

            $form           = $_POST['register'];
            $emailadres     = (string) $form['emailadres'];
            $passwordFirst  = (string) $form['passwordFirst'];
            $passwordSecond = (string) $form['passwordSecond'];
            $firstName      = (string) $form['firstName'];
            $lastName       = (string) $form['lastName'];
            $dayOfBirth     = \DateTime::createFromFormat('Y-m-d', $form['dayOfBirth']); //date('Y-m-d', $form['dayOfBirth']);
            $sex            = (string) $form['sex'];

            foreach ($form as $name => $value){
                if(empty($value)){
                    $_SESSION['registerFormError']['blank'] = '<p>Some Fields were left blank. Please fill up all fields.</p>';
                    $errorCatched = true;
                }
            }

            switch (true){
                case !filter_var($emailadres, FILTER_VALIDATE_EMAIL):
                    $_SESSION['registerFormError']['email'] = '<p>The emailadres you gave is not valid.</p>';
                    $errorCatched = true;
                    break;
                case ($passwordFirst != $passwordSecond):
                    $_SESSION['registerFormError']['password'] = '<p>The Passwords you entered didn\'t match</p>';
                    $errorCatched = true;
                    break;
                case !is_bool($user->getOne('emailadres', $emailadres)):
                    $_SESSION['registerFormError']['registered'] = '<p>This email is already registred</p>';
                    $errorCatched = true;
                    break;
            }

            if(!$errorCatched){
                $user = new \Webshop\Model\User();

                $user->emailadres   = $emailadres;
                $user->password     = $passwordFirst;
                $user->firstName    = $firstName;
                $user->lastName     = $lastName;
                $user->dayOfBirth   = $dayOfBirth;
                $user->sex          = $sex;
                var_dump($emailadres);
                var_dump($user);
                $user->save();
            }
        }
    }
}
