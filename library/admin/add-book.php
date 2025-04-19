<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if (isset($_POST['add'])) {
        $bookname = trim($_POST['bookname']);
        $category = trim($_POST['category']);
        $author = trim($_POST['author']);
        $isbn = trim($_POST['isbn']);
        $price = trim($_POST['price']);

        // ✅ Validation
        if (!is_numeric($price)) {
            $_SESSION['error'] = "Price must be a number.";
            header('location:add-book.php');
            exit();
        }

        if (!preg_match('/^\d{10,13}$/', $isbn)) {
            $_SESSION['error'] = "ISBN must be 10 to 13 digits.";
            header('location:add-book.php');
            exit();
        }

        // ✅ Check for duplicate ISBN
        $checkSql = "SELECT id FROM tblbooks WHERE ISBNNumber = :isbn";
        $checkQuery = $dbh->prepare($checkSql);
        $checkQuery->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $checkQuery->execute();

        if ($checkQuery->rowCount() > 0) {
            $_SESSION['error'] = "A book with this ISBN already exists.";
            header('location:add-book.php');
            exit();
        }

        // ✅ Insert book
        $sql = "INSERT INTO tblbooks(BookName, CatId, AuthorId, ISBNNumber, BookPrice) 
                VALUES(:bookname, :category, :author, :isbn, :price)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookname', $bookname, PDO::PARAM_STR);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':author', $author, PDO::PARAM_STR);
        $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $_SESSION['msg'] = "Book Listed successfully";
            header('location:manage-books.php');
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again";
            header('location:manage-books.php');
        }
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Online Library Management System | Add Book</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<?php include('includes/header.php'); ?>
<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Book</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <div class="panel panel-info">
                    <div class="panel-heading">Book Info</div>
                    <div class="panel-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label>Book Name<span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="bookname" autocomplete="off" required />
                            </div>

                            <div class="form-group">
                                <label>Category<span style="color:red;">*</span></label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <?php 
                                    $status = 1;
                                    $sql = "SELECT * FROM tblcategory WHERE Status = :status";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':status', $status, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            echo '<option value="'.htmlentities($result->id).'">'.htmlentities($result->CategoryName).'</option>';
                                        }
                                    } 
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Author<span style="color:red;">*</span></label>
                                <select class="form-control" name="author" required>
                                    <option value="">Select Author</option>
                                    <?php 
                                    $sql = "SELECT * FROM tblauthors";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                            echo '<option value="'.htmlentities($result->id).'">'.htmlentities($result->AuthorName).'</option>';
                                        }
                                    } 
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>ISBN Number<span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="isbn" required autocomplete="off" />
                                <p class="help-block">An ISBN is an International Standard Book Number. ISBN must be unique.</p>
                            </div>

                            <div class="form-group">
                                <label>Price<span style="color:red;">*</span></label>
                                <input class="form-control" type="text" name="price" required autocomplete="off" />
                            </div>

                            <button type="submit" name="add" class="btn btn-info">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
