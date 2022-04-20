<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Logout page, the only way to destroy the session is by clicking logout.
 */

include("resources/templates/header.php");
// check for logged in session
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    // user is not logged in
    // re-direct user to login_old.php
    header("Location: login.php");
    exit;
} else {
    //Set username from $_SESSION associative array
    $userName = $_SESSION["username"];

    // Remove all of the session variables.
    session_unset();

// Delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

// Destroy the session
    if (session_destroy()) {
        //Go back to the homepage
        header("Location: index.php");
        exit;
    }

}