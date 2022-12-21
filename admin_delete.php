<?php
$book_isbn = $_GET['bookisbn'];

require_once "./controllers/database_functions.php";
$conn = db_connect();

$query = "DELETE FROM books WHERE book_isbn = '$book_isbn'";
$cmd = $conn->prepare($query);
$result = $cmd->execute();

if (!$result) {
    echo "delete data unsuccessfully " ;
    exit;
}
header("Location: admin_book.php");
?>