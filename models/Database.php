<?php

class Database
{
    private const DB_SERVER = "localhost";
    private const DB_USERNAME = "root";
    private const DB_PASSWORD = "";
    private const DB_NAME = "comicmart";

    private static $connection;

    static function getConnection()
    {
        // Creates a connection object if not yet created
        if (is_null(self::$connection)) {
            self::$connection = new mysqli(
                Database::DB_SERVER,
                Database::DB_USERNAME,
                Database::DB_PASSWORD,
                Database::DB_NAME
            );

            // If database connection can't be established... throw an exception
            if (mysqli_connect_errno()) {
                throw new RuntimeException("Connection failed: %s\n", mysqli_connect_error());
            }
        }

        return self::$connection;
    }

}
