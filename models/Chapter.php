<?php
require_once "Database.php";

class Chapter implements JsonSerializable {
    private $id;
    private $mangaId;
    private $title;
    private $dateUploaded;
    private $totalPageNumber;
    private $price;
    private $chapterNumber;

    const INSUFFICIENT_BALANCE = "insufficient_balance";
    const PURCHASE_FAILED = "purchase_failed";
    const PURCHASE_SUCCESS = "purchase_success";

    function __construct($id, $mangaId, $title, $dateUploaded, $totalPageNumber, $price, $chapterNumber) {
        $this->id = $id;
        $this->mangaId = $mangaId;
        $this->title = $title;
        $this->dateUploaded = $dateUploaded;
        $this->totalPageNumber = $totalPageNumber;
        $this->price = $price;
        $this->chapterNumber = $chapterNumber;
    }

    // https://stackoverflow.com/questions/9683687/json-encode-is-not-working-with-array-of-objects
    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    function insert() {
        $conn = Database::getConnection();
        $sql = <<< SQL
        
        INSERT INTO `chapter` (`id`, `manga_id`, `title`, `date_uploaded`, `total_pagenumber`, `price`, `chapter_number`) 
        VALUES ('$this->id', '$this->mangaId', '$this->title', '$this->dateUploaded', '$this->totalPageNumber', '$this->price', '$this->chapterNumber');
        
        SQL;
    
        $statement = $conn->prepare($sql);
        $statement->execute();

        return $statement->insert_id;
    }

    static function getById($chapterId) {
        $sql = "SELECT * FROM `chapter` WHERE `id` = $chapterId";
        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        $chapter = Chapter::toObject($row);

        return $chapter;
    }

    static function getAllChapters($mangaId) {
        $sql = <<< SQL
            SELECT * FROM `chapter` WHERE `manga_id` = $mangaId;
        SQL; 

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();
        
        $chapterList = array();

        while ($row = $result->fetch_assoc()) {
            $chapter = Chapter::toObject($row);
            array_push($chapterList, $chapter);
        }
        return $chapterList;
    }

    static function getLatestChapter($mangaId) {
        $sql = "SELECT * FROM `chapter` WHERE `manga_id` = $mangaId ORDER BY `chapter_number` DESC LIMIT 1";
        $statement = Database::getConnection()->prepare($sql);
        
        $statement->execute();      

        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        $latestChapter = Chapter::toObject($row);

        return $latestChapter;
    }

    static function editName($chapterId, $newName) {
        $sql = <<< SQL
            UPDATE `chapter`
            SET `title` = '$newName' 
            WHERE `id` = $chapterId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $status = $statement->execute();
        return $status;
    }

    static function editPrice($chapterId, $newPrice) {
        $sql = <<< SQL
            UPDATE `chapter`
            SET `price` = $newPrice 
            WHERE `id` = $chapterId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $status = $statement->execute();
        return $status;
    }

    static function checkChapterAvailability($chapterId, $userId) {
        $conn = Database::getConnection();
        $chapter = Chapter::getById($chapterId);

        if ($chapter->getPrice() <= 0) {
            return true;
        }

        $purchaseQuery = <<< SQL
            SELECT * FROM `chapter_purchased` 
            WHERE `user_id` = ? AND `chapter_id` = ?
        SQL;
        $purchaseStmt = $conn->prepare($purchaseQuery);
        $purchaseStmt->bind_param("ii", $userId, $chapterId);
        $purchaseStmt->execute();

        $purchaseResult = $purchaseStmt->get_result();

        $userHasPurchased = ($purchaseResult->num_rows) > 0;

        return $userHasPurchased;
    }

    static function purchaseChapter($chapterId, $userId) {
        $conn = Database::getConnection();

        $chapter = Chapter::getById($chapterId);

        $chapterPrice = $chapter->getPrice();

        // Begin transaction for purchasing chapter
        try {
            $conn->begin_transaction();

            $payQuery = <<< SQL
                UPDATE `users` 
                SET `topup_balance` = `topup_balance` - ?
                WHERE `id` = ? AND `topup_balance` >= ?    
            SQL;
    
            $payStmt = $conn->prepare($payQuery);
            $payStmt->bind_param("did", $chapterPrice, $userId, $chapterPrice);
            $payStmt->execute();
    
            // User does not have enough money to purchase
            if ($payStmt->affected_rows <= 0) {
                $conn->commit();
                return self::INSUFFICIENT_BALANCE;
            }
    
            // Inserts purchase history into user's account
            $insertQuery = <<< SQL
                INSERT INTO `chapter_purchased`(`id`, `user_id`, `chapter_id`, `datetime_purchased`) 
                VALUES ('NULL', ?, ?, ?)
            SQL;
            $insertStmt = $conn->prepare($insertQuery);

            $datetimeNow = date("Y-m-d H:i:s");
            $insertStmt->bind_param("iis", $userId, $chapterId, $datetimeNow);
            $insertStmt->execute();

            $conn->commit();
            return self::PURCHASE_SUCCESS;

        } catch (Exception $e) {
            $conn->rollback();
            return self::PURCHASE_FAILED;
        }

    }

    private static function toObject($row) {
        return new Chapter(
            $row["id"],
            $row["manga_id"],
            $row["title"],
            $row["date_uploaded"],
            $row["total_pagenumber"],
            $row["price"],
            $row["chapter_number"]
        );
    }

    public function getId() {return $this->id;}
	public function getMangaId() {return $this->mangaId;}
	public function getTitle() {return $this->title;}
	public function getDateUploaded() {return $this->dateUploaded;}
	public function getTotalPageNumber() {return $this->totalPageNumber;}
    public function getPrice() {return $this->price;}
    public function getChapterNumber() {return $this->chapterNumber;}

    function getLink() {
        return "comicreader.php?id=" . $this->getId();
    }

}
