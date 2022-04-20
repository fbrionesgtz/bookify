<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Form page to update and existing book to the database if there are no errors.
 * If the user is not logged in they will be redirected to the homepage.
 */
$title = "Bookify - Update a Book";
require("resources/templates/header.php");
?>
<body>
<div id="container">
    <div id="mainArea">
        <?php
        require_once("lib/utilities.php");
        if ($checkLoggedIn) {
            if (isset($_GET['bookId'])) {

                //Get the selected book ID
                $bookId = $_GET['bookId'];

                //Connect to db
                require("lib/config.php");

                $bookId = $mysqli->real_escape_string($bookId);

                // get the data for just the book we want to edit!
                $query = "SELECT * FROM books WHERE books.id = $bookId";
                $result = $mysqli->query($query);

                $num_results = $result->num_rows;

                if ($num_results == 0) {
                    $message = "Book not found.";
                } else {
                    $row = $result->fetch_assoc();
                    $isbn = $row['isbn'];
                    $title = $row['title'];
                    $author = $row['author'];
                    $price = $row['price'];
                }

                $result->free();
                $mysqli->close();
            } else {
                //the id is not provided
                $message = "Sorry, no id provided.";
            }

            // if message gets set above it means there is a problem and we don't have a book with that id to edit or it isn't provided
            if (isset($message)) {
                echo '<div class="alert alert-danger" role ="alert">' . $message . '</div>';
            } else {
                // we have all we need so let's display the book
                ?>

                <div class="newBook-form">
                    <form action="updateBook.php" method="post">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">Bookify - Update Book</legend>

                            <div class="form-group">
                                <label for="isbn">ISBN (format 0-672-31509-2):</label>
                                <input type="text" class="form-control" id="isbn" value='<?php echo $isbn ?>'
                                       placeholder="Enter book isbn" name="isbn">
                            </div>
                            <div class="form-group">
                                <label for="author">Author:</label>
                                <input type="text" class="form-control" id="author" value='<?php echo $author ?>'
                                       placeholder="Enter book author" name="author">
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" value='<?php echo $title ?>'
                                       placeholder="Enter book title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="price">Price $</label>
                                <input type="text" class="form-control" id="price" value='<?php echo $price ?>'
                                       placeholder="Enter book price" name="price">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="bookId" value='<?php echo $bookId ?>'
                                       name="bookId">
                                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <?php
            } // close the if no book found $message above
        } else {
            header("Location: login.php?message=notLoggedIn");
        }
        ?>
    </div>
</div>
<?php
include("resources/templates/footer.php");
?>

