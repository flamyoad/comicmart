<?php

require_once "Database.php";

class Rating {

    static function setRating($userId, $mangaId, $rating) {
        $conn = Database::getConnection();

        $selectQuery = <<< SQL
            SELECT * 
            FROM `rating` 
            WHERE `user_id` = $userId AND `manga_id` = $mangaId; 
        SQL;

        $statement = $conn->prepare($selectQuery);
        $statement->execute();

        $selectResult = $statement->get_result();

        $ratingQuery = "";

        // Update values if row already exists
        if ($selectResult->num_rows > 0) {
            $ratingQuery = <<< SQL
                UPDATE `rating` 
                SET `rated_stars`= $rating 
                WHERE `manga_id` = $mangaId AND `user_id` = $userId;
            SQL;
        } 

        // Otherwise insert new row
        else {
            $ratingQuery = <<< SQL
                INSERT INTO `rating`(`id`, `manga_id`, `user_id`, `rated_stars`) 
                VALUES (NULL, $mangaId, $userId , $rating);
            SQL;
        }

        $statement = $conn->prepare($ratingQuery);
        $statement->execute();
    }

    static function getRating($mangaId) {
        // We need to cast it to one decimal points. Otherwise it becomes like 3.5000 instead of 3.5
        $sql = <<< SQL
            SELECT CAST(AVG(`rated_stars`) AS DECIMAL(10,1)) AS averageRating
            FROM `rating`
            WHERE `manga_id` = $mangaId
        SQL; 

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result =  $statement->get_result();
        $row = $result->fetch_assoc();

        return $row['averageRating'];
    }
}