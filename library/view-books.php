<?php
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>All Books - Library System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
<?php include('includes/header.php'); ?>

<div class="content-wrapper">
    <div class="container">
        <h3>All Books</h3>

        <form method="get" class="form-inline mb-3">
            <label>Filter by Category: </label>
            <select name="category" class="form-control" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php
                $sql = "SELECT id, CategoryName FROM tblcategory WHERE Status=1";
                $query = $dbh->prepare($sql);
                $query->execute();
                $categories = $query->fetchAll(PDO::FETCH_OBJ);
                foreach($categories as $cat) {
                    $selected = (isset($_GET['category']) && $_GET['category'] == $cat->id) ? 'selected' : '';
                    echo "<option value='{$cat->id}' $selected>" . htmlentities($cat->CategoryName) . "</option>";
                }
                ?>
            </select>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $where = '';
                if (isset($_GET['category']) && $_GET['category'] != '') {
                    $where = "WHERE tblbooks.CatId = :catid";
                }

                $sql = "SELECT tblbooks.BookName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblcategory.CategoryName 
                        FROM tblbooks 
                        JOIN tblauthors ON tblbooks.AuthorId = tblauthors.id 
                        JOIN tblcategory ON tblbooks.CatId = tblcategory.id 
                        $where 
                        ORDER BY tblbooks.id DESC";
                $query = $dbh->prepare($sql);
                if ($where != '') {
                    $query->bindParam(':catid', $_GET['category'], PDO::PARAM_INT);
                }
                $query->execute();
                $books = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach($books as $book) {
                        echo "<tr>
                            <td>" . $cnt++ . "</td>
                            <td>" . htmlentities($book->BookName) . "</td>
                            <td>" . htmlentities($book->AuthorName) . "</td>
                            <td>" . htmlentities($book->ISBNNumber) . "</td>
                            <td>" . htmlentities($book->CategoryName) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No books found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
