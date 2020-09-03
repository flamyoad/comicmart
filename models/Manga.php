<?php
require_once "Database.php";

class Manga implements JsonSerializable {

    private $id;
    private $authorId;
    private $title;
    private $status;
    private $coverImage;
    private $viewCount;
    private $moneyEarned;
    private $summary;

    public $authorName;

    // for mobile application
    public $coverImageBase64;

    public static $itemPerPage = 4;

    function __construct($id, $authorId, $title, $status, $coverImage, $viewCount, $moneyEarned, $summary) {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
        $this->status = $status;
        $this->coverImage = $coverImage;
        $this->viewCount = $viewCount;
        $this->moneyEarned = $moneyEarned;
        $this->summary = $summary;
    }

    // https://stackoverflow.com/questions/9683687/json-encode-is-not-working-with-array-of-objects
    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    function insert() {
        $conn = Database::getConnection();
        $escapedTitle = mysqli_real_escape_string($conn, $this->title);
        $escapedSummary = mysqli_real_escape_string($conn, $this->summary);

        $sql = <<< SQL
        INSERT INTO `manga` (`id`, `author_id`, `title`, `status`, `cover_image`, `view_count`, `money_earned`, `summary`) VALUES ('$this->id', '$this->authorId', 
        '$escapedTitle', 
        '$this->status', '$this->coverImage', '$this->viewCount', '$this->moneyEarned', 
        '$escapedSummary')
        SQL;

        $statement = $conn->prepare($sql);
        $statement->execute();

        $insertId = $statement->insert_id;
        return $insertId;
    }

    static function getById($primaryKey) {
        $sql = <<< SQL
            SELECT * FROM `manga` WHERE id = $primaryKey;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $row = $result->fetch_assoc();
        $manga = Manga::toObject($row);

        return $manga;
    }

    static function getByPagination($offset) {
        $itemPerPage = self::$itemPerPage;
        $sql = <<< SQL
            SELECT * FROM `manga`
            LIMIT $itemPerPage
            OFFSET $offset
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $fetchedMangas = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($fetchedMangas, $manga);
        }
        return $fetchedMangas;
    }

    // Get the most recent manga
    static function getLatestManga($amount_to_fetch) {
        $sql = <<< SQL
            SELECT * FROM `manga` ORDER BY id DESC LIMIT $amount_to_fetch
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $fetchedMangas = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($fetchedMangas, $manga);
        }
        return $fetchedMangas;
    }

    // Get the most viewed manga
    static function getPopularManga($amount_to_fetch = 10) {
        $sql = <<< SQL
            SELECT * FROM `manga` ORDER BY view_count DESC LIMIT $amount_to_fetch
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $fetchedMangas = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($fetchedMangas, $manga);
        }
        return $fetchedMangas;
    }

    // Get all manga published by the same person
    static function getPublishedMangas($publisher_id) {
        $sql = <<< SQL
            SELECT *
            FROM manga
            WHERE author_id = (SELECT id FROM Author WHERE publisher_id = $publisher_id);
        SQL;

        $conn = Database::getConnection();
        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $publishedMangas = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($publishedMangas, $manga);
        }
        return $publishedMangas;
    }

    static function getTotalNumber() {
        $sql = <<< SQL
            SELECT COUNT(*) FROM `manga`
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        return $row['COUNT(*)'];
    }

    static function incrementViewCount($mangaId) {
        $sql = <<< SQL
            UPDATE `manga`
            SET `view_count` = `view_count` + 1
            WHERE `id` = ?
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->bind_param("i", $mangaId);
        $statement->execute();
    }

    static function toObject($row) {
        return new Manga(
            $row['id'],
            $row['author_id'],
            $row['title'],
            $row['status'],
            $row['cover_image'],
            $row['view_count'],
            $row['money_earned'],
            $row['summary']
        );
    }

    function getId()
    {
        return $this->id;
    }
    function getAuthorId()
    {
        return $this->authorId;
    }
    function getTitle()
    {
        return $this->title;
    }
    function getStatus()
    {
        return $this->status;
    }
    function getCoverImage()
    {
        return $this->coverImage;
    }
    function getViewCount()
    {
        return $this->viewCount;
    }
    function getMoneyEarned()
    {
        return $this->moneyEarned;
    }
    function getSummary()
    {
        return $this->summary;
    }

    function getLink()
    {
        return "comicpage.php?id=" . $this->getId();
    }

    static function getLinkById($id) {
        return "comicpage.php?id=" . $id;
    }
}
