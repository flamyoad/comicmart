<?php
require_once "Database.php";
require_once "Chapter.php";
require_once "ReadHistory.php";

class Bookmark implements JsonSerializable{

    private $id;
    private $mangaId;
    private $title;
    private $coverImage;
    private $readChapter;
    private $latestChapter;

    public $coverImageBase64;

    function __construct($id, $mangaId, $title, $coverImage, $readChapter, $latestChapter) {
        $this->id = $id;
        $this->mangaId = $mangaId;
        $this->title = $title;
        $this->coverImage = $coverImage;
        $this->readChapter = $readChapter;
        $this->latestChapter = $latestChapter;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    static function getAll($userId) {
        $sql = <<< SQL
            SELECT bk.id as bookmark_id, mg.id as manga_id, mg.title, mg.cover_image 
            FROM `bookmark` bk
            INNER JOIN `manga` mg ON mg.id = bk.manga_id
            WHERE user_id = ?;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();

        $bookmarkList = array();
        while ($row = $result->fetch_assoc()) {
            array_push($bookmarkList, Bookmark::toObject($row));
        }

        return $bookmarkList;
    }

    static function insert($mangaId, $userId) {
        $sql = <<< SQL
            INSERT INTO `bookmark` (`id`, `manga_id`, `user_id`) VALUES (NULL, '$mangaId', '$userId');
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        return $statement->insert_id;
    }

    static function remove($mangaId, $userId) {
        $sql = <<< SQL
            DELETE FROM `bookmark` WHERE `manga_id` = $mangaId AND `user_id` = $userId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
    }

    static function checkStatus($mangaId, $userId) {
        $sql = <<< SQL
            SELECT * FROM `bookmark` WHERE `manga_id` = $mangaId AND `user_id` = $userId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $totalRows = $statement->get_result()->num_rows;

        // 0 is counted as falsy value in PHP
        return $totalRows;
    }

    static function toObject($row) {
        $readHistory = ReadHistory::get($_SESSION["user_id"], $row["manga_id"]);

        if ($readHistory != null) {
            $readChapter = $readHistory->getReadChapter();
        } else {
            $readChapter = null;
        }

        $latestChapter = Chapter::getLatestChapter($row["manga_id"]);

        return new Bookmark(
            $row["bookmark_id"],
            $row["manga_id"],
            $row["title"],
            $row["cover_image"],
            $readChapter,
            $latestChapter
        );
    }

    function getId() { return $this->id; }
    function getMangaId() { return $this->mangaId; }
    function getTitle() { return $this->title; }
    function getCoverImage() { return $this->coverImage; }
    function getReadChapter() { return $this->readChapter; }
    function getLatestChapter() { return $this->latestChapter; }
}