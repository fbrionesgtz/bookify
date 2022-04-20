<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: Header template that will appear on every page.
 */
session_start();

if (!isset($_SESSION["loggedIn"])) {
    $_SESSION["loggedIn"] = false;
}

//Set username from $_SESSION associative array (it will show up on every page with a header if the user is logged in.
if (isset($_SESSION["username"])) {
    $userName = $_SESSION["username"];
}

if (isset($_SESSION["accountId"])) {
    $accountId = $_SESSION["accountId"];
}

if (isset($_SESSION["accountType"])) {
    $accountType = $_SESSION["accountType"];
}

//Check if the user is logged in
$checkLoggedIn = $_SESSION["loggedIn"];
?>

<!doctype html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/globals.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/bookList.css">
    <link rel="stylesheet" href="css/button.css">
    <link rel="stylesheet" href="css/reports.css">
    <link rel="stylesheet" href="css/bookDetails.css">
    <link rel="stylesheet" href="css/auth.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/collection.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<section>
    <nav class="navbar">
        <div class="logo">
            <img src="img/books.png">
            <p>Bookify</p>
        </div>
            <ul>
                <li>
                    <a href='index.php'>Home</a>
                    <?php echo $checkLoggedIn ? "<li><a href='collection.php'>Collection</a></li>" :
                        "" ?>
                    <?php echo $checkLoggedIn && $_SESSION["accountType"] == "admin" ? "<li><a href='reports.php'>View Reports</a></li>" : //Render login/logout dynamically
                        ""; ?>
                    <?php echo $checkLoggedIn ? "<li class='dropdown'>$userName<ul>
                                                <li><a href='viewAccount.php?accountId=" . $accountId . "'>View Account</a></li>
                                                </ul></li>" : ""; ?>
                    <?php echo $checkLoggedIn ? "<li><a href='logout.php'>Logout</a></li>" : //Render login/logout dynamically
                        "<li><a href='login.php'>Login</a></li>"; ?>
                <li>
                    <form method="post" action="index.php">
                        <input type="text" placeholder="Search.." name="inputSearch">
                        <button type="submit" name="btnSearch"><span class="glyphicon glyphicon-search"
                                                                     aria-hidden="true"></span></button>
                    </form>
                </li>
            </ul>
    </nav>
</section>