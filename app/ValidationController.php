<?php


namespace App;


use Entity\User;

class ValidationController
{
    public function isSamePasswords($password1, $password2)
    {
        if ($password2 === $password1) {
            return true;
        }

        return false;
    }

    public function isExistingUser($email)
    {
        $userController = new UserController();

        $user = $userController->getUserByEmailCheck($email);

        return $user;
    }

    public function isCorrectPasswordForCorrectEmail($email, $password1)
    {
        $userController = new UserController();
        $user = $userController->getUserByEmail($email);
        $password = $user['password'];

        if (!($this->isExistingUser($user))) {
            if (md5($password1) === $password) {
                return true;
            }
        }
            return false;
        }

}