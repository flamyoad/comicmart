<?php
require_once "Database.php";
require_once "Chapter.php";

class ReadHistory
{

    private $id;
    private $mangaId;
    private $title;
    private $date;
    private $mangaCover;
    private $latestChapter; // instance of Chapter
    private $readChapter; // instance of Chapter

    function __construct($id, $mangaId, $title, $date, $mangaCover, $latestChapter, $readChapter)
    {
        $this->id = $id;
        $this->mangaId = $mangaId;
        $this->title = $title;
        $this->date = $date;
        $this->mangaCover = $mangaCover;
        $this->latestChapter = $latestChapter;
        $this->readChapter = $readChapter;
    }

    static function insert($userId, $mangaId, $chapterId)
    {
        $selectQuery = "SELECT `id` FROM `read_history` WHERE user_id = $userId AND manga_id = $mangaId";
        $selectStmt = Database::getConnection()->prepare($selectQuery);
        $selectStmt->execute();

        // fetch_assoc() returns null on emptyset
        $result = $selectStmt->get_result()->fetch_assoc();

        if ($result != null) {
            $historyId = $result["id"];
        } else {
            $historyId = "NULL";
        }

        $todayDate = date_create()->format("Y-m-d");

        $sql = <<< SQL
            INSERT INTO `read_history` (`id`, `user_id`, `manga_id`, `chapter_id`, `date`)
            VALUES (
                '$historyId', 
                '$userId', 
                '$mangaId', 
                '$chapterId', 
                '$todayDate')
            ON DUPLICATE KEY UPDATE 
                chapter_id = $chapterId,
                date = $todayDate;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();
    }

    // May return null if user has never read before.. (means no history in DB)
    static function get($userId, $mangaId)
    {
        $sql = <<< SQL
            SELECT rh.id as history_id, m.id as manga_id, m.title, cover_image, rh.chapter_id, date
            FROM `read_history` rh
            INNER JOIN `manga` m ON m.id = rh.manga_id
            INNER JOIN `chapter` c ON c.id = rh.chapter_id
            WHERE rh.user_id = $userId AND rh.manga_id = $mangaId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        return ReadHistory::toObject($row);
    }

    static function getAll($userId)
    {
        $sql = <<< SQL
            SELECT rh.id as history_id, m.id as manga_id, m.title, cover_image, rh.chapter_id, date
            FROM `read_history` rh
            INNER JOIN `manga` m ON m.id = rh.manga_id
            INNER JOIN `chapter` c ON c.id = rh.chapter_id
            WHERE rh.user_id = $userId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();

        $readMangas = array();
        while ($row = $result->fetch_assoc()) {
            array_push($readMangas, ReadHistory::toObject($row));
        }
        return $readMangas;
    }

    static function toObject($row)
    {
        // Returns null on empty row (empty query)
        if ($row == null) {
            return null;
        }

        $latestChapter = Chapter::getLatestChapter($row["manga_id"]);
        $readChapter = Chapter::getById($row["chapter_id"]);

        return new ReadHistory(
            $row["history_id"],
            $row["manga_id"],
            $row["title"],
            $row["date"],
            $row["cover_image"],
            $latestChapter,
            $readChapter
        );
    }

    public function getId()
    {
        return $this->id;
    }
    public function getMangaId()
    {
        return $this->mangaId;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getDate()
    {
        return $this->date;
    }
    public function getCoverImage()
    {
        return $this->mangaCover;
    }
    public function getLatestChapter()
    {
        return $this->latestChapter;
    }
    public function getReadChapter()
    {
        return $this->readChapter;
    }
}
