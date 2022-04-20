<?php
/**
 * @author hmchugh
 * @since 3/12/2022
 *
 * Description: page to create an account
 */
$title = "Bookify Create Account";
include("resources/templates/header.php");
?>
<body>
<div id="container">
    <div class="login-form">
        <form action="addAccount.php" method="post">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Create Account</legend>
                <?php
                if (!$checkLoggedIn){
                $msg = "";

                if (isset($_GET["error"])) {

                    if ($_GET["error"] == 'empty') {

                        $msg = "You have not entered all the required details.";
                    } else if ($_GET["error"] == 'db') {

                        $msg = "DB error.Book not added.";
                    } else if ($_GET["error"] == 'noform') {

                        $msg = "You must fill out all details.";
                    }
                }
                echo '<p class="error">' . $msg . '</p>';
                ?>

                <div class="form-group">
                    <label for="isbn">Email/Username:</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
                </div>
                <div class="form-group">
                    <label for="author">Password:</label>
                    <input type="text" class="form-control" id="password" placeholder="Enter password" name="password">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-primary">Create Account</button>
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
