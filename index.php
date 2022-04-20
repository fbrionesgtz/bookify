<?php
/**
 * @author jwhittaker
 * @since 12072021
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Users can be authenticated (login) and will have CRUD functionality without ever having to see the database itself.
 * Unauthorized users can see the books but cannot make changes.
 */

$title = "Bookify Homepage";
require("lib/config.php");
include('./bo/api/ApiConfig.php');
include("resources/templates/header.php");

$apiKey = "AIzaSyB42BQBNzq26kjwifWZ8Sc58a9y7oE7WiE";

$categories = ["action", "fiction", "comedy", "manga", "kids"];
$categoryEndPoint = "https://www.googleapis.com/books/v1/volumes?q=subject:";

$api_categories_config = new ApiConfig($categoryEndPoint, $apiKey, "categories");
$categories_data = $api_categories_config->fetchData($categories);

if (isset($_POST["btnSearch"]) && isset($_POST["inputSearch"])) {
    $search = preg_replace('/\s+/', '+', $_POST["inputSearch"]);
    $apiEndpoint = "https://www.googleapis.com/books/v1/volumes?q=" . $search . "&printType=books&key=";

    $api_search_config = new ApiConfig($apiEndpoint, $apiKey, "search");
    $search_data = $api_search_config->fetchData();
}

if (isset($_SESSION["loggedIn"])) {
    if (isset($_GET["add_id"]) && $_SESSION["loggedIn"]) {
        $query = "insert into book (apiId) 
                select '".$_GET["add_id"]."' where not exists (select bookId from book where apiId = '".$_GET["add_id"]."');
                
                insert into collection (accountId) 
                select '".$_SESSION["accountId"]."' where not exists (select accountId from account where account.accountId = '".$_SESSION["accountId"]."');
                
                insert into collection_item (collection_item.bookId, collection_item.collectionId)
                values (
                (select bookId 
                from book 
                where book.apiId = '".$_GET["add_id"]."'), 
                (select collection.collectionId 
                from collection, account 
                where account.accountId = ".$_SESSION["accountId"]." and account.accountId = collection.accountId))";
        $result = $mysqli->query($query);

        if(isset($result)) {
            echo "<p class='bookAddedToCollection'>Book added to collection successfully.</p>";
            echo $query;
        }
    } else if (!$_SESSION["loggedIn"] && isset($_GET["add_id"])) {
        header("Location: login.php?requireLogin=true");
        exit();
    }
}

?>
<body>
<div id="container">
    <div id="mainArea">
        <?php
        if (isset($_POST["btnSearch"])
        && isset($_POST["inputSearch"])
        && strlen(isset($_POST["inputSearch"])) > 0
        && $_POST["inputSearch"] !== "") {

        echo "<h1 class='categoryTitle'>Search Results</h1>
            <div class='bookListGrid'>";
        if (isset($search_data)) {
            foreach ($search_data as $book) {
                @$id = $book->id;
                @$volume_data = $book->volumeInfo;
                @$image = $volume_data->imageLinks->thumbnail;
                @$description = strlen($volume_data->description) > 0 ? $volume_data->description : "Description not available.";
                @$rating = $volume_data->averageRating;

                echo "<div class='bookItem'>
                        <img src='$image'/>
                        <div class='bookItemContent'>
                        <p>" . $description . "</p>
                            <div class='rating'>";
                echo $rating > 1 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 2 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 3 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 4 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 5 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo "</div>
                        <a class='btn btnPrimary' href='bookDetails.php?id=" . $id . "'>See Details</a>
                        <a class='btn btnGhost' href='collection.php?ctx=add&add_id=" . $id . "'>Add to Collection</a>
                      </div>
                    </div>";
            }
        }
        ?>
    </div>
</div>
<?php
include("resources/templates/footer.php");
exit();
} else { ?>
    <section>
        <?php
        $i = 0;
        foreach ($categories_data as $category_data => $category) {
            echo "<h1 class='categoryTitle'>" . ucfirst($categories[$i]) . "</h1>";
            echo "<div class='bookListGrid'>";
            foreach ($category[$categories[$i]] as $book) {
                @$id = $book->id;
                @$volume_data = $book->volumeInfo;
                @$image = $volume_data->imageLinks->thumbnail;
                @$description = strlen($volume_data->description) > 0 ? $volume_data->description : "Description not available.";
                @$rating = $volume_data->averageRating;

                echo "<div class='bookItem'>
                        <img src='$image'/>
                        <div class='bookItemContent'>
                        <p>" . $description . "</p>
                            <div class='rating'>";
                echo $rating > 1 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 2 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 3 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 4 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo $rating > 5 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
                echo "</div>
                        <a class='btn btnPrimary' href='bookDetails.php?id=" . $id . "'>See Details</a>
                        <a class='btn btnGhost' href='collection.php?ctx=add&add_id=" . $id . "'>Add to Collection</a>
                      </div>
                    </div>";

                if (isset($_POST["btnBookDetails" . $id])) {
                    header("Location: bookDetails.php?id=" . $id);
                    exit();
                }
            }
            echo "</div>";
            $i++;
        }
        ?>
    </section>
    </div>
    </div>
    <?php
    include("resources/templates/footer.php");
}
?>
</body>