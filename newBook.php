<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Form page to add a new book to the database if there are no errors.
 * If the user is not logged in they will be redirected to the homepage
 */
$title = "Bookify Add a New Book";
include("resources/templates/header.php");
?>
<body>
<div id="container">
    <div class="newBook-form">
        <form action="addBook.php" method="post">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Bookify - New Book Entry</legend>
                <?php
                if ($checkLoggedIn){
                $msg = "";

                if (isset($_GET["error"])) {

                    if ($_GET["error"] == 'empty') {

                        $msg = "You have not entered all the required details.";
                    } else if ($_GET["error"] == 'db') {

                        $msg = "DB error.Book not added.";
                    } else if ($_GET["error"] == 'noform') {

                        $msg = "You must fill out a new book form.";
                    }
                }
                echo '<p class="error">' . $msg . '</p>';
                ?>

                <div class="form-group">
                    <label for="isbn">ISBN (format 0-672-31509-2):</label>
                    <input type="text" class="form-control" id="isbn" placeholder="Enter book isbn" name="isbn">
                </div>
                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" class="form-control" id="author" placeholder="Enter book author" name="author">
                </div>
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter book title" name="title">
                </div>
                <div class="form-group">
                    <label for="price">Price $</label>
                    <input type="text" class="form-control" id="price" placeholder="Enter book price" name="price">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Add book</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>
<?php
} else {
    header("Location: login.php?message=notLoggedIn");
}
include("resources/templates/footer.php");
?>
