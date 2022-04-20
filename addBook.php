<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Processing page to add a new book to the database if there are no errors. If the user is not logged in they will be redirected to the homepage
 */
$title = "Bookify - Add a New Book";
include("resources/templates/header.php");
?>
<body>
<div id="container">
    <div id="mainArea">
        <?php
        require_once("lib/utilities.php");
        if ($checkLoggedIn) {
        if (isset($_POST['submit'])) {

            // create short variable names
            $isbn = test_input($_POST['isbn']);
            $author = test_input($_POST['author']);
            $title = test_input($_POST['title']);
            $price = test_input($_POST['price']);

            if (empty($isbn) || empty($author) || empty($title) || empty($price)) {

                header("location:newBook.php?error=empty");
                exit();

            }
            //Connect to db
            require('lib/config.php');

            $isbn = $mysqli->real_escape_string($isbn);
            $author = $mysqli->real_escape_string($author);
            $title = $mysqli->real_escape_string($title);
            $price = $mysqli->real_escape_string(doubleval($price));

            if (mysqli_connect_errno()) {
                echo '<div class="alert alert-danger" role = "alert">Error: Could not connect to database.  Please try again later.</div>';
                exit;
            }

            $query = "INSERT INTO books VALUES (NULL,'" . $isbn . "', '" . $author . "', '" . $title . "', " . $price . ")";
            $result = $mysqli->query($query);

            if ($result) {
                echo '<div class="alert alert-success" role = "alert">' . $mysqli->affected_rows . " book inserted into database. ";;

                //Display book inventory
                $query = "SELECT * FROM books";
// Here we use our $mysqli object created above and run the query() method. We pass it our query from above.
                $result = $mysqli->query($query);

                $num_results = $result->num_rows;

                echo "<p>Number of books found: " . $num_results . "</div>";
                echo "<a href='newBook.php' class='btn btn-primary' title='index' data-toggle='tooltip'>Add Another Book</a></p>";

                echo "<h2>CIS Book Inventory</h2>";
                echo "<table class='table table-bordered table-striped'>";
                echo "<thead>";
                if ($num_results > 0) {
//  $result->fetch_all(MYSQLI_ASSOC) returns a numeric array of all the books retrieved with the query
                    $books = $result->fetch_all(MYSQLI_ASSOC);
                    echo "<table class='table table-bordered'><tr>";

//This dynamically retrieves header names
                    foreach ($books[0] as $k => $v) {
                        echo "<th>" . $k . "</th>";
                    }
                    echo "</thead>";
                    echo "<tbody>";
//Create a new row for each book
                    foreach ($books as $book) {
                        echo "<tr>";

                        foreach ($book as $k => $v) {

                            echo "<td>" . $v . "</td>";

                        }
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                }
                $result->free();
                $mysqli->close();
            } else {
                echo '<div class = "alert alert-danger" role="alert">An error has occurred.  The item was not added. <a href="newBook.php">Try again?</a></div>';
            }

        } else {
            header("location:newBook.php?error=noform");
            exit();
        }
        ?>
    </div>
</div>
<?php
} else {
    header("Location: login.php?message=notLoggedIn");
}
include("resources/templates/footer.php");
?>

