<?php


namespace App;

use Entity\User;
use PDO;
use PDOException;
use Utility\ConnectionToDB;

class UserController
{

    public function list()
    {

    }

    public function register(User $user)
    {
        $connection = new ConnectionToDB();
        try {
            $con = $connection->connectionDB();

            $sql = "INSERT INTO users (name, email,password) VALUES (?, ?, ?)";

            $query = $con->prepare($sql);
            $query->execute(array(
                $user->getName(),
                $user->getEmail(),
                md5($user->getPassword())
            ));
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function getUserById($id_user)
    {

        $connection = new ConnectionToDB();
        $user = null;
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT * FROM users WHERE id = :idUser");
            $sth->execute(array(
                ':idUser' => $id_user
            ));
            $user = $sth->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
    }

    public function getUserByEmailCheck($email)
    {
        $connection = new ConnectionToDB();
        $user = null;
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT 1 FROM users WHERE email = :emailUser");
            $sth->execute(array(
                ':emailUser' => $email
            ));
            $user = $sth->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }
        return $user;
    }

    public function getUserByEmail($email)
    {
        $connection = new ConnectionToDB();
        $user = null;
        try {
            $dbh = $connection->connectionDB();
            $sth = $dbh->prepare("SELECT * FROM users WHERE email = :emailUser");
            $sth->execute(array(
                ':emailUser' => $email
            ));
            $user = $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
        }


        return $user;
    }
}