<?php
session_start();
require_once "./controllers/database_functions.php";
// get pubid
if (isset($_GET['pubid'])) {
    $pubid = $_GET['pubid'];
} else {
    echo "Wrong query! Check again!";
    exit;
}

// connect database
$conn = db_connect();
$pubName = getPubName($conn, $pubid);

$query = "SELECT book_isbn, book_title, book_image FROM books WHERE publisherid = '$pubid'";
$cmd = $conn->prepare($query);
$cmd->execute();
$result = $cmd->fetchAll();
if (!$result) {
    echo "Can't retrieve data ";
    exit;
}
if (count($result) == 0) {
    echo "Empty books ! Please wait until new books coming!";
    exit;
}

$title = "Books Per Publisher";
require "./template/header.php";
?>
    <p class="lead"><a href="publisher_list.php">Publishers</a> > <?php echo $pubName; ?></p>
<?php foreach ($result as $row) {
    ?>
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $row['book_image']; ?>">
        </div>
        <div class="col-md-7">
            <h4><?php echo $row['book_title']; ?></h4>
            <a href="book.php?bookisbn=<?php echo $row['book_isbn']; ?>" class="btn btn-primary">Get Details</a>
        </div>
    </div>
    <br>
    <?php
}

require "./template/footer.php";
?>