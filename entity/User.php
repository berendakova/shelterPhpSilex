<?php

namespace Entity;
class User
{
    private $id_user;
    private $name;
    private $email;
    private $password;
    private $is_superuser;

    /**
     * User constructor.
     * @param $id_user
     * @param $name
     * @param $email
     * @param $password
     * @param $is_superuser
     */
    public function __construct( $name, $email, $password )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }


    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user): void
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getIsSuperuser()
    {
        return $this->is_superuser;
    }

    /**
     * @param mixed $is_superuser
     */
    public function setIsSuperuser($is_superuser): void
    {
        $this->is_superuser = $is_superuser;
    }

}