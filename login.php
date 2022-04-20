<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL database.
 * Login page/ uses a user database table to authenticate username and password
 */
$title = "Bookify Login";

if (isset($_GET["requireLogin"])) {
    echo "<p class='requireLogin'>You must be logged in to add to your collection.</p>";
}

include("resources/templates/header.php");
if (isset($_POST['submit'])) {
    include("lib/config.php");

    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // SHA1() calculates a SHA-1 160-bit checksum for the string
    //One of the possible uses for this function is as a hash key.
    //source - https://dev.mysql.com/doc/refman/8.0/en/encryption-functions.html#function_sha1

    $query = "SELECT accountId, accountType FROM account WHERE BINARY userName='" . $username . "' AND password=sha1('" . $password . "')";

    $result = $mysqli->query($query);
    //echo "query: ".$query."<br/>Num Rows: ".$result->num_rows;

    if ($result = $mysqli->query($query)) {
        // If result matched $username and $password, table row must be 1 row

        if ($result->num_rows == 1) {
            $account_data = $result->fetch_all(MYSQLI_ASSOC);

            // Register $username, $password and redirect to file "index.php"
            $_SESSION["username"] = $username;
            $_SESSION["accountId"] = $account_data[0]["accountId"];
            $_SESSION["accountType"] = $account_data[0]["accountType"];

            // set a session variable that is checked for
            // at the beginning of any of your secure .php pages
            $_SESSION["loggedIn"] = true;

            header("location:index.php");
        } else {
            //echo "<script type='text/javascript'>alert('User Name Or Password Invalid!')</script>";
            //echo '<script type="text/javascript">error();</script>';
            $location = $_SERVER['PHP_SELF'] . "?message=loginError";
            header("Location:" . $location);
        }
    } else {
        echo "<div class=\"alert alert-danger\" role =\"alert\">" . "ERROR: Could not able to execute $sql. " . $mysqli->error . "</div>";
    }

}
?>
<body>
<div class="login-form">
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
<!--    <form action="login.php" method="post">-->
    <h2 class="text-center">Login</h2>
        <?php if (isset($_GET["message"])) {

            if ($_GET["message"] == "loginError") {

                echo '<p class="error">Invalid Login</p>';

            } else if ($_GET["message"] == "logout") {
                //id="error" style="color: blue;"

                echo '<p class="goodbye">Goodbye ' . $_GET["userName"] . '</class>';

            } else if ($_GET["message"] == "notLoggedIn") {
                echo '<p class="error">You must login</p>';

            }
        }
        ?>
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Log in</button>
        </div>

        <div class="form-group">
            <a href="createAccount.php">Create an Account</a>
        </div>

    </form>
</div>
</body>
<?php include("resources/templates/footer.php"); ?>
</html>



