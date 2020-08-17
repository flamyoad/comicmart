<?php
    require_once "models/Chapter.php";

    $chapterId = $_POST["chapterId"];
    $newTitle = $_POST["newTitle"];

    $status = Chapter::editName($chapterId, $newTitle);
?>  