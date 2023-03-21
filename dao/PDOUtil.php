<?php

namespace dao;

use PDO;

class PDOUtil
{
    public static function createMySQLConnection(): PDO
    {
        $link = new PDO('mysql:host=localhost;dbname=pwl2022', 'root', '');
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        return $link;
    }
}