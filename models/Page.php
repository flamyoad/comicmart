<?php
require_once "Database.php";

class Page {
    private $id;
    private $chapterId;
    private $pageNumber;
    private $imageLocation;

    // For mobile use
    public $imageBase64;

    function __construct($id, $chapterId, $pageNumber, $imageLocation) {
        $this->id = $id;
        $this->chapterId = $chapterId;
        $this->pageNumber = $pageNumber;
        $this->imageLocation = $imageLocation;
    }

    function insert() {
        $conn = Database::getConnection();
        $sql = "INSERT INTO `page` (`id`, `chapter_id`, `page_number`, `image_location`) VALUES ('$this->id', '$this->chapterId', '$this->pageNumber', '$this->imageLocation')";
        
        $statement = $conn->prepare($sql);
        $statement->execute();
    }

    static function getChapterPages($chapterId) {
        $sql = <<< SQL
            SELECT * FROM `page` WHERE `chapter_id` = $chapterId
        SQL;
        
        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->get_result();

        $pageList = array();

        while ($row = $result->fetch_assoc()) {
            $page = Page::toObject($row);
            array_push($pageList, $page);
        }
        return $pageList;
    }

    static function toObject($row) {
        return new Page(
            $row['id'],
            $row['chapter_id'],
            $row['page_number'],
            $row['image_location']
        );
    }

    function getId() { return $this->id; }
    function getChapterId() { return $this->chapterId; }
    function getPageNumber() { return $this->pageNumber; }
    function getImageLocation() { return $this->imageLocation; }
}