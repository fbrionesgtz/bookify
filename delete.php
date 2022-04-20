<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * View page after a book is successfully deleted from the database.
 * If the user is not logged in they should not be able to reach this page but if they find it,
 * they will be redirected to login.
 */
$title = "Bookify - Delete a Book";

// Include config file
require_once("lib/config.php");


$bookId = "";
$msg = "";

// Process delete operation after confirmation
if (isset($_GET["bookId"]) && !empty($_GET["bookId"])) {
    //Sanitize the parameter
    $bookId = $mysqli->real_escape_string($_GET['bookId']);
    // example UPDATE query
    $query = "DELETE FROM books WHERE books.id =$bookId ";
    $result = $mysqli->query($query);

    if ($result) {
        $msg = '<div class="alert alert-success" role="alert">  Record deleted successfully. ' . $mysqli->affected_rows . ' book deleted from database. </div> <a href="index.php" class="btn btn-primary" title="index" data-toggle="tooltip">View All Books</a>';


    } else {
        $msg = '<div class="alert alert-danger" role="alert"> Error deleting record: ' . $mysqli->error . '</div>';
    }

    $mysqli->close();
    include("resources/templates/header.php");
}
if ($checkLoggedIn){
?>
<div id="container">
    <div id="mainArea">
        <p><?php echo $msg;
            } else {
                header("Location: login.php?message=notLoggedIn");
            } ?></p>
    </div>
</div>
<?php
include("resources/templates/footer.php");
?>

