<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL database.
 * Login page/ uses a user database table to authenticate username and password
 */
$title = "Bookify Edit Account";

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
<form action="updateAccount.php" method="post">
<!--    <form action="login.php" method="post">-->
    <h2 class="text-center">Update Account</h2>
        <div class="form-group">
            <input type="text" name="username" class="form-control" value='<?php echo $userName ?>' placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" value='<?php echo $password ?>' placeholder="Password" required="required">
            Please re-enter your password when you update your account.
        </div>
        <div class="form-group">
            <input type="hidden" class="form-control" id="accountId" value='<?php echo $accountId ?>'  name="accountId">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </form>
</div>
</body>
<?php include("resources/templates/footer.php"); ?>
</html>
<?php
?>


