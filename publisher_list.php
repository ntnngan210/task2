<?php
session_start();
require_once "./controllers/database_functions.php";
$conn = db_connect();

$query = "SELECT * FROM publisher ORDER BY publisherid";
$cmd = $conn->prepare($query);
$cmd->execute();
$result = $cmd->fetch();
if (!$result) {
    echo "Can't retrieve data ";
    exit;
}
if (count($result) == 0) {
    echo "Empty publisher ! Something wrong! check again";
    exit;
}

$title = "List Of Publishers";
require "./template/header.php";
?>
    <p class="lead">List of Publisher</p>
    <ul>
        <?php
        while ($row = $result) {
            $count = 0;
            $query = "SELECT publisherid FROM books";
            $cmd = $conn->prepare($query);
            $cmd->execute();
            $result2 = $cmd->fetch();
            if (!$result2) {
                echo "Can't retrieve data " ;
                exit;
            }
            while ($pubInBook = $result2) {
                if ($pubInBook['publisherid'] == $row['publisherid']) {
                    $count++;
                }
            }
            ?>
            <li>
                <span class="badge"><?php echo $count; ?></span>
                <a href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>"><?php echo $row['publisher_name']; ?></a>
            </li>
        <?php } ?>
        <li>
            <a href="books.php">List full of books</a>
        </li>
    </ul>
<?php
require "./template/footer.php";
?>