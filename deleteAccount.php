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
        if (isset($_GET['accountId'])) {

            $accountId = $_GET['accountId'];

            include("lib/config.php");

            $accountId = $mysqli->real_escape_string($accountId);

            $query = " DELETE FROM account WHERE account.accountId = $accountId";
            $result = $mysqli->query($query);

            if ($result) {
                echo '<div class="alert alert-success" role = "alert">' . $mysqli->affected_rows . " customer deleted. ";

                echo "<a href='logout.php' class='btn btn-primary' title='logout' data-toggle='tooltip'>Go Home</a></p>";
                // $result->free();
                $mysqli->close();
            } else {
                echo '<div class = "alert alert-danger" role="alert">An error has occurred.  The item was not deleted. <a href="viewAccount.php">Try again?</a></div>';
            }

        } else {
            header("location:viewAccount.php");
            exit();
        }
        ?>
    </div>
</div>
<?php
include("resources/templates/footer.php");
?>

