<?php
/**
 * @author hmchugh
 * @since 3/12/2022
 *
 * Description: add account
 */
$title = "Bookify - Update Account";
include("resources/templates/header.php");
?>
<body>
<div id="container">
    <div id="mainArea">
        <?php
        if (isset($_POST['submit'])) {
            

            // create short variable names
            $username = $_POST['username'];
            $password = $_POST['password'];
            $accountId = $_POST['accountId'];
            
            //Connect to db
            require('lib/config.php');
            $accountId = $mysqli->real_escape_string($accountId);

            $username = $mysqli->real_escape_string($username);
            $password = $mysqli->real_escape_string(sha1($password));

            if (mysqli_connect_errno()) {
                echo '<div class="alert alert-danger" role = "alert">Error: Could not connect to database.  Please try again later.</div>';
                exit;
            }

            $query = " UPDATE account SET userName='$username', password='$password' WHERE account.accountId = $accountId";
            $result = $mysqli->query($query);

            if ($result) {
                echo '<div class="alert alert-success" role = "alert">' . "Account successfully updated. ";

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
include("resources/templates/footer.php");
?>

