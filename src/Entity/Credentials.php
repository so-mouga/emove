<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */

namespace App\Entity;


class Credentials
{
    protected $login;

    protected  $password;

    /**
     * @return
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword( $password)
    {
        $this->password = $password;

        return $this;
    }

}
