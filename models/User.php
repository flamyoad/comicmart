<?php
require_once "Database.php";

class User implements JsonSerializable {
    private $id;
    private $email;
    private $password;
    private $displayName;
    private $gender;
    private $topup_balance;

    // Constructor
    function __construct($id, $email, $password, $displayName, $gender, $topup_balance) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->displayName = $displayName;
        $this->gender = $gender;
        $this->topup_balance = $topup_balance;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    function insert() {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = <<< SQL
        INSERT INTO `users`(`id`, `email`, `password`, `display_name`, `gender`, `topup_balance`)
        VALUES ('$this->id', '$this->email', '$hashed_password', '$this->displayName', '$this->gender', '$this->topup_balance')
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $status = $statement->execute();
        $insertId = $statement->insert_id;

        return $insertId;
    }

    static function isEmailUsed($email) {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $statement = $conn->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();
        $rows = $result->num_rows;
        var_dump($rows);
        if ($rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    static function verifyLogin($email, $password) {
        $conn = Database::getConnection();
        $escaped_email = $conn->real_escape_string($email);
        $escaped_password = $conn->real_escape_string($password);
        $hashed_password_fromUser = password_hash($escaped_password, PASSWORD_DEFAULT);

        // If result matched $email and $password, table row must be 1 row
        $sql = "SELECT password FROM users WHERE email = '$escaped_email'";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        // If 0 row is returned from DB, means that the email is not registered yet
        if ($result->num_rows === 0) {
            echo 'Email does not exist';
            return 0;
        }

        $row = $result->fetch_assoc();
        $existingHashFromDb = $row['password'];

        // Check if the hash of the entered login password, matches the stored hash.
        // The salt and the cost factor will be extracted from $existingHashFromDb.
        $isPasswordCorrect = password_verify($escaped_password, $existingHashFromDb);

        return $isPasswordCorrect;
    }

    static function getById($id) {
        $sql = <<< SQL
            SELECT * FROM `users`
            WHERE `id` = ?
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->bind_param("i", $id);

        $statement->execute();
        $result = $statement->get_result();
        $row = $result ->fetch_assoc();

        return User::toObject($row);
    }

    static function getByEmail($email) {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();

        return User::toObject($row);
    }

    private static function toObject($row) {
        $user = new User(
            $row['id'],
            $row['email'],
            $row['password'],
            $row['display_name'],
            $row['gender'],
            $row['topup_balance']
        );

        return $user;
    }

    // Getters
    function getId() { return $this->id; }
    function getEmail() { return $this->email; }
    function getPassword() { return $this->password; }
    function getDisplayName() { return $this->displayName; }
    function getGender() { return $this->gender; }
    function getTopupBalance() { return $this->topup_balance; }



}
