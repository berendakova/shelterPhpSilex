<?php

namespace App;

use Entity\Pet;
use PDO;
use PDOException;
use Utility\ConnectionToDB;

class PetController
{
    public function addPet(Pet $pet)
    {
        $connection = new ConnectionToDB();
        try {
            $con = $connection->connectionDB();

            $sql = "INSERT INTO pets (name,description,age,img,status,sex,breed,disease,user_id) VALUES (?,?,?,?,?,?,?,?,?)";

            $query = $con->prepare($sql);
            $query->execute(array(
                $pet->getPetName(),
                $pet->getDescription(),
                $pet->getAge(),
                $pet->getImg(),
                $pet->getStatus(),
                $pet->getSex(),
                $pet->getBreed(),
                $pet->getDisease(),
                0
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function updatePetStatus($pet_id, $status)
    {
        $connection = new ConnectionToDB();
        try {
            $con = $connection->connectionDB();
            $sql = "UPDATE pets SET status = ? where id_pet = ?";
            $query = $con->prepare($sql);
            $query->execute(array(
                $status,
                $pet_id
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function getPetById($idPet)
    {
        $connection = new ConnectionToDB();
        $pet = null;
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT * FROM pets WHERE id_pet = :petId");
            $sth->execute(array(
                ':petId' => $idPet
            ));
            $pet = $sth->fetch(PDO::FETCH_ASSOC);
            return $pet;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function getAllPet()
    {

        $connection = new ConnectionToDB();
        $pets = array();

        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT * FROM pets");
            $sth->execute();
            $pets = $sth->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
        return $pets;
    }

    public function setPetUser($id_pet, $id_user)
    {

        $connection = new ConnectionToDB();
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("  update pets set user_id=:userId where id_pet = :petId");
            $sth->execute(array(
                ':userId' => $id_user,
                ':petId' => $id_pet
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

    }

    public function deletePet(string $petId)
    {
        $connection = new ConnectionToDB();
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("delete from pets where id_pet = :idPet");
            $sth->execute(array(
                ':idPet' => $petId
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

    }

    public function updatePet(Pet $pet)
    {

        $connection = new ConnectionToDB();
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("update pet set name = :namePet, description = :description, age = :age , img = :img, sex = :sex, breed = :breed , disease = :dis where id = :idPet");
            $sth->execute(array(
                'namePet' => $pet->getPetName(),
                ':description' => $pet->getDescription(),
                ':age' => $pet->getAge(),
                ':img' => $pet->getImg(),
                ':sex' => $pet->getSex(),
                ':breed' => $pet->getBreed(),
                ':dis' => $pet->getDisease(),
                ':idPet' => $pet->getIdPet()
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }

    }

    public function getPetByUserId($id)
    {
        $connection = new ConnectionToDB();
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT * from pets where user_id = :idU");
            $sth->execute(array(
                ':idU' => $id
            ));
            $pets = null;
            $pets = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
        return $pets;
    }

    public function hello()
    {
        return 'hello';
    }


}