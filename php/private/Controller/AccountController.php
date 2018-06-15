<?php
/**
 * Created by PhpStorm.
 * User: NickHartjes
 * Date: 09/06/2018
 * Time: 10:37
 */

namespace Webshop\Controller;


use Webshop\Core\Controller;

class AccountController extends Controller
{

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";
        $this->registry->template->show('account');
    }

    function login()
    {
        if (isset($_POST['login'])) {
            var_dump($_POST);
            $formulier = $_POST['inloggen'];
            $email = $formulier['emailadres'];
            $password = $formulier['password'];
            var_dump($email, $password);
        }
    }

    function register()
    {
        if (isset($_POST['verzenden'])) {

            var_dump($_POST);
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['pass'];
            $retyped_password = $_POST['retyped_password'];
            $name = $_POST['name'];
            if ($username == '' || $email == '' || $password == '' || $retyped_password == '' || $name == '') {
                echo '<h2>Fields Left Blank</h2>', '<p>Some Fields were left blank. Please fill up all fields.</p>';
            } elseif (!$LS->validEmail($email)) {
                echo '<h2>E-Mail Is Not Valid</h2>', '<p>The E-Mail you gave is not valid</p>';
            } elseif (!ctype_alnum($username)) {
                echo '<h2>Invalid Username</h2>', "<p>The Username is not valid. Only ALPHANUMERIC characters are allowed and shouldn't exceed 10 characters.</p>";
            } elseif ($password != $retyped_password) {
                echo "<h2>Passwords Don't Match</h2>", "<p>The Passwords you entered didn't match</p>";
            } else {
                $createAccount = $LS->register($username, $password,
                    array(
                        'email' => $email,
                        'name' => $name,
                        'created' => date('Y-m-d H:i:s'), // Just for testing
                    )
                );
                if ($createAccount === 'exists') {
                    echo '<label>User Exists.</label>';
                } elseif ($createAccount === true) {
                    echo "<label>Success. Created account. <a href='login.php'>Log In</a></label>";
                }
            }
        }
    }
}
