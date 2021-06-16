<?php

include __DIR__ . '\..\config\conf.php';

class ConnectionBDD
{
    private static $instance;

    public static function getInstance()
    {

        if(empty(self::$instance))
        {

            try {
                self::$instance = new PDO('mysql:host=localhost;dbname=novella', 'root', '5up3rM0tD3p4ss3');
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');

            } catch(PDOException $error) {
                echo $error->getMessage();
            }

        }

        return self::$instance;
    }
}

?>