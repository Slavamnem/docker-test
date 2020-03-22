<?php
/**
 * Created by PhpStorm.
 * User: slava
 * Date: 22.03.20
 * Time: 15:12
 */

final class Password
{
    private $password;

    public function __construct($password)
    {
        $this->setPassword($password);
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Password
     */
    public function setPassword($password): Password
    {
        if (strlen($password) < 5) {
            throw new \http\Exception\InvalidArgumentException('ups too short');
        }

        $this->password = $password;

        return $this;
    }

    /**
     * @param Password $password
     * @return bool
     */
    public function isEqual(Password $password)
    {
        return $this->getPassword() == $password->getPassword();
    }
}

class P //extends Currency
{
    public function show()
    {
        //echo $this->a;
    }
}