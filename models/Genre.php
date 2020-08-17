<?php
require_once "Database.php";

class Genre {
    private $id;
    private $name;
    private $link;

    function __construct($id, $name, $link) {
        $this->id = $id;
        $this->name = $name;
        $this->link = $link;
    }

    static function getAll() {
        $conn = Database::getConnection();
        $sql = "SELECT * FROM genres ORDER BY `name`";

        $statement = $conn->prepare($sql);
        $statement->execute();
        $result = $statement->get_result(); 

        // Create a new empty array
        $genreList = array();

        while ($row = $result->fetch_assoc()) {
            $genre = Genre::toObject($row);
            // Append the genre object into array
            array_push($genreList, $genre);
        }
        return $genreList;
    }

    static function insert($mangaId, $genreId) {
        $conn = Database::getConnection();
        $sql = "INSERT INTO `manga_genre` (`id`, `manga_id`, `genre_id`) VALUES ('NULL', '$mangaId', '$genreId')";
        
        $statement = $conn->prepare($sql);

        $statement->execute();
    }

    static function getMangaGenres($mangaId) {
        $sql = <<< SQL
            SELECT genres.id, genres.name
            FROM manga_genre mg
            INNER JOIN genres on mg.genre_id = genres.id
            WHERE manga_id = $mangaId;
        SQL;

        $statement = Database::getConnection()->prepare($sql);
        $statement->execute();

        $result = $statement->get_result();

        $genreList = array();
        while ($row = $result->fetch_assoc()) {
            $genre = Genre::toObject($row);
            array_push($genreList, $genre);
        }
        return $genreList;
    }

    private static function toObject($row) {
        $link = "search.php?genre[]=" . $row["id"];
        return new Genre(
            $row["id"],
            $row["name"],
            $link
        );
    }

    function getId() { return $this->id; }
    function getName() { return $this->name; }
    function getLink() { return $this->link; }
}
