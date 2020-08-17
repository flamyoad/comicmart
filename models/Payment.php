<?php
require_once "Database.php";

class Payment implements JsonSerializable{

    private $id;
    private $userId;
    private $amount;
    private $datetime;

    function __construct($id, $userId, $amount, $datetime) {
        $this->id = $id;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->datetime = $datetime;
    }

    function jsonSerialize() {
        return get_object_vars($this);
    }

    static function addTopup($userId, $amount) {

        // FOR SOME REASON ROLLBACK DOESN'T WORK?? TO TEST IT, MODIFY THE SECOND QUERY TO HAVE SYNTAX ERROR
        // THE FIRST QUEYR IS STILL COMMITTED??
        $conn = Database::getConnection();

        // We will need to wrap our queries inside a TRY / CATCH block.
        // That way, we can rollback the transaction if a query fails and an exception occurs
        try {

            // Query 1: Attempt to update the user's profile.
            $sql = <<< SQL
                UPDATE `users`
                SET `topup_balance` = `topup_balance` + ?
                WHERE `id` = ?;
            SQL;
        
            $statement = $conn->prepare($sql);        
            $statement->bind_param("ii", $amount, $userId);
            $statement->execute();

            $currentDateTime = date("Y-m-d H:i:s");

            // Query 2: Attempt to insert the payment record into our database.
            $sql2 = <<< SQL
                INSERT INTO `topup_history`(`id`, `user_id`, `amount`, `datetime`) 
                VALUES ('NULL', ?, ?, '$currentDateTime');
            SQL;

            $statement2 = $conn->prepare($sql2);
            $statement2->bind_param("ii", $userId, $amount);
            $statement2->execute();

            $conn->commit();
        } 

        catch (Exception $e) {
            echo $e->getMessage();
            $conn->rollback();
        }
    }

    function getTopupHistory($userId) {
        $sql = <<< SQL
            SELECT * FROM `topup_history` 
            WHERE `user_id` = ?
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $paramType = "i";

        $statement->bind_param($paramType, $userId);
        $statement->execute();
        $result = $statement->get_result();

        $topupList = array();
        while ($row = $result->fetch_assoc()) {
            array_push($topupList, Payment::toObject($row));
        }

        return $topupList;
    }

    static function toObject($row) {
        return new Payment(
            $row["id"],
            $row["user_id"],
            $row["amount"],
            $row["datetime"]
        );
    }
}

