<?php
include_once './database/dbhelper.php';
function db_connect()
{
    $conn = new Database(null, null, null, null);
    return $conn->getConnect();
}


function getBookByIsbn($isbn)
{
    try {
        $conn = db_connect();
        $query = "SELECT book_title, book_author, book_price FROM books WHERE book_isbn =:isbn";
        $cmd = $conn->prepare($query);
        $cmd->bindValue(":isbn", $isbn);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }

}

function getOrderId($conn, $customerid)
{
    try {
        $conn = db_connect();
        $query = "SELECT orderid FROM orders WHERE customerid = '$customerid'";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result['orderid'];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function insertIntoOrder($conn, $customerid, $total_price, $date, $ship_name, $ship_address, $ship_city, $ship_zip_code, $ship_country)
{
    try {
        $conn = db_connect();
        $query = "INSERT INTO orders VALUES 
		('', '" . $customerid . "', '" . $total_price . "', '" . $date . "', '" . $ship_name . "', '" . $ship_address . "', '" . $ship_city . "', '" . $ship_zip_code . "', '" . $ship_country . "')";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $id = $conn->lastInsertId();
        return $id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function getbookprice($isbn)
{
    try {
        $conn = db_connect();
        $query = "SELECT book_price FROM books WHERE book_isbn = '$isbn'";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result['book_price'];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function getCustomerId($name, $address, $city, $zip_code, $country)
{
    try {
        $conn = db_connect();
        $query = "SELECT customerid from customers WHERE 
		name = '$name' AND 
		address= '$address' AND 
		city = '$city' AND 
		zip_code = '$zip_code' AND 
		country = '$country'";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result['customerid'];
        // if there is customer in db, take it out

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function setCustomerId($name, $address, $city, $zip_code, $country)
{
    try {
        $conn = db_connect();
        $query = "INSERT INTO customers VALUES 
			('', '" . $name . "', '" . $address . "', '" . $city . "', '" . $zip_code . "', '" . $country . "')";

        $cmd = $conn->prepare($query);
        $cmd->execute();
        $id = $conn->lastInsertId();
        return $id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function getPubName($conn, $pubid)
{
    try {
        $conn = db_connect();

        $query = "SELECT publisher_name FROM publisher WHERE publisherid = '$pubid'";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();
        return $result['publisher_name'];
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

function getAll($conn)
{
    try {
    $conn = db_connect();
    $query = "SELECT * from books ORDER BY book_isbn DESC";
        $cmd = $conn->prepare($query);
        $cmd->execute();
        $result = $cmd->fetchAll();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
    }
}

?>