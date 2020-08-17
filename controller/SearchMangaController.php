<?php
require_once "models/Database.php";
require_once "models/Manga.php";

class SearchMangaController
{

    const ITEM_PER_PAGE = 4;
    private $offset;

    private $title = "";
    private $authorName = "";
    private $genre = "";
    private $ratingOption = ""; // Any, Less than, or More than
    private $ratingValue = "";
    private $status = "";

    private $totalNumber;

    function __construct($offset)
    {
        if (isset($_GET['title'])) {
            $this->title = $_GET['title'];
        }

        if (isset($_GET['genre'])) {
            $this->genre = $_GET['genre'];
        }

        if (isset($_GET['author'])) {
            $this->authorName = $_GET['author'];
        }

        if (isset($_GET['ratingOption'])) {
            $this->ratingOption = $_GET['ratingOption'];
        }

        if (isset($_GET['ratingValue'])) {
            $this->ratingValue = $_GET['ratingValue'];
        }

        if (isset($_GET['status'])) {
            $this->status = $_GET['status'];
        }

        $this->offset = $offset;
    }

    function search()
    {
        if (isset($this->genre) && !empty($this->genre) ) {

            if (isset($this->title) && $this->title !== '') {
                return self::byGenresWithTitle();
            }

            return self::byGenres();
        }

        // If string is not empty, query the DB
        else if (isset($this->title) && $this->title !== '') {
            return self::byTitle();

            // Otherwise return an unfiltered list 
        } else {
            return Manga::getByPagination($this->offset);
        }
    }

    function getTotalNumber()
    {
        return $this->totalNumber;
    }

    function byTitle()
    {
        $itemPerPage = self::ITEM_PER_PAGE;
        $sql = <<< SQL
            SELECT * FROM manga
            WHERE title LIKE CONCAT('%',?,'%')
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->bind_param("s", $this->title);
        $statement->execute();

        $result = $statement->get_result();

        $mangaList = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($mangaList, $manga);
        }
        return $mangaList;
    }

    function byGenres() {
        $itemPerPage = self::ITEM_PER_PAGE;

        $genreString = implode(", ", $this->genre);

        $sql = <<< SQL
            SELECT manga.id AS id, author_id, title, status, cover_image, view_count, money_earned, summary, COUNT(*) as totalMangas 
            FROM manga
            INNER JOIN  manga_genre ON manga.id = manga_genre.manga_id
            WHERE manga_genre.genre_id IN ($genreString) 
            GROUP BY manga.id
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();

        $mangaList = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($mangaList, $manga);

            // Set the total number of mangas
            $totalNumber = $row['totalMangas'];
        }
        return $mangaList;
    }

    function byGenresWithTitle() {
        $itemPerPage = self::ITEM_PER_PAGE;

        $genreString = implode(", ", $this->genre);

        $sql = <<< SQL
            SELECT manga.id AS id, author_id, title, status, cover_image, view_count, money_earned, summary
            FROM manga
            INNER JOIN  manga_genre ON manga.id = manga_genre.manga_id
            WHERE title LIKE CONCAT('%',"a",'%') AND manga_genre.genre_id IN ($genreString) 
            GROUP BY manga.id
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->bind_param("s", $this->title);
        $statement->execute();

        $result = $statement->get_result();

        $mangaList = array();
        while ($row = $result->fetch_assoc()) {
            $manga = Manga::toObject($row);
            array_push($mangaList, $manga);
        }
        return $mangaList;
    }
}
