<?php

namespace Entity;
class Pet
{
    private $id_pet;
    private $name;
    private $sex;
    private $description;
    private $age;
    private $img;
    private $breed;
    private $disease;

    /**
     * Pet constructor.
     * @param $id_pet
     * @param $name
     * @param $sex
     * @param $description
     * @param $age
     * @param $img
     * @param $breed
     * @param $disease
     */
    public function __construct($name, $sex,$status, $description, $age, $img, $breed, $disease)
    {
        $this->name = $name;
        $this->sex = $sex;
        $this->status = $status;
        $this->description = $description;
        $this->age = $age;
        $this->img = $img;
        $this->breed = $breed;
        $this->disease = $disease;
    }


    /**
     * @return mixed
     */
    public function getIdPet()
    {
        return $this->id_pet;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @param mixed $id_pet
     */
    public function setIdPet($id_pet): void
    {
        $this->id_pet = $id_pet;
    }

    /**
     * @return mixed
     */
    public function getPetName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setPetName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * @param mixed $breed
     */
    public function setBreed($breed): void
    {
        $this->breed = $breed;
    }

    /**
     * @return mixed
     */
    public function getDisease()
    {
        return $this->disease;
    }

    /**
     * @param mixed $disease
     */
    public function setDisease($disease): void
    {
        $this->disease = $disease;
    }

}