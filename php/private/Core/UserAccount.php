<?php

namespace Webshop\Core;

use \Webshop\Model\User;

class UserAccount
{

    private $logedIn = false;

    private $userInfo;

    /**
     * UserAccount constructor.
     */
    public function __construct()
    {
        if(array_key_exists('user', $_SESSION)){
            $this->logedIn = true;
            $user = new \Webshop\Model\User();
            $this->setUserInfo($user->getOne('emailadres', $_SESSION['user']));

        }
    }

    /**
     * @return bool
     */
    public function isLogedIn()
    {
        return $this->logedIn;
    }

    /**
     * @param bool $logedIn
     */
    public function setLogedIn($logedIn)
    {
        $this->logedIn = $logedIn;
    }

    /**
     * @return mixed
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @param mixed $userInfo
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;
    }

}
