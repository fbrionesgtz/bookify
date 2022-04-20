<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Processing page to update and existing book to the database if there are no errors.
 * If the user is not logged in they will be redirected to the homepage.
 */
$title = "Bookify - Update a Book";
include("resources/templates/header.php");
?>
    <body>
<div id="container">
    <div id="mainArea">
        <?php
        if ($checkLoggedIn) {
            if (isset($_POST['submit'])) {
                // create short variable names
                $bookId = $_POST['bookId'];
                $isbn = $_POST['isbn'];
                $author = $_POST['author'];
                $title = $_POST['title'];
                $price = $_POST['price'];

                if (empty($isbn) || empty($author) || empty($title) || empty($price)) {
                    echo '<div class="alert alert-danger" role="alert">You have not entered all the required details.<br/></div>'
                        . "Please press the back button to return to the form.</div></div></body>" ?><?php include("resources/templates/footer.php");
                    "</html>";
                    exit;
                }

                require("lib/config.php");
                //$bookId=$mysqli->real_escape_string($bookId);
                $isbn = $mysqli->real_escape_string($isbn);
                $author = $mysqli->real_escape_string($author);
                $title = $mysqli->real_escape_string($title);
                $price = $mysqli->real_escape_string(doubleval($price));

                //UPDATE query
                $query = "UPDATE books SET isbn='$isbn', title='$title', author='$author', price=$price WHERE books.id=$bookId LIMIT 1";
                $result = $mysqli->query($query);

                if ($result) {
                    echo '<div class="alert alert-success" role="alert">' . $mysqli->affected_rows . ' book updated in database. </div><a href="index.php" class="btn btn-primary" title="index" data-toggle="tooltip">View All Books</a>';
                    //select book
                    //Order Detail Report Query
                    $query = "SELECT *
                                FROM `books`
                                where books.id=$bookId";


// Here we use our $db object created above and run the query() method. We pass it our query from above.
                    $result = $mysqli->query($query);

                    // Here we 'get' the num_rows attribute of our $result object - this is key to knowing if we should show the results or
// display an error message, or perhaps just to say we don't have any results.
                    $num_results = $result->num_rows;

                    //echo "<p>Total Results: $num_results</p>";

                    if ($num_results > 0) {
                        //  $result->fetch_all(MYSQLI_ASSOC) returns a numeric array of all the books retrieved with the query
                        $books = $result->fetch_all(MYSQLI_ASSOC);

                        echo "<table class='table table-bordered table striped'><tr>";
                        //This dynamically retieves header names
                        foreach ($books[0] as $k => $v) {
                            echo "<th>" . $k . "</th>";
                        }
                        echo "</tr>";
                        //Create a new row for each book
                        foreach ($books as $book) {
                            echo "<tr>";
                            foreach ($book as $k => $v) {
                                echo "<td>" . $v . "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        // if no results
                        echo "<p>Sorry there are no entries in the database.</p>";
                    }
                    $result->free();
                    $mysqli->close();

                } else {
                    echo "An error has occurred.  The item was not updated.";
                }
            } else {
                header("location:index.php");
                exit();

            }
        } else {
            header("Location: login.php?message=notLoggedIn");
        }
        ?>
    </div>
</div>
<?php
include("resources/templates/footer.php");
?>