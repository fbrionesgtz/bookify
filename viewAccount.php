<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL database.
 * Login page/ uses a user database table to authenticate username and password
 */
$title = "Bookify View Account";

include("resources/templates/header.php");
if (isset($_GET['accountId'])) {

    $accountId = $_GET['accountId'];

    include("lib/config.php");

    $accountId = $mysqli->real_escape_string($accountId);

    $query = "SELECT * FROM account WHERE account.accountId = $accountId";
	$result = $mysqli->query($query);

    $num_results = $result->num_rows;

    if ($num_results == 0) {
        $message = "Account not found.";
    } else {
        $row = $result->fetch_assoc();
        $userName = $row['userName'];
        $password = $row['password'];
    }

    $result->free();
    $mysqli->close();
} else {
    //the id is not provided
    $message = "Sorry, no id provided.";
}
?>

<body>
<div class="login-form">
    <form>
<!--    <form action="login.php" method="post">-->
    <h2 class="text-center">View Account</h2>
        <div class="form-group">
            <input type="text" name="username" class="form-control" value='<?php echo $userName ?>' placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" value='<?php echo $password ?>' placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <a href="editAccount.php?accountId=<?php echo $accountId ?>">Edit Account</a>
        </div>
        <div class="form-group">
            <a href="deleteAccount.php?accountId=<?php echo $accountId ?>">Delete Account</a>
        </div>
    </form>
</div>
</body>
<?php include("resources/templates/footer.php"); ?>
</html>
<?php
?>


