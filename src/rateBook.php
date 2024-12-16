<?php

    session_start();

    include('./Database.php');

    $db = new Database();

    $bookId = $_POST['bookId'];
    $userId = $_POST['userId'];
    $ratint = $_POST['rating'];

    $db->rateBook($bookId, $userId, $ratint);

    header('Location: ./booksList.php');

?>