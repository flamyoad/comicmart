<?php
    require_once "models/Chapter.php";

    $chapterId = $_POST["chapterId"];
    $newPrice = $_POST["newPrice"];

    $status = Chapter::editPrice($chapterId, $newPrice);

    // TODO: check google for error handling code lel
?>  