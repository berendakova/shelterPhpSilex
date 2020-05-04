<?php

namespace Utility;
use PDO;
use PDOException;

class ConnectionToDB
{
    function connectionDB(): ?PDO
    {
        try {
            $dbh = new PDO('mysql:dbname=shelter;host=localhost', 'root', 'password');
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $dbh;
    }
}