<?php
require_once "Database.php";

class Author {
    private $id;
    private $publisherId;
    private $name;

    function __construct($id, $publisherId, $name) {
        $this->id = $id;
        $this->publisherId = $publisherId;
        $this->name = $name;
    }

    static function getById($primaryKey) {
        $sql = <<< SQL
            SELECT * FROM `author` WHERE id = $primaryKey;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $row = $statement->get_result()->fetch_assoc();

        return Author::toObject($row);
    }

    function insert() {
        $conn = Database::getConnection();

        // Check whether the user exists or not, if yes return the author's ID
        $selectSql = "SELECT * FROM author WHERE displayName = '$this->name';";
        $selectStmt = $conn->prepare($selectSql);
        $selectStmt->execute();
        if ($selectStmt->num_rows() > 0) {
            $row = $selectStmt->get_result()->fetch_assoc();
            return $row['id'];
        }

        // We have to close first prepared statement before executing the second one.
        $selectStmt->close();

        // Insert a new one and return its newly inserted ID
        $insertSql = "INSERT INTO `author` (`id`, `publisher_id`, `displayName`) VALUES ('$this->id', '$this->publisherId', '$this->name');";
        $statement = $conn->prepare($insertSql);
        $statement->execute();
        $insertId = $statement->insert_id;
        return $insertId;
    }

    private static function toObject($row) {
        return new Author(
            $row['id'],
            $row['publisher_id'],
            $row['displayName']
        );
    }

    function getName() { return $this->name; }
}

