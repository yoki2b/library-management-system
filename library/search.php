<?php
include('includes/config.php');

if (isset($_GET['query'])) {
    $search = htmlspecialchars($_GET['query']);
    
    $sql = "SELECT BookName, AuthorName FROM tblbooks 
            WHERE BookName LIKE :search OR AuthorName LIKE :search";

    $query = $dbh->prepare($sql);
    $query->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    echo "<h2>Search results for: <em>" . htmlentities($search) . "</em></h2>";

    if ($query->rowCount() > 0) {
        echo "<ul>";
        foreach ($results as $row) {
            echo "<li><strong>" . htmlentities($row->BookName) . "</strong> by " . htmlentities($row->AuthorName) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No books found.</p>";
    }
}
?>
