<?php
/**
 * @author hmchugh
 * @since 3/12/2022
 *
 * Description: add account
 */
$title = "Bookify - Add a New Account";
include("resources/templates/header.php");
?>
<body>
<div id="container">
    <div id="mainArea">
        <?php
        require_once("lib/utilities.php");
        if (!$checkLoggedIn) {
        if (isset($_POST['submit'])) {

            // create short variable names
            $username = test_input($_POST['username']);
            $password = test_input($_POST['password']);

            if (empty($username) || empty($password)) {

                header("location:newBook.php?error=empty");
                exit();

            }
            //Connect to db
            require('lib/config.php');

            $username = $mysqli->real_escape_string($username);
            $password = $mysqli->real_escape_string(sha1($password));

            if (mysqli_connect_errno()) {
                echo '<div class="alert alert-danger" role = "alert">Error: Could not connect to database.  Please try again later.</div>';
                exit;
            }

            $query = "insert into account (account.userName, account.password, account.accountType, account.joinDate) 
                    values ('".$username."', '".$password."', 'user', CURRENT_DATE())";
            $result = $mysqli->query($query);

            if ($result) {
                echo '<div class="alert alert-success" role = "alert">' . $mysqli->affected_rows . " customer inserted into database. ";;

                echo "<a href='index.php' class='btn btn-primary' title='index' data-toggle='tooltip'>Go Home</a></p>";
                // $result->free();
                $mysqli->close();
            } else {
                echo '<div class = "alert alert-danger" role="alert">An error has occurred.  The item was not added. <a href="createAccount.php">Try again?</a></div>';
            }

        } else {
            header("location:createAccount.php");
            exit();
        }
        ?>
    </div>
</div>
<?php
} else {
    header("Location: index.php");
}
include("resources/templates/footer.php");
?>

